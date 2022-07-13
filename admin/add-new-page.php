<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
$page = "add-new-page";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Add New Page</div>
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
                                    Add New Page
                                </h2>
                            </div>
                            <form id="form_data">
                                <!-- For Title -->
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Page Name <span class="text-theme-6">*</span></label>
                                        <input id="name" name="name" type="text" class="form-control" placeholder="Enter Page Name (Ex: Terms & Conditions)">
                                    </div>
                                    <!-- For Status -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Status</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" name="status" id="status">
                                                <option value="1" selected>Active</option>
                                                <option value="0">In-Active</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-12 flex justify-center	">
                                        <button class="btn btn-primary mt-2 hidden" id="submit_button" type="submit">Submit</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <!-- END: Vertical Form -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content -->
    </div>
    <?php include('layout/footerbar.php') ?>
    <script>
        $(window).ready(function() {
            $("#submit_button").removeClass("hidden");
        });

        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            var pageNameRegx = /^([a-zA-Z0-9 &_-]+)$/;
            let name = $("#name").val().trim(),
                status = parseInt($("#status").val());
            if (name != '' && name.length >= 2 && name.length <= 25 && pageNameRegx.test(name) && (status == 1 || status == 0)) {
                $.ajax({
                    type: "POST",
                    url: "ajax/pages/addNewPage.php",
                    data: {
                        name,
                        status
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            $('#form_data').trigger("reset");
                            toastr['success']("Page Created & Updated Successfully.. Check in Pages Section");
                            setInterval(() => {
                                window.location.href = 'page-setup/'+response.page_name;
                            }, 1500);
                        } else if(response.result == 'max_limit') {
                            toastr['error']("Limit Reached, Max. 7 Pages Allowed..");
                        } else{
                            toastr['error']("Something Went Wrong..");
                        }
                    }
                });
            } else if (name == '' || !(pageNameRegx.test(name)) || name.length < 2 || name.length > 25) {
                if (name == '') {
                    toastr['error']("Page Name is mandatory..");
                } else if (name.length < 2) {
                    toastr['error']("Page Name is too short..");
                } else if (name.length > 25) {
                    toastr['error']("Page Name is too large.. Maximum 25 Characters Allow..");
                } else if (pageNameRegx.test(name)) {
                    toastr['error']("Page Name is invalid.. No Special Chacters Allow Except (_ & -)");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else {
                toastr['error']("Something Went Wrong..");
            }
        });
    </script>
    <!-- END: JS Assets-->
</body>

</html>