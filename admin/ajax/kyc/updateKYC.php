<?php
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST) && $_POST['text'] != 'decline_region_cancel') {
    $id = $_POST['id'];
    $status = $_POST['status'];
    $region = @$_POST['text'];
    if ($region == '') {
        $description = NULL;
    }

    $chk = $conn->prepare("SELECT * FROM kyc_request WHERE id=:id");
    $chk->execute([":id" => $id]);
    if ($chk->rowCount() >= 1) {
        $update = $conn->prepare("UPDATE kyc_request SET kyc_status=:kyc_status, decline_region=:decline_region, updated_at=:updated_at WHERE id=:id");
        $update_qry = $update->execute([":kyc_status" => $status, ":decline_region" => $region, ":updated_at" => $datetime, ":id" => $id]);
        if ($update_qry) {
            echo json_encode(array("result" => 1));
        } else {
            echo json_encode(array("result" => "data_err"));
        }
    } else {
        echo json_encode(array("result" => "not_exist"));
    }
}
