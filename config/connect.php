<?php

class Connection
{
    private $server = "mysql:host=localhost;dbname=gea_project";
    private $user = "root";
    private $pass = "";
    private $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC);
    private $conn;

    public function openConnection()
    {
        try {
            $this->conn = new PDO($this->server, $this->user, $this->pass, $this->options);
            return $this->conn;
        } catch (Exception $e) {
            echo "There is some problem in connection: " . $e->getMessage();
        }
    }

    public function closeConnection()
    {
        $this->conn = null;
    }
}
// For Base Url's
$base_url = "https://".$_SERVER['HTTP_HOST']."/adminGSA/";
$base_url_admin = "https://".$_SERVER['HTTP_HOST']."/adminGSA/admin/";
// For Timezones
date_default_timezone_set('asia/kolkata');
$datetime = date("Y-m-d H:i:s");
$date = date("Y-m-d");
$time = date("h:i:s a");