<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST)) {
    $data = $_POST;
    $name = strtolower($data['name']);
    $page_name = preg_replace("/[^A-Z0-9]+/i", "_", $name);
    $status = $data['status'];

    $chk_columns = $conn->prepare("SHOW COLUMNS FROM `pages` LIKE '$page_name'");
    $chk_columns->execute();
    $fech_col = $chk_columns->fetch();
    $total_col = $conn->prepare("SELECT count(*) AS total_col FROM information_schema.columns WHERE table_name = 'pages'");
    $total_col->execute();
    $total_col_count = $total_col->fetch();
    if ($total_col_count['total_col'] <= '8') {
        if ($chk_columns->rowCount() == 1) {
            $chk = $conn->prepare("SELECT $page_name FROM pages WHERE id=:id");
            $chk->execute([":id" => 1]);
            $fetch_page = $chk->fetch();
            if ($chk->rowCount() == 1) {
                $data_decode = json_decode($fetch_page[$page_name], true);
                $data_decode['status'] = $status;
                $content = json_encode(array("title" => $data_decode['title'], "content" => $data_decode['content'], "status" => $data_decode['status']));
                $update = $conn->prepare("UPDATE pages SET $page_name = :$page_name WHERE id=:id");
                $update_qry = $update->execute([":$page_name" => $content, ":id" => 1]);
                if ($update_qry) {
                    echo json_encode(array("result" => 1, "page_name" => $page_name));
                } else {
                    echo json_encode(array("result" => "data_err"));
                }
            } else {
                echo json_encode(array("result" => "something_wrong"));
            }
        } else {
            $chk = $conn->prepare("ALTER TABLE pages ADD $page_name LONGTEXT");
            $col_set = $chk->execute();
            if ($col_set) {
                $content = json_encode(array("title" => $data['name'], "content" => "", "status" => $status));
                $update = $conn->prepare("UPDATE pages SET $page_name = :$page_name WHERE id=:id");
                $update_qry = $update->execute([":$page_name" => $content, ":id" => 1]);
                if ($update_qry) {
                    echo json_encode(array("result" => 1, "page_name" => $page_name));
                } else {
                    echo json_encode(array("result" => "data_err"));
                }
            }
        }
    }else{
        echo json_encode(array("result" => "max_limit"));
    }
} else {
    echo json_encode(array("result" => "request_err"));
}
