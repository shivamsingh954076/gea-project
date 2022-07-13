<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $data = $_POST;
    $name = strtolower($data['name']);
    $page_name = preg_replace("/[^A-Z0-9]+/i", "_", $name);

    $chk_columns = $conn->prepare("SHOW COLUMNS FROM `pages` LIKE '$page_name'");
    $chk_columns->execute();
    $fech_col = $chk_columns->fetch();
    $total_col = $conn->prepare("SELECT count(*) AS total_col FROM information_schema.columns WHERE table_name = 'pages'");
    $total_col->execute();
    $total_col_count = $total_col->fetch();
    if ($total_col_count['total_col'] <= '8') {
        if ($chk_columns->rowCount() == 1) {
            $chk = $conn->prepare("ALTER TABLE pages DROP COLUMN $page_name");
            $col_set = $chk->execute();
            if ($col_set) {
                echo json_encode(array("result" => 1));
            } else {
                echo json_encode(array("result" => "data_err"));
            }
        } else {
            echo json_encode(array("result" => "not_found"));
        }
    }else{
        echo json_encode(array("result" => "max_limit"));
    }
} else {
    echo json_encode(array("result" => "request_err"));
}
