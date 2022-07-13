<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST) && isset($_SESSION['edit_gea_product_id'])) {
    $id = $_POST['gea_product_id'];
    $data = $_POST;
    $name = $data['name'];
    $gea_value = $data['gea_value'];
    $description = $data['description'];
    if($description == ''){
        $description = NULL;
    }
    $status = $data['status'];

    $chk = $conn->prepare("SELECT * FROM gea_product WHERE id=:id");
    $chk->execute([":id" => $id]);
    if ($chk->rowCount() >= 1) {
        $update = $conn->prepare("UPDATE gea_product SET name=:name, value=:value, description=:description, active=:active, updated_at=:updated_at WHERE id=:id");
        $update_qry = $update->execute(["name"=>$name, ":value" => $gea_value, ":description" => $description, ":active" => $status, ":updated_at" => $datetime, ":id" => $id]);
        if ($update_qry) {
            echo json_encode(array("result" => 1));
        } else {
            echo json_encode(array("result" => "data_err"));
        }
    } else {
        echo json_encode(array("result" => "not_exist"));
    }
} else {
    echo json_encode(array("result" => "request_err"));
}
