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
    $searchQuery = " AND (level_name LIKE :level_name OR  
        level_no LIKE :level_no OR 
        total_token LIKE :total_token OR 
        active LIKE :active) ";
    $searchArray = array(
        'level_name' => "%$searchValue%",
        'level_no' => "%$searchValue%",
        'total_token' => "%$searchValue%",
        'active' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM level ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM level WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT * FROM level WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
        "level_name" => $row['level_name'],
        "img" => '<img src="data/level/'.$row['img'].'" class="w-20">',
        "level_no" => $row['level_no'],
        "total_token" => $row['total_token'],
        "description" => $row['description'],
        "active" => $active,
        "action" => '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="editLevel(' . $row["id"] . ')">Edit</button><button type="button" name="delete" class="btn btn-danger btn-xs delete" onclick="deleteLevel(' . $row["id"] . ')" id="' . $row["id"] . '">Delete</button>'
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
