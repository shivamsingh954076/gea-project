<?php
session_start();
include("../../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$nameRegx = '/^[a-zA-Z0-9 ]*$/';
$mobileRegx = '/^\d+$/';
$usernameRegx = '/^[A-Za-z0-9-_\.]+$/';
$docRegx = '/^[A-Za-z0-9-]+$/';
$emailRegx = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,5})+$/';
if (isset($_REQUEST) && isset($_SESSION['edit_user_id'])) {
    $id = $_POST['user_id'];
    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = $_POST['email'];
    $country = $_POST['country_select'];
    $mobile = $_POST['mobile'];
    $document = @$_POST['document_select'];
    $doc_id_no = trim($_POST['doc_id_no']);
    $gender = trim($_POST['gender']);
    $status = $_POST['user_status'];
    // print_r($_REQUEST);
    if (strlen($doc_id_no) < 3 || strlen($doc_id_no) > 50 || $doc_id_no == '') {
        $document = NULL;
        $doc_id_no = NULL;
    }

    $email = str_replace(' ', '', $email);
    $genderArray = array("male", "female", "other");

    if ($full_name != '' && strlen($full_name) >= 2 && (preg_match($nameRegx, $full_name)) && strlen($full_name) <= 100 && $username != '' && strlen($username) >= 3 && (preg_match($usernameRegx, $username)) && strlen($username) <= 100 && $email != '' && strlen($email) >= 10 && (preg_match($emailRegx, $email)) && strlen($email) <= 100 && $country != '' && $mobile != '' && strlen($mobile) >= 7 && (preg_match($mobileRegx, $mobile)) && strlen($mobile) <= 15 && (($doc_id_no == '' || $doc_id_no == NULL) || (strlen($doc_id_no) >= 3 && strlen($doc_id_no) <= 50 && (preg_match($docRegx, $doc_id_no)))) && ($status == 0 || $status == 1) && in_array($gender, $genderArray)) {
        // Country Data
        $get_country = $conn->prepare("SELECT phone as country_code FROM countries WHERE id=:country_id AND active=1");
        $get_country->execute([":country_id" => $country]);
        $country_data = $get_country->fetch();
        if ($get_country->rowCount() >= 1) {
            $update_sql = $conn->prepare("UPDATE users SET name=:name, username=:username, mobile=:mobile, country_id=:country_id, email=:email, gender=:gender, doc_id=:doc_id, doc_id_number=:doc_id_number, user_active=:user_active, updated_datetime=:updated_datetime WHERE id=:id");
            $updated = $update_sql->execute([":name" => $full_name, ":username" => $username, ":mobile" => $mobile, ":country_id" => $country, ":email" => $email, ":gender" => $gender, ":doc_id" => $document, ":doc_id_number" => $doc_id_no, ":user_active" => $status, ":updated_datetime" => $datetime, ":id" => $id]);
            if($updated){
                echo json_encode(array("result" => 1));
            }
            else{
                echo json_encode(array("result" => 'data_err'));
            }
        }else{
            echo json_encode(array("result" => 'country_err'));
        }
    }else{
        echo json_encode(array("result" => 'validation_err'));
    }
}
else{
    echo json_encode(array("result" => 'session_err'));
}
