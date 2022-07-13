<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if (!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])) {
    header("Location: $base_url_admin/login");
}
if (!isset($_SESSION['edit_gea_currency_id'])) {
    echo "<script>history.back();</script>";
    die();
}

$sel_qry = $conn->prepare("SELECT gea.*, country.name AS country_name, country.symbol AS symbol, country.currency AS currency FROM gea_currency AS gea INNER JOIN countries AS country ON country.id=gea.country_id WHERE gea.active=1 AND gea.id=:id");
$sel_qry->execute([":id" => $_SESSION['edit_gea_currency_id']]);
$fetch_data = $sel_qry->fetch();

if ($sel_qry->rowCount() != 1) {
    echo "<script>history.back();</script>";
    die();
}
$page = "manage-gea-currency";
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit GEA Currency</div>
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
                                    Edit GEA Currency
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country <span class="text-theme-6">*</span></label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" id="country_select" name="country_select">
                                                <option value="<?php echo (int)$fetch_data['id']; ?>"><?php echo $fetch_data['country_name']; ?></option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- For Description -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">1 GEA Value = <?php echo $fetch_data['symbol'] . '(' . $fetch_data['currency'] . ')'; ?> <span id="gea_value_text"></span> <span class="text-theme-6">*</span></label>
                                        <input id="gea_value" name="gea_value" type="text" class="form-control decimal_validation" placeholder="Enter Value (Ex: 10)" value="<?php echo $fetch_data['value']; ?>">
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
        $('.decimal_validation').keyup(function() {
            var val = $(this).val();
            if (isNaN(val)) {
                val = val.replace(/[^0-9\.]/g, '');
                if (val.split('.').length > 2)
                    val = val.replace(/\.+$/, "");
            }
            $(this).val(val);
            if (val > 999999) {
                $(this).val('');
                $("#gea_value_text").text(` ${currency_val}`);
            }
        });

        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            let val_regx = /^[0-9]*(\.[0-9]{0,2})?$/;
            let country = $("#country_select").val().trim(),
                gea_value = $("#gea_value").val().trim(),
                description = $("#description").val().trim(),
                status = parseInt($("#status").val());
            if (val_regx.test(gea_value) && gea_value != '' && gea_value > 0 && country != '' && (status == 1 || status == 0)) {
                let form = new FormData($(this)[0]);
                form.append("gea_currency_id", <?php echo $_SESSION['edit_gea_currency_id'] ?>);
                $.ajax({
                    type: "POST",
                    url: "ajax/geaCurrency/updateGeaCurrency.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Updated Successfully..");
                            setInterval(() => {
                                window.location.reload();
                            }, 1500);
                        } else if (response.result == 'not_exist') {
                            toastr['error']("Data is Not Exist..");
                        } else if (response.result == 'validation_err') {
                            toastr['error']("Validations Error Found..");
                        } else if (response.result == "data_err") {
                            toastr['error']("Connection Issue..");
                        } else {
                            toastr['error']("Something Went Wrong..");
                        }
                    }
                });
            } else if (country == '') {
                toastr['error']("Select Country First..");
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