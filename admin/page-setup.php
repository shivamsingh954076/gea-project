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
if (isset($_GET['page_name'])) {
    $page_name = $_GET['page_name'];
    $page_qry_chk = $conn->prepare("SHOW COLUMNS FROM `pages` WHERE COLUMNS.Field = '$page_name'");
    $page_qry_chk->execute();
    $page_res_chk = $page_qry_chk->fetch();
    if (isset($page_res_chk) && $page_res_chk != '') {
        $chk = $conn->prepare("SELECT $page_name FROM pages WHERE id=:id");
        $chk->execute([":id" => 1]);
        $fetch_data = $chk->fetch();
        $fetch_page = (array)json_decode($fetch_data[$page_name]);
        $title = $fetch_page['title'];
        $content = $fetch_page['content'];
        $status = $fetch_page['status'];
    } else {
        echo "<script>history.back();</script>";
        die();
    }
} else {
    echo "<script>history.back();</script>";
    die();
}
$page = $_GET['page_name'];
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit <?php echo $title; ?></div>
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
                                    <?php echo $title; ?>
                                </h2>
                            </div>
                            <form id="form_data">
                                <!-- For Title -->
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 px-5">
                                        <label for="" class="form-label">Title</label>
                                        <input id="title" name="title" type="text" class="form-control" placeholder="Enter Title" value="<?php echo $title; ?>">
                                    </div>
                                    <!-- BEGIN: Standard Editor -->
                                    <div class="col-span-12">
                                        <div class="box">
                                            <div class="p-5" id="standard-editor">
                                                <div class="">
                                                    <div class="">
                                                        <textarea name="DSC" id="DSC" class="materialize-textarea"><?php echo $content; ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- For Status -->
                                    <div class="mt-2 col-span-12 lg:col-span-6 px-5">
                                        <label for="" class="form-label">Status</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" name="status" id="status">
                                                <?php
                                                $active_stat = [1, 0];
                                                if ($status == 0) {
                                                    $stat = 'In-Active';
                                                } else {
                                                    $stat = 'Active';
                                                }
                                                foreach ($active_stat as $as) {
                                                ?>
                                                    <option value="<?php echo $as; ?>" <?php if ($as == $status) {
                                                                                            echo "selected";
                                                                                        } ?>><?php if ($as == 1) {
                                                                                                    echo "Active";
                                                                                                } else {
                                                                                                    echo "In-Active";
                                                                                                } ?></option>
                                                <?php } ?>
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
        CKEDITOR.replace('DSC');

        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            var pageNameRegx = /^([a-zA-Z0-9 &_-]+)$/;
            let title = $("#title").val().trim(),
                content = CKEDITOR.instances['DSC'].getData(),
                status = parseInt($("#status").val());
            if (title != '' && title.length >= 2 && title.length <= 25 && pageNameRegx.test(title) && content != '' && (status == 1 || status == 0)) {
                $.ajax({
                    type: "POST",
                    url: "ajax/pageSetup/updatePage.php",
                    data: {
                        title,
                        content,
                        status,
                        page_name: "<?php echo $page_name; ?>"
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Updated Successfully..");
                            setInterval(() => {
                                location.reload();
                            }, 1500);
                        } else if (response.result == 'not_available') {
                            toastr['success']("Data Not Found..");
                        } else {
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