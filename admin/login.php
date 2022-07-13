<?php session_start(); ?>
<?php include('../config/connect.php');  ?>
<?php if(isset($_SESSION['admin_id']) && isset($_SESSION['admin_name']) && isset($_SESSION['admin_email'])){
    header("Location: $base_url_admin");
} ?>
<?php include('layout/headerbar.php'); ?>

<body class="login">
    <div class="container sm:px-10">
        <div class="block xl:grid grid-cols-2 gap-4">
            <!-- BEGIN: Login Info -->
            <div class="hidden xl:flex flex-col min-h-screen">
                <a href="" class="-intro-x flex items-center pt-5">
                    <img alt="Image Area" style="width: 50px;" src="dist/images/logo.png">
                    <span class="text-white text-base ml-3"> </span>
                </a>
                <div class="my-auto">
                    <img alt="Image Area" class="-intro-x w-1/2 -mt-16" src="dist/images/illustration.svg">
                    <div class="-intro-x text-white font-medium text-4xl leading-tight mt-10">
                        A few more clicks to
                        <br> sign in to your account.
                    </div>
                    <div class="-intro-x mt-5 text-lg text-white text-opacity-70 dark:text-gray-500">Manage all your contents in one place</div>
                </div>
            </div>
            <!-- END: Login Info -->
            <!-- BEGIN: Login Form -->
            <div class="h-screen xl:h-auto flex py-5 xl:py-0 my-10 xl:my-0">
                <div class="my-auto mx-auto xl:ml-20 bg-white dark:bg-dark-1 xl:bg-transparent px-5 sm:px-8 py-8 xl:p-0 rounded-md shadow-md xl:shadow-none w-full sm:w-3/4 lg:w-2/4 xl:w-auto">
                    <h2 class="intro-x font-bold text-2xl xl:text-3xl text-center xl:text-left">
                        Sign In
                    </h2>
                    <div class="intro-x mt-2 text-gray-500 xl:hidden text-center">A few more clicks to sign in to your account. Manage all your contents in one place</div>
                    <form action="" id="form_data" action="POST">
                        <div class="intro-x mt-8">
                            <input type="text" class="intro-x login__input form-control py-3 px-4 border-gray-300 block" placeholder="Enter Email Address" name="email">
                            <input type="password" class="intro-x login__input form-control py-3 px-4 border-gray-300 block mt-4" placeholder="Password" name="password">
                        </div>
                        <div class="intro-x flex text-gray-700 dark:text-gray-600 text-xs sm:text-sm mt-4">
                            <div class="flex items-center mr-auto">
                                <input id="remember-me" type="checkbox" class="form-check-input border mr-2">
                                <label class="cursor-pointer select-none" for="remember-me">Remember me</label>
                            </div>
                            <a href="">Forgot Password?</a>
                        </div>
                        <div class="intro-x mt-5 xl:mt-8 text-center xl:text-left">
                            <button class="btn hidden py-3 px-4 w-full xl:w-32 xl:mr-3 align-top" type="submit" id="login_btn" style="background-color:#228b22;color: #fff;">Login</button>
                            <a href="#" class="btn btn-outline-secondary py-3 px-4 w-full xl:w-32 mt-3 xl:mt-0 align-top">Sign up</a>
                        </div>
                    </form>
                    <!-- <div class="intro-x mt-10 xl:mt-24 text-gray-700 dark:text-gray-600 text-center xl:text-left">
                        By signin up, you agree to our
                        <br>
                        <a class="text-theme-1 dark:text-theme-10" href="">Terms and Conditions</a> & <a class="text-theme-1 dark:text-theme-10" href="">Privacy Policy</a>
                    </div> -->
                </div>
            </div>
            <!-- END: Login Form -->
        </div>
    </div>
    <?php include('layout/footerbar.php') ?>
    <script>
        $(function() {
            $("#login_btn").removeClass("hidden");
        });
        $("#form_data").on("submit", function(e) {
            e.preventDefault();
            let login_email = $("input[name='email']").val().trim(),
                login_password = $("input[name='password']").val().trim();
            if (login_email != '' && emailRegx.test(login_email) && login_password != '' && login_password.length >= 5 && login_password.length <= 100) {
                var loginForm = new FormData($(this)[0]);
                $.ajax({
                    type: "POST",
                    url: "ajax/login.php",
                    data: loginForm,
                    dataType: "JSON",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.result == 1) {
                            toastr['success']("Login Successfull.. Redirect to Dashboard");
                            setInterval(() => {
                                window.location = '<?php echo $base_url_admin; ?>';
                            }, 2000);
                        } else if (response.result == 0) {
                            toastr['error']("Credentials Invalid.. Try again with correct one..");
                        } else if (response.result == 'validation_err') {
                            toastr['error']("Validation Error Occurred..");
                        } else if (response.result == 'value_not_pass') {
                            toastr['error']("Value not passed error..");
                        } else {
                            toastr['error']('Something went Wrong..');
                        }
                    }
                });
            } else if (login_email == '' || !(emailRegx.test(login_email))) {
                if (login_email == '') {
                    toastr['error']('Email can\'t be Blank..');
                } else {
                    toastr['error']('Email is invalid..');
                }
            } else if (login_password == '' || login_password.length < 5 || login_password.length > 100) {
                if (login_password == '') {
                    toastr['error']('Password can\'t be Blank..');
                } else if (login_password.length < 5) {
                    toastr['error']('Password is too short..');
                } else if (login_password.length > 100) {
                    toastr['error']('Password is too long..');
                } else {
                    toastr['error']('Password Error Occurred..');
                }
            } else {
                toastr['error']('Something went Wrong..');
            }
        });
    </script>
</body>

</html>