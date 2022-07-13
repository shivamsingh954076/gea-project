<?php
session_start();
include("../config/connect.php");
include("../config/function.php");
$database = new Connection();
$conn = $database->openConnection();
$userDetail = new UserDetail();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
if (!isset($_SESSION['txn_user_id'])) {
    echo "<script>history.back();</script>";
    die();
} else {
    $txnAmt = $userDetail->txnAmt($conn, $_SESSION['txn_user_id']);
    $totalTxn = $userDetail->totalTxn($conn, $_SESSION['txn_user_id'], '', '');
}

$sel_qry = $conn->prepare("SELECT user.*, country.currency AS currency, gea.value AS value FROM users AS user INNER JOIN countries AS country ON country.id = user.country_id INNER JOIN gea_currency AS gea ON gea.country_id=country.id WHERE user.id=:user_id AND user.user_active=:active");
$sel_qry->execute([":user_id" => $_SESSION['txn_user_id'], ":active" => 1]);
$fetch_data = $sel_qry->fetch();

if ($sel_qry->rowCount() != 1) {
    echo "<script>history.back();</script>";
    die();
}
$page = "user-balance";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">View User Transaction</div>
            <!-- END: Breadcrumb -->
            <?php include('layout/topbar.php') ?>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-9">
                <div class="">
                    <div class="intro-y col-span-12 lg:col-span-12">
                        <!-- BEGIN: Vertical Form -->
                        <div class="intro-y box col-span-12 lg:col-span-6">
                            <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                                <h2 class="font-medium text-base mr-auto">
                                    Transaction Report <span class="text-sm font-normal text-theme-9">(<?php echo $fetch_data['email']; ?>)</span>
                                </h2>
                                <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mt-5">
                                <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="zap" class="report-box__icon text-theme-1"></i>
                                                <!-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> -->
                                            </div>
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php echo $txnAmt . ' ' . $fetch_data['currency']; ?></div>
                                            <div class="text-base text-gray-600 mt-1">Available Balance</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="zap" class="report-box__icon text-theme-9"></i>
                                            </div>
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php echo number_format((float)($txnAmt / $fetch_data['value']), 2, '.', '') . ' GEA' ?></div>
                                            <div class="text-base text-gray-600 mt-1">Available Token</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                    <div class="report-box zoom-in">
                                        <div class="box p-5">
                                            <div class="flex">
                                                <i data-feather="activity" class="report-box__icon text-theme-8"></i>
                                            </div>
                                            <div class="text-3xl font-bold leading-8 mt-6"><?php echo $totalTxn; ?></div>
                                            <div class="text-base text-gray-600 mt-1">Total No. of Txn</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Vertical Form -->
                        <div class="col-span-12 mt-6">
                            <div class="overflow-x-auto">
                                <div class="table-auto">
                                    <table id="manage_table" class="display" style="width: 100% !important;">
                                        <thead>
                                            <tr>
                                                <th>#ID</th>
                                                <th>Amount (in <?php echo $fetch_data['currency']; ?>)</th>
                                                <th>Txn Type</th>
                                                <th>Status</th>
                                                <th>Txn Id</th>
                                                <th>Mode</th>
                                                <th>Send/Receive</th>
                                                <th>Txn Message</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->
    </div>
    <?php include('layout/footerbar.php') ?>
    <script>
        fetch_data();

        function fetch_data() {
            var dataTable = $('#manage_table').DataTable({
                'processing': true,
                'serverSide': true,
                'serverMethod': 'post',
                'ajax': {
                    'url': 'ajax/user_txn/server-processing.php'
                },
                "order": [
                    [0, "desc"]
                ],
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "columnDefs": [{
                    "className": "dt-center",
                    "targets": "_all"
                }],
                'columns': [{
                    data: 'id'
                }, {
                    data: 'amt'
                }, {
                    data: 'txn_type'
                }, {
                    data: 'txn_status'
                }, {
                    data: 'txn_id'
                }, {
                    data: 'mode'
                }, {
                    data: 'transfer_id'
                }, {
                    data: 'message'
                }]
            });
        }

        function viewTxnOther(id) {
            if (id != '' && Number.isInteger(id)) {
                $.ajax({
                    type: "POST",
                    url: "ajax/user_txn/getUser.php",
                    data: {
                        id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            window.location.reload();
                        } else if (response.result == 0) {
                            toastr['error']("Not Found");
                        } else {
                            toastr['error']("Something Went Wrong");
                        }
                    }
                });
            }
        }
    </script>
    <!-- END: JS Assets-->
</body>

</html>