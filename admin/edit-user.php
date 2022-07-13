<?php
session_start();
include("../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
if(!isset($_SESSION['admin_id']) || !isset($_SESSION['admin_name']) || !isset($_SESSION['admin_email'])){
    header("Location: $base_url_admin/login");
}
if (!isset($_SESSION['edit_user_id'])) {
    echo "<script>history.back();</script>";
    die();
}
$sel_qry = "SELECT * FROM users WHERE id=:id";
$sel_qry_prepare = $conn->prepare($sel_qry);
$sel_qry_prepare->execute([":id" => $_SESSION['edit_user_id']]);
$fetch_users_data = $sel_qry_prepare->fetch();
if ($sel_qry_prepare->rowCount() != 1) {
    echo "<script>history.back();</script>";
    die();
}
$page = "manage-users";

// Document All Data
$get_country = $conn->prepare("SELECT * FROM countries WHERE active=1");
$get_country->execute();
$country_data = $get_country->fetchAll();

$get_doc = $conn->prepare("SELECT doc.id AS id, doc.doc_name AS doc_name FROM doc_countries AS doc_country INNER JOIN document AS doc ON doc_country.doc_id=doc.id WHERE doc_country.country_id=:country_id");
$get_doc->execute([":country_id" => $fetch_users_data['country_id']]);
$document_data = $get_doc->fetchAll();

$sel_doc = "SELECT country.name as country_name, country.phone as country_code, (SELECT doc_name FROM document AS doc_sub WHERE doc_sub.id=usr.doc_id) as document_name FROM users as usr INNER JOIN document as doc INNER JOIN countries as country ON country.id=usr.country_id WHERE usr.id=:id";
$sel_doc_prepare = $conn->prepare($sel_doc);
$sel_doc_prepare->execute([":id" => $_SESSION['edit_user_id']]);
$fetch_doc_data = $sel_doc_prepare->fetch();
?>
<?php include('layout/headerbar.php') ?>

<body class="main">
    <?php include('layout/sidebar.php') ?>
    <!-- BEGIN: Content -->
    <div class="content">
        <div class="top-bar">
            <!-- BEGIN: Breadcrumb -->
            <div class="-intro-x breadcrumb mr-auto hidden sm:flex"> <a href="">Dashboard</a> <i data-feather="chevron-right" class="breadcrumb__icon"></i> <a href="" class="breadcrumb--active">Edit User</div>
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
                                    Edit User Data
                                </h2>
                            </div>
                            <form id="form_data">
                                <div id="" class="p-5 grid grid-cols-12 gap-4">
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Full Name</label>
                                        <input id="full_name" name="full_name" type="text" class="form-control" placeholder="Enter Your Name" value="<?php echo $fetch_users_data['name']; ?>">
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Username</label>
                                        <input id="username" name="username" type="text" class="form-control" placeholder="Enter Your Username" value="<?php echo $fetch_users_data['username']; ?>">
                                    </div>

                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">E-mail</label>
                                        <input id="email" name="email" type="text" class="form-control" placeholder="Enter Your E-mail" value="<?php echo $fetch_users_data['email']; ?>">
                                    </div>

                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Country</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" id="country_select" name="country_select">
                                                <?php
                                                foreach ($country_data as $cd) {
                                                ?>
                                                    <option name="" value="<?php echo (int)$cd['id']; ?>" <?php if ($fetch_users_data['country_id'] == $cd['id']) {
                                                                                                                echo " selected";
                                                                                                            } ?>><?php echo $cd['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Mobile <span class="ml-2" id="country_code">(+<?php echo $fetch_doc_data['country_code']; ?>)</span></label>
                                        <input id="mobile" name="mobile" type="text" class="form-control only_digits" placeholder="Enter Your Mobile No." value="<?php echo $fetch_users_data['mobile']; ?>">
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6 <?php if ($get_doc->rowCount() == 0) {
                                                                                    echo "hidden";
                                                                                } ?>" id="document_container">
                                        <label for="" class="form-label">ID Type</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" id="document_select" name="document_select">
                                                <?php foreach ($document_data as $doc) { ?>
                                                    <option value="<?php echo $doc['id']; ?>" <?php if ($doc['id'] == $fetch_users_data['doc_id']) {
                                                                                                    echo " selected";
                                                                                                } ?>><?php echo $doc['doc_name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mt-2 col-span-12 lg:col-span-6 <?php if ($get_doc->rowCount() == 0) {
                                                                                    echo "hidden";
                                                                                } ?>" id="document_number_container">
                                        <label for="" class="form-label">Doc ID Number</label>
                                        <input id="doc_id_no" name="doc_id_no" type="text" class="form-control" placeholder="Enter Your Document ID No." value="<?php echo $fetch_users_data['doc_id_number']; ?>">
                                    </div>
                                    <!-- For Gender -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">Gender</label>
                                        <div class="flex flex-col sm:flex-row mt-2">
                                            <?php
                                            $gender = ['male', 'female', 'other'];
                                            foreach ($gender as $g) {
                                            ?>
                                                <div class="form-check mr-3">
                                                    <input id="" class="form-check-input" type="radio" name="gender" value="<?php echo $g; ?>" <?php if ($fetch_users_data['gender'] == $g) {
                                                                                                                                                    echo " checked";
                                                                                                                                                } ?>>
                                                    <label class="ml-2" for="">
                                                        <?php echo ucfirst($g); ?>
                                                    </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <!-- For User Status -->
                                    <div class="mt-2 col-span-12 lg:col-span-6">
                                        <label for="" class="form-label">User Status</label>
                                        <div class="flex flex-col sm:flex-row">
                                            <select class="form-select sm:mr-2" aria-label="" name="user_status" id="user_status">
                                                <?php
                                                $active_status = [1, 0];
                                                if ($fetch_users_data['user_active'] == 0) {
                                                    $user_status = 'In-Active';
                                                } else {
                                                    $user_status = 'Active';
                                                }
                                                foreach ($active_status as $as) {
                                                ?>
                                                    <option value="<?php echo $as; ?>" <?php if ($as == $fetch_users_data['user_active']) {
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
                                        <button class="btn btn-primary mt-2 hidden" id="submit_button" type="submit">UPDATE</button>
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
        $("#country_select").select2();
        $(window).ready(function() {
            $("#document_number_container > label").text($("#document_select > option:selected").text() + " No.");
            $("#document_number_container > input").attr("placeholder", "Enter Your " + $("#document_select > option:selected").text() + " No.");
            $("#submit_button").removeClass("hidden");
            $('.select2.select2-container').addClass("custom_select2_style");
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
            var txt = $("#mobile").val().trim();
            if (txt.length == 15) {
                e.preventDefault();
            }
        });
        let gender_arr = ['male', 'female', 'other'];
        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            // Get Data
            let full_name = $("#full_name").val().trim(),
                username = $("#username").val().trim(),
                email = $("#email").val().trim(),
                mobile = $("#mobile").val().trim(),
                country = parseInt($("#country_select").val()),
                document = parseInt($("#document_select").val()),
                document_number = $("#doc_id_no").val().trim(),
                user_status = parseInt($("#user_status").val()),
                gender = $('input[name="gender"]:checked').val();
            // Validate Data
            if (full_name != '' && full_name.length >= 2 && nameRegx.test(full_name) && full_name.length <= 100 && username != '' && username.length >= 3 && usernameRegx.test(username) && username.length <= 100 && email != '' && email.length >= 10 && emailRegx.test(email) && email.length <= 100 && country != '' && Number.isInteger(country) && mobile != '' && mobile.length >= 7 && mobileRegx.test(mobile) && mobile.length <= 15 && (isNaN(document) || Number.isInteger(document)) && ((document_number == '') || (document_number.length >= 3 && document_number.length <= 50 && docRegx.test(document_number))) && (user_status == 0 || user_status == 1) && $.inArray(gender, gender_arr) != -1) {
                let form = new FormData($(this)[0]);
                form.append("user_id", <?php echo $_SESSION['edit_user_id'] ?>);
                $.ajax({
                    type: "POST",
                    url: "ajax/users/manage-users/updateUser.php",
                    data: form,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Data Updated Successfully..");
                        } else if (response.result == 'country_err') {
                            toastr['error']("Country Not Found..");
                        } else if (response.result == 'validation_err') {
                            toastr['error']("Validations Error Found..");
                        } else if (response.result == "session_err") {
                            toastr['error']("User Session Error..");
                        } else if (response.result == "data_err") {
                            toastr['error']("Connection Issue..");
                        } else {
                            toastr['error']("Something Went Wrong..");
                        }
                    }
                });
            } else if (full_name == '' || full_name.length < 2 || full_name.length > 100 || !(nameRegx.test(full_name))) {
                if (full_name == '') {
                    toastr["error"]("Name can\'t be Blank..");
                } else if (full_name.length < 2) {
                    toastr["error"]("Name is too short..");
                } else if (full_name.length > 100) {
                    toastr["error"]("Name is too long..");
                } else {
                    toastr["error"]("Name is invalid.. Only Characters & Digits Allow..");
                }
            } else if (username == '' || username.length < 3 || username.length > 100 || !(usernameRegx.test(username))) {
                if (username == '') {
                    toastr["error"]("Username can\'t be Blank..");
                } else if (username.length < 3) {
                    toastr["error"]("Username is too short..");
                } else if (username.length > 100) {
                    toastr["error"]("Username is too long..");
                } else {
                    toastr["error"]("Username is invalid.. Only Characters & Digits & (dot(.), hyphen(-), underScore(_)) Allow..");
                }
            } else if (email == '' || email.length < 10 || email.length > 100 || !(emailRegx.test(email))) {
                if (email == '') {
                    toastr["error"]("Email Address can\'t be Blank..");
                } else if (email.length < 10) {
                    toastr["error"]("Email address is too short..");
                } else if (email.length > 100) {
                    toastr["error"]("Email Address is too long..");
                } else {
                    toastr["error"]("Email Address is invalid..");
                }
            } else if (!(Number.isInteger(country))) {
                toastr["error"]("Country is Invalid..");
            } else if (mobile == '' || mobile.length < 7 || mobile.length > 15 || !(mobileRegx.test(mobile))) {
                if (mobile == '') {
                    toastr["error"]("Mobile Number can\'t be Blank..");
                } else if (mobile.length < 7) {
                    toastr["error"]("Mobile is too short..");
                } else if (mobile.length > 15) {
                    toastr["error"]("Mobile is too long..");
                } else {
                    toastr["error"]("Mobile Number is invalid..");
                }
            } else if ((!(Number.isInteger(document)) || (document_number.length < 3 || document_number.length > 50 || !(docRegx.test(document_number)))) && (!isNaN(document) || document_number != '')) {
                if (!(Number.isInteger(document))) {
                    toastr["error"]("Document Type is Invalid..");
                } else if ((document_number.length < 3 || document_number.length > 50 || !(docRegx.test(document_number)))) {
                    toastr["error"]("Document Number Between 3 to 50 Characters.. No Special Characters Allow..");
                } else if ((!isNaN(document) || document_number != '')) {
                    toastr["error"]("Document No. Can\'t be Blank..");
                } else {
                    toastr["error"]("Document Error.. something Wrong");
                }
            } else if (gender == undefined || $.inArray(gender, gender_arr) == -1) {
                toastr["error"]("Please Select Your Gender..");
            } else {
                toastr["error"]("Something Went Wrong..");
            }
        });

        $('#country_select').on('change', function() {
            $("#document_number_container > input").val('');
            let country_id = parseInt(this.value);
            if (country_id != '' && Number.isInteger(country_id)) {
                $.ajax({
                    type: "POST",
                    url: "ajax/country/getCountry.php",
                    data: {
                        country_id
                    },
                    dataType: "JSON",
                    success: function(response) {
                        if (response.result == 1) {
                            let resp = response.document_data[0];
                            let doc_html = '';
                            $(resp).each(function(index) {
                                let doc_id = this.document_id;
                                let doc_name = this.document_name;
                                doc_html += `<option value="${doc_id}">${doc_name}</option>`;
                            });
                            if (doc_html == '') {
                                toastr['error']("ID Card Not Available for this country");
                                $("#document_select").html('');
                                $("#document_container, #document_number_container").addClass("hidden");
                            } else {
                                $("#document_select").html(doc_html);
                                $("#document_number_container > label").text($("#document_select > option:selected").text() + " No.");
                                $("#document_number_container > input").attr("placeholder", "Enter Your " + $("#document_select > option:selected").text() + " No.");
                                $("#document_container, #document_number_container").removeClass("hidden");
                            }
                            let country_code = response.country_code[0];
                            $("#country_code").text("(+" + response.country_code + ")");
                        }
                    }
                });
            }
        });
        $('#document_select').on('change', function() {
            $("#document_number_container > label").text($("#document_select > option:selected").text() + " No.");
            $("#document_number_container > input").attr("placeholder", "Enter Your " + $("#document_select > option:selected").text() + " No.");
            $("#document_number_container > input").val('');
        });
    </script>
    <!-- END: JS Assets-->
</body>

</html>