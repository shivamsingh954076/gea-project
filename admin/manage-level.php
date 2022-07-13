<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$sel_qry =  $conn->prepare("SELECT COUNT(*) as total_level, 
                (SELECT COUNT(*) FROM level WHERE active=:level_active) as level_active, 
                (SELECT COUNT(*) FROM level WHERE active=:level_in_active) as level_in_active,
                (SELECT COUNT(*) FROM level WHERE created_at >= NOW() - INTERVAL 1 DAY) as level_last_get
            FROM level");
$sel_qry->execute([":level_active" => 1, ":level_in_active" => 0]);
$fetch_data = $sel_qry->fetch();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
$page = "manage-level";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Manage Level</div>
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
                                Level Report
                            </h2>
                            <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                            <button onclick="addNewData('add-level')" class="btn btn-rounded-primary ml-3 mr-1 px-3"><i data-feather="plus-circle" class="report-box__icon text-theme-0 mr-3"></i> Add New Level</button>
                        </div>
                        <div class="grid grid-cols-12 gap-6 mt-5">
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="box" class="report-box__icon text-theme-1"></i>
                                            <!-- <div class="ml-auto">
                                                <div class="report-box__indicator bg-theme-9 tooltip cursor-pointer" title="33% Higher than last month"> 33% <i data-feather="chevron-up" class="w-4 h-4 ml-0.5"></i> </div>
                                            </div> -->
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['total_level']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Total Levels</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="box" class="report-box__icon text-theme-9"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['level_active']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">Active Levels</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="box" class="report-box__icon text-theme-6"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['level_in_active']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">In-Active Level</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-12 sm:col-span-6 xl:col-span-3 intro-y">
                                <div class="report-box zoom-in">
                                    <div class="box p-5">
                                        <div class="flex">
                                            <i data-feather="box" class="report-box__icon text-theme-3"></i>
                                        </div>
                                        <div class="text-3xl font-bold leading-8 mt-6"><?php echo $fetch_data['level_last_get']; ?></div>
                                        <div class="text-base text-gray-600 mt-1">New Levels (Last 24 Hours)</div>
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
                                            <th>Level Name</th>
                                            <th>Image</th>
                                            <th>Level No.</th>
                                            <th>Token Needed</th>
                                            <th>Description</th>
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
                    'url': 'ajax/level/server-processing.php'
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
                    data: 'level_name'
                }, {
                    data: 'img'
                }, {
                    data: 'level_no'
                }, {
                    data: 'total_token'
                }, {
                    data: 'description'
                }, {
                    data: 'active'
                }, {
                    data: 'action'
                }]
            });
        }

        const deleteLevel = (id) => {
            if (Number.isInteger(id) && id != '') {
                if (confirm("Are You Sure, You Want to Delete?")) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/level/getLevel.php",
                        data: {
                            id
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.result == 1) {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/level/deleteLevel.php",
                                    data: {
                                        id
                                    },
                                    dataType: "JSON",
                                    success: function(resp) {
                                        if (response.result == 1) {
                                            toastr['success']("Level deleted Successfully..");
                                            setInterval(() => {
                                                window.location.reload();
                                            }, 2000);
                                        } else {
                                            toastr['error']("Something Went Wrong..");
                                        }
                                    }
                                });
                            } else {
                                toastr['error']("Level Not Found..");
                                setInterval(() => {
                                    window.location.reload();
                                }, 2000);
                            }

                        }
                    });
                }
            }
        }

        const editLevel = (id) => {
            if (Number.isInteger(id) && id != '') {
                $.ajax({
                    type: "POST",
                    url: "ajax/level/getLevel.php",
                    data: {
                        id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            window.location.href = 'edit-level';
                        } else {
                            toastr['error']("Level Not Found..");
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