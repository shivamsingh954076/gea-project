<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
if (!isset($_SESSION['edit_level_id'])) {
    echo "<script>history.back();</script>";
    die();
}
$sel_qry = $conn->prepare("SELECT * FROM level WHERE id=:id AND active=1");
$sel_qry->execute([":id" => $_SESSION['edit_level_id']]);
$fetch_data = $sel_qry->fetch();
if ($sel_qry->rowCount() != 1) {
    echo "<script>history.back();</script>";
    die();
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
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit Level</div>
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
                                    Edit Level Data
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Level Name <span class="text-theme-6">*</span></label>
                                        <input id="level_name" name="level_name" type="text" class="form-control" placeholder="Enter Level Name (Ex: GEA Ally)" value="<?php echo $fetch_data['level_name']; ?>">
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Level Number <span class="text-theme-6">*</span></label>
                                        <input id="level_number" name="level_number" type="text" class="form-control only_digits" placeholder="Enter Level Number (Ex: 7)" value="<?php echo $fetch_data['level_no']; ?>">
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Token Needed <span class="text-theme-6">*</span></label>
                                        <input id="level_token" name="level_token" type="text" class="form-control" placeholder="Enter GSA Token (Ex: 50)" value="<?php echo $fetch_data['total_token']; ?>">
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Image</label>
                                        <div class="fallback">
                                            <input type="file" id="upload_file" name="img" />
                                        </div>
                                    </div>
                                    <!-- For Description -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Description</label>
                                        <input id="description" name="description" type="text" class="form-control" placeholder="Enter Description" value="<?php echo $fetch_data['description']; ?>">
                                    </div>
                                    <!-- For Status -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Status</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" name="status" id="status">
                                                <?php
                                                $active_status = [1, 0];
                                                if ($fetch_data['active'] == 0) {
                                                    $status = 'In-Active';
                                                } else {
                                                    $status = 'Active';
                                                }
                                                foreach ($active_status as $as) {
                                                ?>
                                                    <option value="<?php echo $as; ?>" <?php if ($as == $fetch_data['active']) {
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
                                        <button class="btn btn-primary mt-2 hidden" id="submit_button" type="submit">Update</button>
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
        // Only Digits Allow
        $('.only_digits').keypress(function(e) {
            var a = [];
            var k = e.which;
            for (i = 48; i < 58; i++) {
                a.push(i);
            }
            if (!(a.indexOf(k) >= 0)) {
                e.preventDefault();
            }
            var txt = $("#level_number").val().trim();
            if (txt.length == 5) {
                e.preventDefault();
            }
        });
        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            // Get Data
            let level_name = $("#level_name").val().trim(),
                level_number = $("#level_number").val().trim(),
                level_token = $("#level_token").val().trim(),
                description = $("#description").val().trim(),
                status = parseInt($("#status").val());
            if (level_name != '' && level_name.length >= 2 && level_name.length <= 100 && country_name_regx.test(level_name) && level_number != '' && level_number.length >= 1 && level_number.length <= 5 && mobileRegx.test(level_number) && level_token != '' && level_token.length >= 1 && level_token.length <= 10 && (status == 1 || status == 0)) {
                let form = new FormData($(this)[0]);
                form.append("level_id", <?php echo $_SESSION['edit_level_id'] ?>)
                $.ajax({
                    type: "POST",
                    url: "ajax/level/updateLevel.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Updated Successfully..");
                            document.getElementById("form_data").reset();
                        } else if (response.result == 'level_not_exist') {
                            toastr['error']("Level No. Not Exist Exist..");
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
            } else if (level_name == '' || level_name.length < 2 || level_name.length > 100 || !(country_name_regx.test(level_name))) {
                if (level_name == '') {
                    toastr['error']("Level Name is Mandatory..");
                } else if (level_name.length < 2) {
                    toastr['error']("Level Name is too Short..");
                } else if (level_name.length > 100) {
                    toastr['error']("Level Name is too long..");
                } else if (!(country_name_regx.test(level_name))) {
                    toastr['error']("Level Name is invalid..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if (level_number == '' || level_number.length < 1 || level_number.length > 5 || !(mobileRegx.test(level_number))) {
                if (level_number == '') {
                    toastr['error']("Level No. is Mandatory..");
                } else if (level_number.length < 1) {
                    toastr['error']("Level No. is too Short..");
                } else if (level_number.length > 5) {
                    toastr['error']("Level No. is too long..");
                } else if (!(mobileRegx.test(level_number))) {
                    toastr['error']("Level No. is invalid..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if (level_token == '' || level_token.length < 1 || level_token.length > 10) {
                if (level_token == '') {
                    toastr['error']("Level ToKen is Mandatory..");
                } else if (level_token.length < 1) {
                    toastr['error']("Level ToKen is too Short..");
                } else if (level_token.length > 10) {
                    toastr['error']("Level ToKen is too long..");
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