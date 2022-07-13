<?php
session_start();
include("../../../../config/connect.php");
$database = new Connection();
$conn = $database->openConnection();

$nameRegx = '/^[a-zA-Z0-9 ]*$/';
$mobileRegx = '/^\d+$/';
$country_name_regx = "/^[A-Za-z0-9-_\.()', ]+$/";
$country_code_regx = '/^[a-zA-Z]{2}$/';
$country_currency_regx = ' /^[a-zA-Z]{1,3}$/';

if (isset($_POST)) {
    $data = $_POST;
    $country_name = $data['country_name'];
    $country_phone = $data['country_phone'];
    $country_code = $data['country_code'];
    $country_symbol = $data['country_symbol'];
    $country_capital = $data['country_capital'];
    $country_currency = $data['country_currency'];
    $country_status = $data['country_status'];
    if($country_symbol == ''){
        $country_symbol = NULL;
    }
    if($country_capital == ''){
        $country_capital = NULL;
    }
    if($country_currency == ''){
        $country_currency = NULL;
    }
    if ($country_name != '' && strlen($country_name) >= 2 && strlen($country_name) <= 100 && preg_match($country_name_regx, $country_name) && $country_phone != '' && strlen($country_phone) >= 1 && strlen($country_phone) <= 5 && (preg_match($mobileRegx, $country_phone)) && $country_code != '' && strlen($country_code) == 2 && (preg_match($country_code_regx, $country_code)) && ($country_symbol == '' || (strlen($country_symbol) >= 1 && strlen($country_symbol) <= 10)) && ($country_capital == '' || (strlen($country_capital) >= 2 && strlen($country_capital) <= 100 && preg_match($country_name_regx, $country_capital))) && ($country_currency == '' || (strlen($country_currency) >= 1 && strlen($country_currency) <= 3 && preg_match($country_currency_regx, $country_currency))) && ($country_status == 1 || $country_status == 0)) {
        $sel_country = $conn->prepare("SELECT * FROM countries WHERE name=:name");
        $sel_country->execute([":name" => $country_name]);
        if ($sel_country->rowCount() == 0) {
            $ins_qry = $conn->prepare("INSERT INTO countries(phone, code, name, symbol, capital, currency, active, created_datetime) VALUES(:phone, :code, :name, :symbol, :capital, :currency, :active, :created_datetime)");
            $insert_sql = $ins_qry->execute([":phone" => $country_phone, ":code" => $country_code, ":name" => $country_name, ":symbol" => $country_symbol, ":capital" => $country_capital, ":currency" => $country_currency, ":active" => $country_status, ":created_datetime" => $datetime]);
            if ($insert_sql) {
                echo json_encode(array("result" => 1));
            } else {
                echo json_encode(array("result" => 'data_err'));
            }
        } else {
            echo json_encode(array("result" => 'country_exist'));
        }
    } else {
        echo json_encode(array("result" => 'validation_err'));
    }
} else {
    echo json_encode(array("result" => 'request_err'));
}
