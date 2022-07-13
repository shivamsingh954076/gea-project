<?php session_start(); ?>
<?php include('../../config/connect.php'); ?>
<?php
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $email_regx = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/';
    $email = trim($_POST['email']);
    $password = trim(md5($_POST['password']));
    if ($email != '' && preg_match($email_regx, $email) && $password != '' && strlen($password) >= 5 && strlen($password) <= 100){
        $chk = $conn->prepare("SELECT * FROM admin WHERE email = :email AND password=:password");
        $chk->execute([":email" => $email, "password" => $password]);
        $get_data = $chk->fetch();
        if($chk->rowCount() >= 1){
            $_SESSION['admin_id'] = $get_data['id'];
            $_SESSION['admin_name'] = $get_data['name'];
            $_SESSION['admin_email'] = $get_data['email'];
            echo json_encode(array("result" => 1));
        }
        else{
            echo json_encode(array("result" => 0));
        }
    }else{
        echo json_encode(array("result" => 'validation_err'));
    }
}else{
    echo json_encode(array("result" => 'value_not_pass'));
}
