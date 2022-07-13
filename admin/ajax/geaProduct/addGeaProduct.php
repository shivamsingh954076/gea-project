<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $data = $_POST;
    $name = $data['name'];
    $gea_value = $data['gea_value'];
    $description = $data['description'];
    if($description == ''){
        $description = NULL;
    }
    $status = $data['status'];

    $chk = $conn->prepare("SELECT * FROM gea_product WHERE name=:name");
    $chk->execute([":name" => $name]);
    if ($chk->rowCount() == 0) {
        $insert = $conn->prepare("INSERT INTO gea_product(name, value, description, active, created_at) VALUES(:name, :value, :description, :active, :created_at)");
        $insert_qry = $insert->execute([":name" => $name, ":value" => $gea_value, ":description" => $description, ":active" => $status, ":created_at" => $datetime]);
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
