<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

// print_r($fetch_users_data);
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
$page = "manage-pages";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Manager Pages</div>
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
                                Manage Pages
                            </h2>
                            <a href="" class="ml-auto flex items-center text-theme-1 dark:text-theme-10"> <i data-feather="refresh-ccw" class="w-4 h-4 mr-3"></i> Reload Data </a>
                            <button onclick="addNewData('add-new-page')" class="btn btn-rounded-primary ml-3 mr-1 px-3"><i data-feather="plus-circle" class="report-box__icon text-theme-0 mr-3"></i> Create New Page</button>
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
                                            <th>Page Name</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $page_tbl = $conn->prepare("SHOW COLUMNS FROM `pages` WHERE COLUMNS.Field <> 'id'");
                                        $page_tbl->execute();
                                        $page_tbl_res = $page_tbl->fetchAll();
                                        $i = 1;
                                        foreach ($page_tbl_res as $pg) {
                                            $page_tbl_data = $conn->prepare("SELECT {$pg['Field']} FROM `pages` WHERE id=:id");
                                            $page_tbl_data->execute([":id" => 1]);
                                            $page_tbl_data_fetch = $page_tbl_data->fetch();
                                            $fetch_page = (array)json_decode($page_tbl_data_fetch[$pg['Field']]);
                                            if ($fetch_page['status'] == 1) {
                                                $status = 'Active';
                                            } else {
                                                $status = 'In-Active';
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-center"><?php echo $i; ?></td>
                                                <td class="text-center"><?php echo $fetch_page['title']; ?></td>
                                                <td class="text-center"><?php echo $status; ?></td>
                                                <td class="text-center">
                                                    <button class="btn btn-warning btn-xs updateData mx-2" onclick="goToPageEdit('<?php echo $pg['Field']; ?>')">EDIT</button>
                                                    <button class="btn btn-danger btn-xs updateData" onclick="deletePage('<?php echo $pg['Field']; ?>')">DELETE</button>
                                                </td>
                                            </tr>
                                        <?php $i++;
                                        } ?>
                                    </tbody>
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
        $('#manage_table').DataTable();

        const goToPageEdit = (data) => {
            window.location.href = 'page-setup/' + data;
        }
        const deletePage = (name) => {
            if (name != '') {
                if (confirm("Are You Sure, You Want to Delete?")) {
                    $.ajax({
                        type: "POST",
                        url: "ajax/pages/deletePage.php",
                        data: {
                            name
                        },
                        dataType: "JSON",
                        success: function(response) {
                            if (response.result == 1) {
                                toastr['success']("Page deleted Successfully..");
                                setInterval(() => {
                                    window.location.reload();
                                }, 2000);
                            } else if (response.result == 'not_found') {
                                toastr['error']("Page Not Found..");
                            } else {
                                toastr['error']("Something Went Wrong..");
                            }
                        }
                    });
                }
            }
        }

        const editUser = (id) => {
            if (Number.isInteger(id) && id != '') {
                $.ajax({
                    type: "POST",
                    url: "ajax/users/manage-users/getUser.php",
                    data: {
                        id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            window.location.href = 'edit-user';
                        } else {
                            toastr['error']("User Not Found..");
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