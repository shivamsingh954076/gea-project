<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $data = $_POST;
    $doc_name = $data['doc_name'];
    $description = $data['description'];
    if($description == ''){
        $description = NULL;
    }
    $status = $data['status'];

    if (isset($_FILES['img']) && $_FILES['img']['name']) {
        $errors = array();

        $rand = rand(1111, 9999);

        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $img1_name = "IMG-" . date("YmdHis") . "-" . rand() . "." . $ext;
        $img1_tmp = $_FILES['img']['tmp_name'];

        $desired_dir = "../../data/document_set";
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

    $chk = $conn->prepare("SELECT * FROM document where doc_name=:doc_name");
    $chk->execute([":doc_name" => $doc_name]);
    if ($chk->rowCount() == 0) {
        $insert = $conn->prepare("INSERT INTO document(doc_name, img, description, active, created_at) VALUES(:doc_name, :img, :description, :active, :created_at)");
        $insert_qry = $insert->execute([":doc_name" => $doc_name, ":img" => $img1_name, ":description" => $description, ":active" => $status, ":created_at" => $datetime]);
        if($insert_qry){
            echo json_encode(array("result" => 1));
        }else{
            echo json_encode(array("result" => "data_err"));
        }
    } else {
        echo json_encode(array("result" => "_exist"));
    }
}else{
    echo json_encode(array("result" => "request_err"));
}
