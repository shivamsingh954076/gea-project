<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
if (!isset($_SESSION['edit_doc_id'])) {
    echo "<script>history.back();</script>";
    die();
}
$sel_qry = $conn->prepare("SELECT * FROM document WHERE id=:id AND active=1");
$sel_qry->execute([":id" => $_SESSION['edit_doc_id']]);
$fetch_data = $sel_qry->fetch();
if ($sel_qry->rowCount() != 1) {
    echo "<script>history.back();</script>";
    die();
}
$page = "manage-document";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit Document</div>
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
                                    Edit Document Data
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Document Name <span class="text-theme-6">*</span></label>
                                        <input id="doc_name" name="doc_name" type="text" class="form-control" placeholder="Enter Document Name (Ex: National ID Card)" value="<?php echo $fetch_data['doc_name']; ?>">
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
        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            // Get Data
            let doc_name = $("#doc_name").val().trim(),
                description = $("#description").val().trim(),
                status = parseInt($("#status").val());
            if (doc_name != '' && doc_name.length >= 2 && doc_name.length <= 100 && country_name_regx.test(doc_name) && (status == 1 || status == 0)) {
                let form = new FormData($(this)[0]);
                form.append("doc_id", <?php echo $_SESSION['edit_doc_id'] ?>);
                $.ajax({
                    type: "POST",
                    url: "ajax/document/updateDocument.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Updated Successfully..");
                            setInterval(() => {
                                location.reload();
                            }, 1500);
                        } else if (response.result == 'not_exist') {
                            toastr['error']("Document No. Not Exist..");
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
            } else if (doc_name == '' || doc_name.length < 2 || doc_name.length > 100 || !(country_name_regx.test(doc_name))) {
                if (doc_name == '') {
                    toastr['error']("Document Name is Mandatory..");
                } else if (doc_name.length < 2) {
                    toastr['error']("Document Name is too Short..");
                } else if (doc_name.length > 100) {
                    toastr['error']("Document Name is too long..");
                } else if (!(country_name_regx.test(doc_name))) {
                    toastr['error']("Document Name is invalid..");
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