<?php
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

if (isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    if ($id != '' && is_int($id)) {
        // For Country and Document Details
        $chk_doc = $conn->prepare("SELECT * FROM doc_countries as doc_country INNER JOIN document as doc ON doc.id=doc_country.doc_id WHERE country_id=:country_id");
        $chk_doc->execute([":country_id" => $id]);
        $get_doc = $chk_doc->fetchAll();
        if ($chk_doc->rowCount() >= 1) {
            $doc_array = [];
            foreach ($get_doc as $key => $gc) {
                $doc_array[$key]['doc_id'] = $gc['doc_id'];
                $doc_array[$key]['doc_name'] = $gc['doc_name'];
            }
            echo json_encode(array("result" => 1, "document_data" => $doc_array));
        }
    }
}
