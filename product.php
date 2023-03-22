<?php
require './Database/database.php';
require './Controller/productcontroller.php';

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST GET");

$url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$url = explode('/', $url);
$requestMethod = $_SERVER["REQUEST_METHOD"];
$con = Database::get_con();
if (isset($url[3])) {
     $productid[1] = $url[3];
} else {
     $productid[1] = null;
}

$product = new ProductController($con, $requestMethod, $url, $productid[1]);
$product->process_request();