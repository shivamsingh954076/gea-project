<?php
session_start();
include("../../../config/connect.php");
include("../../../config/function.php");
$database = new Connection();
$conn = $database->openConnection();
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
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM transaction ");
$stmt->execute();
$records = $stmt->fetch();
$totalRecords = $records['allcount'];

## Total number of records with filtering
$stmt = $conn->prepare("SELECT COUNT(*) AS allcount FROM transaction WHERE 1 " . $searchQuery);
$stmt->execute($searchArray);
$records = $stmt->fetch();
$totalRecordwithFilter = $records['allcount'];

## Fetch records
$stmt = $conn->prepare("SELECT txn.*, (SELECT email FROM users WHERE id=txn.transfer_id) as transfer_email FROM transaction AS txn  INNER JOIN users AS user ON user.id=txn.user_id WHERE user.id={$_SESSION['txn_user_id']} AND 1 " . $searchQuery . " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :limit,:offset");

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
    // For amount
    // For Txn Type
    if ($row['txn_type'] == 'cr') {
        $txn_type = '<span class="text-theme-9">Credit</span>';
        $amt = '<span class="text-theme-9 font-medium">+ ' . $row['amt'] . '</span>';
    } else if ($row['txn_type'] == 'dr') {
        $txn_type = '<span class="text-theme-6">Debit</span>';
        $amt = '<span class="text-theme-6 font-medium">- ' . $row['amt'] . '</span>';
    } else {
        $txn_type = '';
        $amt = $row['amt'];
    }
    // For Transfer Email
    if ($row['transfer_email'] != NULL || $row['transfer_email'] != '') {
        if ($row['txn_type'] == 'cr') {
            $to_from = 'Received From : ';
        } else {
            $to_from = 'To : ';
        }
        $transfer_email =  $to_from . '<span class="text-theme-1 underline cursor-pointer"><a href="javascript:viewTxnOther(' . $row['transfer_id'] . ')"> ' . $row['transfer_email'] . '</a></span>';
    } else {
        $transfer_email = '-';
    }
    // For Mode
    if ($row['mode'] == 'transfer_send') {
        $transfer_mode =  'Money Send';
    } else if ($row['mode'] == 'transfer_receive') {
        $transfer_mode =  'Money Received';
    } else {
        $transfer_mode = $row['mode'];
    }
    $bal = $userDetail->txnAmt($conn, $row['id']);
    $data[] = array(
        "id" => $row['id'],
        "amt" => $amt,
        "txn_type" => $txn_type,
        "txn_status" => $row['txn_status'],
        "txn_id" => $row['txn_id'],
        "mode" => $transfer_mode,
        "transfer_id" => $transfer_email,
        "message" => $row['message']
        // "action" => '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="viewTxn(' . $row["id"] . ')">View</button>'
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
