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
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM document ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM document WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT * FROM document WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
    if($row['active'] == 1){
        $active = 'Active';
    }else{
        $active = 'In-Active';
    }
    if($row['img'] == NULL){
        $row['img'] = 'no_image.webp';
    }
    $data[] = array(
        "id" => $row['id'],
        "doc_name" => $row['doc_name'],
        "img" => '<img src="data/document_set/'.$row['img'].'" class="w-20">',
        "description" => $row['description'],
        "active" => $active,
        "action" => '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="editDocument(' . $row["id"] . ')">Edit</button><button type="button" name="delete" class="btn btn-danger btn-xs delete" onclick="deleteDocument(' . $row["id"] . ')" id="' . $row["id"] . '">Delete</button>'
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
