<?php
require './Database/database.php';
require './Controller/profilecontroller.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET");
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = explode('/', $url);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$con = Database::get_con();
if (isset($_GET['id'])) {
    $userid = $_GET['id'];
} else {
    $userid = null;
}
$profile = new ProfileController($con, $requestMethod, $url, $userid);
$profile->process_request();