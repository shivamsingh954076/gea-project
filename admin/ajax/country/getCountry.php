<?php
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST['country_id'])) {
    $id = (int)$_POST['country_id'];
    if ($id != '' && is_int($id)) {
        // For Country and Document Details
        $chk_country = $conn->prepare("SELECT doc.id as document_id, doc.doc_name as document_name, country.phone as country_code FROM countries as country INNER JOIN doc_countries as doc_country ON doc_country.country_id=country.id INNER JOIN document AS doc ON doc.id=doc_country.doc_id WHERE country.id=:id");
        $chk_country->execute([":id" => $id]);
        $get_country = $chk_country->fetchAll();
        // For Country Details
        $country_qry = $conn->prepare("SELECT * FROM countries WHERE id=:id");
        $country_qry->execute([":id" => $id]);
        $country_data = $country_qry->fetchAll();

        if ($country_qry->rowCount() >= 1) {
            echo json_encode(array("result" => 1, "document_data" => array($get_country), "country_code" => $country_data[0]['phone'], "currency" => $country_data[0]['currency'], "symbol" => $country_data[0]['symbol']));
        } else {
            echo json_encode(array("result" => 0));
        }
    }
}else{
    echo json_encode(array("result" => 0, "status" => "Req. error"));
}
