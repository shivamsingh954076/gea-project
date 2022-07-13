<?php
// session_start();
include("../../../config/connect.php");
include("../../../config/function.php");
$database = new Connection();
$conn = $database->openConnection();
// echo "es";
// print_r($empRecords);
// die();
$userDetail = new UserDetail();
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
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM users ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM users WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT user.*, country.currency AS currency, gea.value AS value FROM users AS user INNER JOIN countries AS country ON country.id = user.country_id INNER JOIN gea_currency AS gea ON gea.country_id=country.id WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
    if($row['user_active'] == 1){
        $active = 'Active';
    }else{
        $active = 'In-Active';
    }
    $bal = $userDetail->txnAmt($conn, $row['id']);
    $avl_token = ($bal/$row['value']);
    $avl_token = number_format((float)$avl_token, 2, '.', ''); 
    $data[] = array(
        "id" => $row['id'],
        "name" => $row['name'],
        "username" => $row['username'],
        "email" => $row['email'],
        "currency" => $row['currency'],
        "balance" => $bal,
        "gea_token" => $avl_token,
        "active" => $active,
        "action" => '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="viewTxn(' . $row["id"] . ')">View</button>'
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
