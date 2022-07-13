<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $data = $_POST;
    $title = $data['title'];
    $content = $data['content'];
    $status = $data['status'];
    $page_name = $data['page_name'];

    $chk = $conn->prepare("SELECT * FROM pages WHERE id=:id");
    $chk->execute([":id" => 1]);
    if ($chk->rowCount() == 1) {
        $content = json_encode(array("title" => "$title", "content" => "$content", "status" => $status));
        $update = $conn->prepare("UPDATE pages SET $page_name=:$page_name WHERE id=:id");
        $update_qry = $update->execute([":$page_name" => $content, ":id" => 1]);
        if($update_qry){
            echo json_encode(array("result" => 1));
        }else{
            echo json_encode(array("result" => "data_err"));
        }
    } else {
        echo json_encode(array("result" => "not_available"));
    }
}else{
    echo json_encode(array("result" => "request_err"));
}
