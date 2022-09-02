<?php

require "./utils/constants.php";
include_once "./utils/helpers.php";
include_once "./utils/http.php";
include_once "./utils/validators.php";
include_once "./utils/files.php";

include_once "./models/order_status.php";
include_once "./models/product.php";
include_once "./models/customer.php";
include_once "./models/vendor.php";

include_once "./controller/order_status_controller.php";
include_once "./controller/product_controller.php";
include_once "./controller/customer_controller.php";
include_once "./controller/vendor_controller.php";

include_once "./db/db_connector.php";

$shopDb = (new DatabaseConnector())->getShopDbConnection();

$accountDb = (new DatabaseConnector())->getAccountDbConnection();

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER["REQUEST_METHOD"];

if (strpos($uri, "/assets")) {
    return;
}

// all of our endpoints start with /api
// everything else results in a 404 Not Found
if (strpos($uri, '/api') === false) {
    header($NOT_FOUND_STATUS_CODE);
    exit();
}

if (strpos($uri, "/orderStatus")) {
    $orderStatuscontroller = new OrderStatusController($shopDb, $requestMethod);
    $orderStatuscontroller->processRequest();
} else if (strpos($uri, "/product")) {
    $productcontroller = new ProductController($shopDb, $requestMethod);
    $productcontroller->processRequest();
} else if (strpos($uri, "/customer")) {
    $customercontroller = new CustomerController($accountDb, $requestMethod);
    $customercontroller->processRequest();
} else if (strpos($uri, "/vendor")){
    $vendorcontroller = new VendorController($accountDb, $requestMethod);
    $vendorcontroller->processRequest();
} else {
    notFoundResponse();
}
