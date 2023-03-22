<?php
require './Database/database.php';
require './Controller/ordercontroller.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET");
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = explode('/', $url);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$con = Database::get_con();
if (isset($_GET['Userid'])) {
    $userid = $_GET['Userid'];
} else {
    $userid = null;
}
$order = new OrderController($con, $requestMethod, $url, $userid);
$order->order_process_request();