<?php
// session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$id = (int)$_POST['id'];
if ($id != '' && is_int($id)) {
    $dlt_user_qry = "DELETE FROM document WHERE id=:id";
    $dlt_user_qry_prepare = $conn->prepare($dlt_user_qry);
    $dlt_user_qry_prepare->execute([":id" => $id]);
    if ($dlt_user_qry_prepare) {
        echo json_encode(array("result" => 1));
    } else {
        echo json_encode(array("result" => 0));
    }
}
