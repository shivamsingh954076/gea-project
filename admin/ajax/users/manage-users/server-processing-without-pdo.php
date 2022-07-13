<?php
// session_start();
include("../../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();
?>

<?php
$columns = array('ur.id', 'ur.name', 'ur.username', 'ur.mobile', 'ur.email', 'ur.user_active', 'ur.id');

$query = "SELECT * FROM users ur ";

if ((isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') || (isset($_POST['filter_search_input'], $_POST['filter_searching'], $_POST['filter_operator']) && $_POST['filter_search_input'] != '' && $_POST['filter_searching'] != '' && $_POST['filter_operator'] != '')) {
    if (isset($_POST["search"]["value"]) && $_POST["search"]["value"] != '') {
        $query .= '
        WHERE ur.name LIKE "%' . $_POST["search"]["value"] . '%"
        ';
    } else if (isset($_POST['filter_search_input'], $_POST['filter_searching'], $_POST['filter_operator']) && $_POST['filter_search_input'] != '' && $_POST['filter_searching'] != '' && $_POST['filter_operator'] != '') {
        if ($_POST['filter_operator'] == "LIKE") {
            $query .= '
            WHERE ' . $_POST['filter_searching'] . ' LIKE "%' . $_POST['filter_search_input'] . '%" 
            ';
        } else {
            $query .= '
            WHERE ' . $_POST['filter_searching'] . ' = "' . $_POST['filter_search_input'] . '" 
            ';
        }
    }
}

if (isset($_POST["order"])) {
    $query .= 'ORDER BY ' . $columns[$_POST['order']['0']['column']] . ' ' . $_POST['order']['0']['dir'] . ' 
 ';
} else {
    $query .= 'ORDER BY ur.id DESC ';
}

$query1 = '';

if ($_POST["length"] != -1) {
    $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$stmt = $conn->prepare($query . $query1);
$stmt->execute();
$number_filter_row = $stmt->rowCount();

$data = array();
$i = 1;
while ($row = $stmt->fetch()) {
    if($row["user_active"] == 1){
        $user_status = 'Active';
    }else{
        $user_status = 'In-Active';
    }
    $sub_array = array();
    $sub_array[] = $i;
    $sub_array[] = '<div class="update" data-highlight-color="highlight" data-id="' . $row["id"] . '" data-column="name">' . $row["name"] . '</div>';
    $sub_array[] = '<div class="update" data-highlight-color="highlight" data-id="' . $row["id"] . '" data-column="username">' . $row["username"] . '</div>';
    $sub_array[] = '<div class="update" data-highlight-color="highlight" data-id="' . $row["id"] . '" data-column="mobile">' . $row["mobile"] . '</div>';
    $sub_array[] = '<div class="update" data-highlight-color="highlight" data-id="' . $row["id"] . '" data-column="email">' . $row["email"] . '</div>';
    $sub_array[] = '<div class="update" data-highlight-color="highlight" data-id="' . $row["id"] . '" data-column="user_active">' . $user_status . '</div>';
    $sub_array[] = '<button type="button" name="update" class="btn btn-warning btn-xs updateData mx-2" id="' . $row["id"] . '" onclick="editUser(' . $row["id"] . ')">Edit</button><button type="button" name="delete" class="btn btn-danger btn-xs delete" onclick="deleteUser(' . $row["id"] . ')" id="' . $row["id"] . '">Delete</button>';
    $data[] = $sub_array;
    $i++ ;
}

function get_all_data($conn)
{
    $query = "SELECT * FROM users ur";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->rowCount();
    return $result;
}

$output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  get_all_data($conn),
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
);

echo json_encode($output);

?>
