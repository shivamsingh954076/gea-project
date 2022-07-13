<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}

$page = "add-gea-product";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="index">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="manage-gea-product" class="">Manage GEA Product</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Add New GEA Product</a></div>
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
                                    Add New GEA Product
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Product Name <span class="text-theme-6">*</span></label>
                                        <input id="name" name="name" type="text" class="form-control gea_name" placeholder="Enter Product Name (Ex: Green Energy)">
                                    </div>
                                    <!-- For Description -->
                                    <div class="mt-2 col-span-12 lg:col-span-6 hidden" id="gea_container">
                                        <label for="" class="form-label">1 GEA Value = <span id="gea_value_text"></span> <span id="gea_value_text"></span> <span class="text-theme-6">*</span></label>
                                        <input id="gea_value" name="gea_value" type="text" class="form-control decimal_validation" placeholder="Enter Value (Ex: 10)">
                                    </div>
                                    <!-- For Description -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Description</label>
                                        <input id="description" name="description" type="text" class="form-control" placeholder="Enter Description">
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
        $(".gea_name").keyup(function(){
            var name_val = $(this).val();
            let gea_val = $("#gea_value").val().trim();
            if(name_val.length >=2 && name_val.length <= 100 && nameRegx.test(name_val)){
                $("#gea_value_text").text(' ? ' + name_val);
                $("#gea_container").removeClass("hidden");
                if(gea_val != ''){
                    $("#gea_value_text").text(gea_val + ' ' + name_val);
                }
            }else{
                $("#gea_container").addClass("hidden");
            }
            if(!(nameRegx.test(name_val))){
                toastr['error']("Name is Invalid.. Special Characters Not Allow");
            }
        });
        $('.decimal_validation').keyup(function() {
            let prod_name = $("#name").val().trim();
            var val = $(this).val();
            if (isNaN(val)) {
                val = val.replace(/[^0-9\.]/g, '');
                if (val.split('.').length > 2)
                    val = val.replace(/\.+$/, "");
            }
            $(this).val(val);
            if (val.length > 0 && prod_name != '' && nameRegx.test(prod_name)) {
                $("#gea_value_text").text(val + ' ' + prod_name);
            } else {
                $("#gea_value_text").text(' ? ' + prod_name);
            }
            if (val > 999999) {
                $(this).val('');
                $("#gea_value_text").text(' ? ' + prod_name);
            }
        });

        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            let val_regx = /^[0-9]*(\.[0-9]{0,2})?$/;
            let name = $("#name").val().trim(),
                gea_value = $("#gea_value").val().trim(),
                description = $("#description").val().trim(),
                status = parseInt($("#status").val());
                console.log(name + ' ' + gea_value + ' ' + description + ' ' +status);
            if (val_regx.test(gea_value) && gea_value != '' && gea_value > 0 && name != '' && name.length >= 2 && name.length <= 100 && nameRegx.test(name) && (status == 1 || status == 0)) {
                let form = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: "ajax/geaProduct/addGeaProduct.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Inserted Successfully..");
                            setInterval(() => {
                                window.location.reload();
                            }, 1500);
                        } else if (response.result == '_exist') {
                            toastr['error']("Data is Already Exist..");
                        } else if (response.result == 'validation_err') {
                            toastr['error']("Validations Error Found..");
                        } else if (response.result == "data_err") {
                            toastr['error']("Connection Issue..");
                        } else {
                            toastr['error']("Something Went Wrong..");
                        }
                    }
                });
            } else if (name == '' || name.length < 2 || name.length > 100 || !(nameRegx.test(name))) {
                if (name == '') {
                    toastr['error']("Name is Mandatory..");
                } else if (name.length < 2) {
                    toastr['error']("Name is too shorter..");
                } else if (name.length > 100) {
                    toastr['error']("Name is too Large..");
                } else if (!(nameRegx.test(name))) {
                    toastr['error']("Name is Invalid.. Special Characters Not Allow");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if (!(val_regx.test(gea_value)) || gea_value == '' || gea_value <= 0) {
                if (gea_value == '') {
                    toastr['error']("GEA Value is Mandatory..");
                } else if (gea_value <= 0) {
                    toastr['error']("Value is too shorter..");
                } else if (!(val_regx.test(gea_value))) {
                    toastr['error']("Enter Valid Value.. After Decimal, two digits Allow only");
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