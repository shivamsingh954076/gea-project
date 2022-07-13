<?php
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$id = (int)$_POST['id'];
if ($id != '' && is_int($id)) {
    $chk = "SELECT * FROM doc_countries WHERE id=:id";
    $chk_prepare = $conn->prepare($chk);
    $chk_prepare->execute([":id" => $id]);
    $fetch_country_id = $chk_prepare->fetch();
    if ($chk_prepare->rowCount() >= 1) {
        @session_start();
        $_SESSION['edit_country_doc_id'] = $fetch_country_id['country_id'];
        echo json_encode(array("result" => 1));
    } else {
        echo json_encode(array("result" => 0));
    }
}
