<?php
// session_start();
include("../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
## Read value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
$searchValue = $_POST['search']['value']; // Search value

$searchArray = array();

## Search 
$searchQuery = " ";
if ($searchValue != '') {
    $searchQuery = " AND (doc_name LIKE :doc_name OR  
        description LIKE :description OR 
        active LIKE :active) ";
    $searchArray = array(
        'doc_name' => "%$searchValue%",
        'description' => "%$searchValue%",
        'active' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM kyc_request ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM kyc_request WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT kyc.*, usr.name AS name, usr.username AS username, usr.email AS email, country.name AS country_name, doc.doc_name AS doc_name FROM kyc_request AS kyc INNER JOIN countries AS country ON kyc.country_id=country.id AND country.active=1 INNER JOIN document AS doc ON kyc.doc_id=doc.id AND doc.active=1 INNER JOIN users AS usr ON kyc.user_id=usr.id WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

// Bind values
foreach ($searchArray as $key => $search) {
    $stmt->bindValue(':' . $key, $search, PDO::PARAM_STR);
}

$stmt->bindValue(':limit', (int)$row, PDO::PARAM_INT);
$stmt->bindValue(':offset', (int)$rowperpage, PDO::PARAM_INT);
$stmt->execute();
$empRecords = $stmt->fetchAll();

$data = array();

$i = 1;
foreach ($empRecords as $row) {
    if($row['img'] == NULL){
        $row['img'] = 'no_image.webp';
    }
    $btn_approve = $btn_decline = '';
    if($row['kyc_status'] == 'pending'){
        $btn_approve = '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="updateKYC(' . $row["id"] . ', \'approved\')">Approve</button>';
        $btn_decline = '<button type="button" name="delete" class="btn btn-danger mt-1 btn-xs delete" onclick="updateKYC(' . $row["id"] . ', \'decline\')" id="' . $row["id"] . '">Decline</button>';    
    }else if($row['kyc_status'] == 'approved'){
        $btn_decline = '<button type="button" name="delete" class="btn btn-danger mt-1 btn-xs delete" onclick="updateKYC(' . $row["id"] . ', \'decline\')" id="' . $row["id"] . '">Decline</button>'; 
    }else{
        $btn_approve = '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="updateKYC(' . $row["id"] . ', \'approved\')">Approve</button>';
    }
    $data[] = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "username" => $row['username'],
        "email" => $row['email'],
        "country" => $row['country_name'],
        "doc_name" => $row['doc_name'],
        "doc_number" => $row['doc_number'],
        "description" => $row['description'],
        "doc_img" => '<img src="data/kyc/'.$row['img'].'" class="w-20">',
        "kyc_status" => ucfirst($row['kyc_status']),
        "decline_region" => ucfirst($row['decline_region']),
        "action" => $btn_approve.$btn_decline
    );
}

## Response
$response = array(
    "draw" => intval($draw),
    "iTotalRecords" => $totalRecords,
    "iTotalDisplayRecords" => $totalRecordwithFilter,
    "aaData" => $data
);

echo json_encode($response);
