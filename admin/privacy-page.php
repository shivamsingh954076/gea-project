<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
// if (!isset($_SESSION['edit_gea_product_id'])) {
//     echo "<script>history.back();</script>";
//     die();
// }
$chk = $conn->prepare("SELECT terms_conditions FROM pages");
$chk->execute();
$fetch_data = $chk->fetch();
if($fetch_data >= 1){
    $fetch_terms = json_decode($fetch_data['terms_conditions']);
}
$page = "terms-page";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit Terms & Conditions</div>
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
                                    Terms & Conditions
                                </h2>
                            </div>
                            <form id="form_data">
                                <!-- For Title -->
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 px-5">
                                        <label for="" class="form-label">Title</label>
                                        <input id="title" name="title" type="text" class="form-control" placeholder="Enter Title" value="<?php echo @$fetch_terms->title; ?>">
                                    </div>
                                    <!-- BEGIN: Standard Editor -->
                                    <div class="col-span-12">
                                        <div class="box">
                                            <div class="p-5" id="standard-editor">
                                                <div class="">
                                                    <div class="">
                                                        <textarea name="DSC" id="DSC" class="materialize-textarea"><?php echo @$fetch_terms->content; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
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
        CKEDITOR.replace('DSC');

        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            let title = $("#title").val().trim(),
                content = CKEDITOR.instances['DSC'].getData();
            if (title != '' && content != '') {
                $.ajax({
                    type: "POST",
                    url: "ajax/terms-page/insert.php",
                    data: {
                        title,
                        content
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Terms & Conditions Set Successfully..");
                        }else{
                            toastr['error']("Something Went Wrong..");
                        }
                    }
                });
            }
        });
    </script>
    <!-- END: JS Assets-->
</body>

</html>