<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])){
    header("Location: $base_url_admin/login");
}
$page = "add-country";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="index">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="manage-countries" class="">Manage Countries</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Add New Country</a></div>
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
                                    Add New Country
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <!-- For Country Name -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country Name <span class="text-theme-6">*</span></label>
                                        <input id="country_name" name="country_name" type="text" class="form-control" placeholder="Enter Country Name (Ex: India)">
                                    </div>
                                    <!-- For Country Phone -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country Phone <span class="text-theme-6">*</span></label>
                                        <input id="country_phone" name="country_phone" type="text" class="form-control only_digits" placeholder="Enter Country Phone Without (+) Sign (Ex: 91)">
                                    </div>
                                    <!-- For Country Code -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country Code <span class="text-theme-6">*</span></label>
                                        <input id="country_code" name="country_code" type="text" class="form-control only_characters_code" oninput="this.value = this.value.toUpperCase()" placeholder="Enter Country Code (Ex: IN)">
                                    </div>
                                    <!-- For Symbol -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Symbol</label>
                                        <input id="country_symbol" name="country_symbol" type="text" class="form-control" placeholder="Enter Symbol (Ex: $)">
                                    </div>
                                    <!-- For Capital -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Capital</label>
                                        <input id="country_capital" name="country_capital" type="text" class="form-control" placeholder="Enter Country Capital (Ex: New Delhi)">
                                    </div>
                                    <!-- For Currency -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Currency</label>
                                        <input id="country_currency" name="country_currency" type="text" class="form-control only_characters_currency" oninput="this.value = this.value.toUpperCase()" placeholder="Enter Currency (Ex: USD)">
                                    </div>
                                    <!-- For Status -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Status</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" name="country_status" id="country_status">
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
            var txt = $("#country_phone").val().trim();
            if (txt.length == 5) {
                e.preventDefault();
            }
        });
        $('.only_characters_code').keypress(function(e) {
            var a = [];
            var k = e.which;
            for (i = 65; i < 90; i++) {
                a.push(i);
            }
            for (i = 97; i < 122; i++) {
                a.push(i);
            }
            if (!(a.indexOf(k) >= 0)) {
                e.preventDefault();
            }
            var country_txt = $("#country_code").val().trim();
            if (country_txt.length == 2) {
                e.preventDefault();
            }
        });
        $('.only_characters_currency').keypress(function(e) {
            var a = [];
            var k = e.which;
            for (i = 65; i < 90; i++) {
                a.push(i);
            }
            for (i = 97; i < 122; i++) {
                a.push(i);
            }
            if (!(a.indexOf(k) >= 0)) {
                e.preventDefault();
            }
            var currency_txt = $("#country_currency").val().trim();
            if (currency_txt.length == 3) {
                e.preventDefault();
            }
        });
        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            // Get Data
            let country_name = $("#country_name").val().trim(),
                country_phone = $("#country_phone").val().trim(),
                country_code = $("#country_code").val().toUpperCase().trim(),
                country_symbol = $("#country_symbol").val().trim(),
                country_capital = $("#country_capital").val().trim(),
                country_currency = $("#country_currency").val().toUpperCase().trim(),
                country_status = parseInt($("#country_status").val());
            if (country_name != '' && country_name.length >= 2 && country_name.length <= 100 && country_name_regx.test(country_name) && country_phone != '' && country_phone.length >= 1 && country_phone.length <= 5 && mobileRegx.test(country_phone) && country_code != '' && country_code.length == 2 && country_code_regx.test(country_code) && (country_symbol == '' || (country_symbol.length >= 1 && country_symbol.length <= 10)) && (country_capital == '' || (country_capital.length >= 2 && country_capital.length <= 100 && country_name_regx.test(country_capital))) && (country_currency == '' || (country_currency.length >= 1 && country_currency.length <= 3 && country_currency_regx.test(country_currency))) && (country_status == 1 || country_status == 0)) {
                let form = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: "ajax/country/manage-countries/addCountry.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Inserted Successfully..");
                            document.getElementById("form_data").reset();  
                        } else if (response.result == 'country_exist') {
                            toastr['error']("Country Name is Already Exist..");
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
            } else if (country_name == '' || country_name.length < 2 || country_name.length > 100 || !(country_name_regx.test(country_name))) {
                if (country_name == '') {
                    toastr['error']("Country Name is Mandatory..");
                } else if (country_name.length < 2) {
                    toastr['error']("Country Name is too Short..");
                } else if (country_name.length > 100) {
                    toastr['error']("Country Name is too long..");
                } else if (!(country_name_regx.test(country_name))) {
                    toastr['error']("Country Name is invalid..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if (country_phone == '' || country_phone.length < 1 || country_phone.length > 5 || !(mobileRegx.test(country_phone))) {
                if (country_phone == '') {
                    toastr['error']("Country Phone is Mandatory..");
                } else if (country_phone.length < 1) {
                    toastr['error']("Country Phone is too Short..");
                } else if (country_phone.length > 5) {
                    toastr['error']("Country Phone is too long..");
                } else if (!(mobileRegx.test(country_phone))) {
                    toastr['error']("Country Phone is invalid..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if (country_code == '' || country_code.length != 2 || !(country_code_regx.test(country_code))) {
                if (country_code == '') {
                    toastr['error']("Country Code is Mandatory..");
                } else if (country_phone.length != 2) {
                    toastr['error']("Country Code must be 2 chacaters");
                } else if (!(country_code_regx.test(country_code))) {
                    toastr['error']("Country Code is invalid..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if ((country_symbol != '' && (country_symbol.length < 1 || country_symbol.length > 10))) {
                if (country_symbol != '') {
                    toastr['error']("Invalid Symbol.. Optional Field");
                } else if (country_symbol.length < 1 || country_symbol.length > 10) {
                    toastr['error']("Country Symbol Length is too long..");
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if ((country_capital != '' && (country_capital.length < 2 || country_capital.length > 100 || !(country_name_regx.test(country_capital))))) {
                if (country_capital.length < 2 || country_capital.length > 100 || country_name_regx.test(country_capital)) {
                    if (country_name.length < 2) {
                        toastr['error']("Country Capital is too Short..");
                    } else if (country_name.length > 100) {
                        toastr['error']("Country Capital is too long..");
                    } else if (!(country_name_regx.test(country_name))) {
                        toastr['error']("Country Capital is invalid..");
                    } else {
                        toastr['error']("Something Went Wrong..");
                    }
                } else {
                    toastr['error']("Something Went Wrong..");
                }
            } else if ((country_currency != '' && (country_currency.length < 1 || country_currency.length > 3 || !(country_currency_regx.test(country_currency))))) {
                if (country_currency.length < 2 || country_currency.length > 100 || country_currency_regx.test(country_currency)) {
                    if (country_currency.length < 2) {
                        toastr['error']("Country Currency is too Short..");
                    } else if (country_currency.length > 100) {
                        toastr['error']("Country Currency is too long..");
                    } else if (!(country_currency_regx.test(country_currency))) {
                        toastr['error']("Country Currency is invalid..");
                    } else {
                        toastr['error']("Something Went Wrong..");
                    }
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