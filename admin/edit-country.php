<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
if (!isset($_SESSION['edit_country_id'])) {
    echo "<script>history.back();</script>";
    die();
}
$sel_qry = $conn->prepare("SELECT * FROM countries WHERE id=:id AND active=1");
$sel_qry->execute([":id" => $_SESSION['edit_country_id']]);
$fetch_country_data = $sel_qry->fetch();
if ($sel_qry->rowCount() != 1) {
    echo "<script>history.back();</script>";
    die();
}
$page = "manage-countries";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit Country</div>
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
                                    Edit Country Data
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <!-- For Country Name -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country Name <span class="text-theme-6">*</span></label>
                                        <input id="country_name" name="country_name" type="text" class="form-control" placeholder="Enter Country Name (Ex: India)" value="<?php echo $fetch_country_data['name']; ?>">
                                    </div>
                                    <!-- For Country Phone -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country Phone <span class="text-theme-6">*</span></label>
                                        <input id="country_phone" name="country_phone" type="text" class="form-control only_digits" placeholder="Enter Country Phone Without (+) Sign (Ex: 91)" value="<?php echo $fetch_country_data['phone']; ?>">
                                    </div>
                                    <!-- For Country Code -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country Code <span class="text-theme-6">*</span></label>
                                        <input id="country_code" name="country_code" type="text" class="form-control only_characters_code" oninput="this.value = this.value.toUpperCase()" placeholder="Enter Country Code (Ex: IN)" value="<?php echo $fetch_country_data['code']; ?>">
                                    </div>
                                    <!-- For Symbol -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Symbol</label>
                                        <input id="country_symbol" name="country_symbol" type="text" class="form-control" placeholder="Enter Symbol (Ex: $)" value="<?php echo $fetch_country_data['symbol']; ?>">
                                    </div>
                                    <!-- For Capital -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Capital</label>
                                        <input id="country_capital" name="country_capital" type="text" class="form-control" placeholder="Enter Country Capital (Ex: New Delhi)" value="<?php echo $fetch_country_data['capital']; ?>">
                                    </div>
                                    <!-- For Currency -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Currency</label>
                                        <input id="country_currency" name="country_currency" type="text" class="form-control only_characters_currency" oninput="this.value = this.value.toUpperCase()" placeholder="Enter Currency (Ex: USD)" value="<?php echo $fetch_country_data['currency']; ?>">
                                    </div>
                                    <!-- For Status -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Status</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" name="country_status" id="country_status">
                                                <?php
                                                $active_status = [1, 0];
                                                if ($fetch_country_data['active'] == 0) {
                                                    $status = 'In-Active';
                                                } else {
                                                    $status = 'Active';
                                                }
                                                foreach ($active_status as $as) {
                                                ?>
                                                    <option value="<?php echo $as; ?>" <?php if ($as == $fetch_country_data['active']) {
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
                form.append("country_id", <?php echo $_SESSION['edit_country_id'] ?>)
                $.ajax({
                    type: "POST",
                    url: "ajax/country/manage-countries/updateCountry.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Updated Successfully..");
                        } else if (response.result == 'country_not_exist') {
                            toastr['error']("Country Not Found..");
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