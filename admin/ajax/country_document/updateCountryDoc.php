<?php
session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST) && isset($_SESSION['edit_country_doc_id'])) {
    $id = $_POST['country_doc_id'];
    $data = $_POST;
    $country = $data['country_select'];
    $document = $data['doc'];
    $status = $data['status'];
    $delete = $conn->prepare("DELETE FROM doc_countries WHERE country_id=:country_id");
    $dlt_qry = $delete->execute([":country_id" => $id]);
    if ($dlt_qry) {
        $i = 1;
        foreach ($document as $doc) {
            $insert = $conn->prepare("INSERT INTO doc_countries(country_id, doc_id, active, created_at, updated_at) VALUES(:country_id, :doc_id, :active, :created_at, :updated_at)");
            $insert_qry = $insert->execute([":country_id" => $country, ":doc_id" => $doc, ":active" => $status, ":created_at" => $datetime, ":updated_at" => $datetime]);
            if ($insert_qry && count($document) == $i) {
                echo json_encode(array("result" => 1));
            }
            $i++;
        }
    }
} else {
    echo json_encode(array("result" => "request_err"));
}
