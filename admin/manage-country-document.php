<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$sel_qry =  $conn->prepare("SELECT COUNT(*) as total, 
                (SELECT COUNT(*) FROM doc_countries WHERE active=:active) as active, 
                (SELECT COUNT(*) FROM doc_countries WHERE active=:in_active) as in_active,
                (SELECT COUNT(*) FROM doc_countries WHERE created_at >= NOW() - INTERVAL 1 DAY) as last_get
            FROM doc_countries");
$sel_qry->execute([":active" => 1, ":in_active" => 0]);
$fetch_data = $sel_qry->fetch();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
$page = "manage-country-document";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Manage Country Document</div>
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
                                Country & Document Data
                            </h2>
                            <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                            <button onclick="addNewData('add-country-document')" class="btn btn-rounded-primary ml-3 mr-1 px-3"><i data-feather="plus-circle" class="report-box__icon text-theme-0 mr-3"></i> Attach Documents With Country</button>
                        </div>
                    </div>
                    <!-- END: User Report -->
                    <!-- BEGIN: Weekly Top Products -->
                    <div class="col-span-12 mt-2">
                        <div class="overflow-x-auto">
                            <div class="table-auto">
                                <table id="manage_table" class="display" style="width: 100% !important;">
                                    <thead>
                                        <tr>
                                            <th>#ID</th>
                                            <th>Country Name</th>
                                            <th>Document Name</th>
                                            <th>Status</th>
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
                    'url': 'ajax/country_document/server-processing.php'
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
                    data: 'country_name'
                }, {
                    data: 'doc_name'
                }, {
                    data: 'active'
                }, {
                    data: 'action'
                }]
            });
        }

        const deleteCountryDocument = (id) => {
            if (Number.isInteger(id) && id != '') {
                if (confirm("Are You Sure, You Want to Delete?")) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/country_document/getCountryDoc.php",
                        data: {
                            id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.result == 1) {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/country_document/deleteCountryDoc.php",
                                    data: {
                                        id
                                    },
                                    dataType: "JSON",
                                    success: function(resp) {
                                        if (response.result == 1) {
                                            toastr['success']("Document deleted Successfully..");
                                            setInterval(() => {
                                                window.location.reload();
                                            }, 2000);
                                        } else {
                                            toastr['error']("Something Went Wrong..");
                                        }
                                    }
                                });
                            } else {
                                toastr['error']("Document Not Found..");
                                setInterval(() => {
                                    window.location.reload();
                                }, 2000);
                            }

                        }
                    });
                }
            }
        }

        const editCountryDocument = (id) => {
            if (Number.isInteger(id) && id != '') {
                $.ajax({
                    type: "POST",
                    url: "ajax/country_document/getCountryDoc.php",
                    data: {
                        id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            window.location.href = 'edit-country-document';
                        } else {
                            toastr['error']("Not Found..");
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