<?php

include_once "./models/order_status.php";
include_once "./controller/order_status_controller.php";
include_once "./db/db_connector.php";
include_once "./utils/http.php";


$shopDb = (new DatabaseConnector())->getShopDbConnection();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];

// all of our endpoints start with /api
// everything else results in a 404 Not Found
if (strpos($uri, '/api') === false) {
    header("HTTP/1.1 404 Not Found");
    exit();
}

if (strpos($uri, "/orderStatus") === true){
    $orderStatuscontroller = new OrderStatusController($shopDb, $requestMethod);
    $orderStatuscontroller->processRequest();
} else{
    notFoundResponse();
}


?>