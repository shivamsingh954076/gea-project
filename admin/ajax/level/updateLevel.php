<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST) && isset($_SESSION['edit_level_id'])) {
    $id = $_POST['level_id'];
    $data = $_POST;
    $level_name = $data['level_name'];
    $level_number = $data['level_number'];
    $level_token = $data['level_token'];
    $description = $data['description'];
    if ($description == '') {
        $description = NULL;
    }
    $status = $data['status'];

    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $errors = array();

        $rand = rand(1111, 9999);

        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $img1_name = "IMG-" . date("YmdHis") . "-" . rand() . "." . $ext;
        $img1_tmp = $_FILES['img']['tmp_name'];

        $desired_dir = "../../data/level";
        if (empty($errors) == true) {
            if (is_dir($desired_dir) == false) {
                mkdir("$desired_dir", 0700);        // Create directory if it does not exist
            }

            move_uploaded_file($img1_tmp, "$desired_dir/" . $img1_name);
        } else {                                    // rename the file if another one exist
            $new_dir = "$desired_dir/" . $file_name . time();
            rename($file_tmp, $new_dir);
        }
    } else {
        $img1_name = NULL;
    }

    $chk = $conn->prepare("SELECT * FROM level where level_no=:level_no");
    $chk->execute([":level_no" => $level_number]);
    if ($chk->rowCount() >= 1) {
        $update = $conn->prepare("UPDATE level SET level_name=:level_name, level_no=:level_no, total_token=:total_token, img=:img, description=:description, active=:active, updated_at=:updated_at WHERE id=:id");
        $update_qry = $update->execute([":level_name" => $level_name, ":level_no" => $level_number, ":total_token" => $level_token, ":img" => $img1_name, ":description" => $description, ":active" => $status, ":updated_at" => $datetime, ":id" => $id]);
        if ($update_qry) {
            echo json_encode(array("result" => 1));
        } else {
            echo json_encode(array("result" => "data_err"));
        }
    } else {
        echo json_encode(array("result" => "level_not_exist"));
    }
} else {
    echo json_encode(array("result" => "request_err"));
}
