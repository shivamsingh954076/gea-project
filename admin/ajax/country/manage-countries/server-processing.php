<?php
// session_start();
include("../../../../config/connect.php");
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
    $searchQuery = " AND (code LIKE :code OR  
        phone LIKE :phone OR 
        name LIKE :name OR 
        symbol LIKE :symbol OR 
        capital LIKE :capital OR 
        currency LIKE :currency OR 
        active LIKE :active) ";
    $searchArray = array(
        'code' => "%$searchValue%",
        'phone' => "%$searchValue%",
        'name' => "%$searchValue%",
        'symbol' => "%$searchValue%",
        'capital' => "%$searchValue%",
        'currency' => "%$searchValue%",
        'active' => "%$searchValue%"
    );
}

## Total number of records without filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM countries ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM countries WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT * FROM countries WHERE 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
    $data[] = array(
        "id" => $row['id'],
        "code" => $row['code'],
        "phone" => $row['phone'],
        "name" => $row['name'],
        "symbol" => $row['symbol'],
        "capital" => $row['capital'],
        "currency" => $row['currency'],
        "active" => $active,
        "action" => '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="editCountry(' . $row["id"] . ')">Edit</button><button type="button" name="delete" class="btn btn-danger btn-xs delete" onclick="deleteCountry(' . $row["id"] . ')" id="' . $row["id"] . '">Delete</button>'
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
