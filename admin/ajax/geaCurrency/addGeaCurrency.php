<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $data = $_POST;
    $country = $data['country_select'];
    $gea_value = $data['gea_value'];
    $description = $data['description'];
    if($description == ''){
        $description = NULL;
    }
    $status = $data['status'];

    $chk = $conn->prepare("SELECT * FROM gea_currency where country_id=:country_id");
    $chk->execute([":country_id" => $country]);
    if ($chk->rowCount() == 0) {
        $insert = $conn->prepare("INSERT INTO gea_currency(country_id, value, description, active, created_at) VALUES(:country_id, :value, :description, :active, :created_at)");
        $insert_qry = $insert->execute([":country_id" => $country, ":value" => $gea_value, ":description" => $description, ":active" => $status, ":created_at" => $datetime]);
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
