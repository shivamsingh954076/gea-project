<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
$get_country = $conn->prepare("SELECT * FROM countries WHERE active=1");
$get_country->execute();
$country_data = $get_country->fetchAll();

$get_doc = $conn->prepare("SELECT * FROM document WHERE active=1");
$get_doc->execute();
$doc_data = $get_doc->fetchAll();
$page = "manage-country-document";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="index">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="manage-country-document" class="">Manage </a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Attach Documents With Country</a></div>
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
                                    Add New Document With Country Data
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" id="country_select" name="country_select">
                                                <?php
                                                foreach ($country_data as $cd) {
                                                ?>
                                                    <option name="" value="<?php echo (int)$cd['id']; ?>"><?php echo $cd['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Document</label>
                                        <select data-placeholder="Select Document.." name="doc[]" class="w-full" id="doc_sel" multiple>
                                            <?php foreach ($doc_data as $dd) { ?>
                                                <option value="<?php echo $dd['id'] ?>"><?php echo $dd['doc_name'] ?></option>
                                            <?php } ?>
                                        </select>
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
        // $("#country_select").select2();
        $('#doc_sel').select2();
        $(window).ready(function() {
            $("#submit_button").removeClass("hidden");
        });
        $("#country_select").on("change", function() {
            let country_id = this.value;
            $.ajax({
                type: "POST",
                url: "ajax/country_document/getDocument.php",
                data: {
                    id: country_id
                },
                dataType: "JSON",
                success: function(response) {
                    if (response.result == 1) {
                        let resp = response.document_data;
                        let doc_html = '';
                        $(resp).each(function(index) {
                            let doc_id = this.doc_id;
                            let doc_name = this.doc_name;
                            $(`#doc_sel option[value='${doc_id}']`).attr("selected", true);
                        });
                    }
                }
            });
        });

        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            let country_select = parseInt($("#country_select").val().trim()),
                doc_sel = $("#doc_sel").val(),
                status = parseInt($("#status").val());
            if (country_select != '' && mobileRegx.test(country_select) && doc_sel.length >= 1 && (status == 1 || status == 0)) {
                let form = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: "ajax/country_document/addCountryDoc.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Inserted Successfully..");
                            // document.getElementById("form_data").reset();
                        } else if (response.result == '_exist') {
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
            } else if (country_select == '' || !(mobileRegx.test(country_select))) {
                if (country_select == '') {
                    toastr['error']("Country Can\'t be Blank..");
                } else if (!(mobileRegx.test(country_select))) {
                    toastr['error']("Country is invalid..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if (doc_sel.length < 1) {
                toastr['error']("Please Select Document..");
            } else {
                toastr['error']("Something Went Wrong..");
            }
        });
    </script>
    <!-- END: JS Assets-->
</body>

</html>