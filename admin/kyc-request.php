<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$sel_qry = "SELECT COUNT(*) as total, 
                (SELECT COUNT(*) FROM kyc_request WHERE kyc_status=:kyc_approved_status) as approved, 
                (SELECT COUNT(*) FROM kyc_request WHERE kyc_status=:kyc_pending_status) as pending,
                (SELECT COUNT(*) FROM kyc_request WHERE kyc_status=:kyc_decline_status) as decline,
                (SELECT COUNT(*) FROM kyc_request WHERE created_at >= NOW() - INTERVAL 1 DAY) as last_get
            FROM kyc_request";
$sel_qry_prepare = $conn->prepare($sel_qry);
$sel_qry_prepare->execute([":kyc_approved_status" => 'approved', ":kyc_pending_status" => 'pending', ":kyc_decline_status" => 'decline']);
$fetch_data = $sel_qry_prepare->fetch();
// print_r($fetch_users_data);
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
$page = "kyc-request";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Manager KYC Request</div>
            <!-- END: Breadcrumb -->
            <?php include('layout/topbar.php') ?>
        </div>
        <div class="grid grid-cols-12 gap-6">
            <div class="col-span-12 xxl:col-span-9">
                <div class="grid grid-cols-12 gap-6">
                    <!-- BEGIN: User Report -->
                    <div class="col-span-12 mt-8">
                        <div class="intro-y flex items-center h-10">
                            <h2 class="text-lg font-medium truncate mr-5">
                                User KYC Report
                            </h2>
                            <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="users" class="report-box__icon text-theme-1"></i>
                                            <!-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> -->
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['total']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Total KYC Request</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-check" class="report-box__icon text-theme-9"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['approved']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Approved Request</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-x" class="report-box__icon text-theme-6"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['decline']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Declined Request</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-minus" class="report-box__icon text-theme-11"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['pending']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Pending Request</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-4 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="user-plus" class="report-box__icon text-theme-3"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['last_get']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Total KYC Req. (Last 24 Hours)</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END: User Report -->
                    <!-- BEGIN: Weekly Top Products -->
                    <div class="col-span-12 mt-6">
                        <div class="overflow-x-auto">
                            <div class="table-auto">
                                <table id="manage_table" class="display" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Name</th>
                                            <th>UserName</th>
                                            <th>E-mail</th>
                                            <th>Country</th>
                                            <th>Doc. Type</th>
                                            <th>Doc. No.</th>
                                            <th>Description</th>
                                            <th>Doc. Image</th>
                                            <th>Status</th>
                                            <th>Region</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- END: Weekly Top Products -->
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
                    'url': 'ajax/kyc/server-processing.php'
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
                'columnDefs': [{
                    'targets': [4, 8, 10], // column index (start from 0)
                    'orderable': false, // set orderable false for selected columns
                }],
                'columns': [{
                    data: 'id'
                }, {
                    data: 'name'
                }, {
                    data: 'username'
                }, {
                    data: 'email'
                }, {
                    data: 'country'
                }, {
                    data: 'doc_name'
                }, {
                    data: 'doc_number'
                }, {
                    data: 'description'
                }, {
                    data: 'doc_img'
                }, {
                    data: 'kyc_status'
                }, {
                    data: 'decline_region'
                }, {
                    data: 'action'
                }]
            });
        }

        const updateKYC = (id, status) => {
            if (Number.isInteger(id) && id != '' && (status == 'approved' || status == 'decline')) {
                $.ajax({
                    type: "POST",
                    url: "ajax/kyc/getKYC.php",
                    data: {
                        id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            let text = '';
                            if (status == 'decline') {
                                region = prompt("Please Enter Decline Region?", "");
                                if (region != null && region != "") {
                                    text = region;
                                } else {
                                    text = 'decline_region_cancel';
                                }
                            } else {
                                text = '';
                            }
                            $.ajax({
                                type: "POST",
                                url: "ajax/kyc/updateKYC.php",
                                data: {
                                    id,
                                    status,
                                    text
                                },
                                dataType: "JSON",
                                success: function(response) {
                                    if (response.result == 1) {
                                        toastr['success']("Data " + status +" Successfully..");
                                        setInterval(() => {
                                            window.location.reload();
                                        }, 1500);
                                    } else if (response.result == 'not_exist') {
                                        toastr['error']("Document Name is Already Exist..");
                                    } else if (response.result == 'validation_err') {
                                        toastr['error']("Validations Error Found..");
                                    } else if (response.result == "data_err") {
                                        toastr['error']("Connection Issue..");
                                    } else if (response.result == "request_err") {
                                        toastr['error']("Data Request Error..");
                                    } else {
                                        toastr['error']("Something Went Wrong..");
                                    }
                                }
                            });
                        } else {
                            toastr['error']("KYC Not Found..");
                            setInterval(() => {
                                window.location.reload();
                            }, 2000);
                        }
                    }
                });
            }
        }
    </script>
    <!-- END: JS Assets-->
</body>

</html>