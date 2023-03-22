<?php
require './Database/database.php';
require './Controller/proceedtopaycontroller.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET");
$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = explode('/', $url);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$con = Database::get_con();
$cart = new ProceedtopayController($con, $url, $requestMethod);
$cart->order_request_process();