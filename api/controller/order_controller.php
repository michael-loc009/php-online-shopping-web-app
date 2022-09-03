<?php

class OrderController
{
    private $requestMethod;
    private $OrderModel;
    private $CustomerModel;
    private $DistributionHubModel;
    private $ProductModel;

    public function __construct($accountDb, $shopDb, $requestMethod)
    {
        $this->requestMethod = $requestMethod;
        $this->OrderModel = new Order($shopDb);
        $this->ProductModel = new Product($shopDb);
        $this->DistributionHubModel = new DistributionHub($shopDb);
        $this->CustomerModel = new Customer($accountDb);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->addOrder();
                break;
            case 'GET';
                $response = $this->getOrders();
                break;
            case 'DELETE';
                $response = $this->deleteOrder();
                break;
            default:
                $response = notFoundResponse();
                break;
        }

        header($response['status_code_header']);
        if ($response['body']) {
            echo $response['body'];
        }
    }

    private function addOrder()
    {
        global $BAD_REQUEST_STATUS_CODE, $CREATED_STATUS_CODE, $ORDER_ACTIVE_STATUS;

        $input = json_decode(file_get_contents('php://input'), true);

        $error = $this->validateCreateOrderInputs($input);
        if ($error != "") {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $total = (float) $input["Total"];
        $distributionHubID = $this->randomDistributionHub();
        $customerID = (int) $input["CustomerID"];
        $orderItems = (array) $input["OrderItems"];
        $status = (int) $ORDER_ACTIVE_STATUS;

        $result = $this->OrderModel->create($customerID, $distributionHubID, $status, $total, $orderItems);
        $response['status_code_header'] = $CREATED_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function getOrders()
    {
        global $SUCCESS_STATUS_CODE,$BAD_REQUEST_STATUS_CODE,$NON_EXISTING_DISTRIBUTION_HUB_ERROR_CODE;

        if (!isset($_GET["DistributionHubID"])){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode( errorResponse($NON_EXISTING_DISTRIBUTION_HUB_ERROR_CODE));
            return $response;
        }

        $result = $this->OrderModel->findAll($_GET["DistributionHubID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteOrder()
    {
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE;
        $input = json_decode(file_get_contents('php://input'), true);

        $error = $this->validateOrderID($input);
        if ($error != "") {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $result = $this->OrderModel->delete($input["OrderID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function validateCreateOrderInputs($input)
    {
        global $MISSING_REQUIRED_INPUTS_ERROR_CODE, $NON_EXISTING_CUSTOMER_ERROR_CODE, $INVALID_ORDER_TOTAL_ERROR_CODE, $MISSING_ORDER_ITEMS_ERROR_CODE, $INVALID_ORDER_QUANTITY_ERROR_CODE, $NON_EXISTING_PRODUCT_ERROR_CODE;

        if (!isset($input["OrderItems"]) || !isset($input["Total"]) || !isset($input["CustomerID"])) {
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        $total = (float) $input["Total"];
        $customerID = (int) $input["CustomerID"];
        $orderItems = (array) $input["OrderItems"];

        if ($total <= 0) {
            return errorResponse($INVALID_ORDER_TOTAL_ERROR_CODE);
        }

        if (count($orderItems) <= 0) {
            return errorResponse($MISSING_ORDER_ITEMS_ERROR_CODE);
        }

        $result = $this->CustomerModel->findByCustomerID($customerID);
        if (!isset($result["CustomerID"])) {
            return errorResponse($NON_EXISTING_CUSTOMER_ERROR_CODE);
        }

        foreach ($orderItems as $key => $val) {
            if (!isset($val["ProductID"]) || !isset($val["Quantity"])) {
                return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
            }

            $quantity = (int) $val["Quantity"];
            $productID = (int) $val["ProductID"];
            if ($quantity <= 0) {
                return errorResponse($INVALID_ORDER_QUANTITY_ERROR_CODE);
            }
            if ($productID <= 0) {
                return errorResponse($NON_EXISTING_PRODUCT_ERROR_CODE);
            }

            $result = $this->ProductModel->findByProductID($productID);
            if (!isset($result["ProductID"])) {
                return errorResponse($NON_EXISTING_PRODUCT_ERROR_CODE);
            }
        }

        return "";
    }

    private function validateOrderID($OrderID)
    {
        global $NON_EXISTING_ORDER_ERROR_CODE;

        if (!isset($OrderID["OrderID"])) {
            return errorResponse($NON_EXISTING_ORDER_ERROR_CODE);
        }

        $result = $this->OrderModel->findByOrderID($OrderID["OrderID"]);
        if (!isset($result["OrderID"])) {
            return errorResponse($NON_EXISTING_ORDER_ERROR_CODE);
        }

        return "";
    }

    private function randomDistributionHub()
    {
        return rand(1, 2);
    }
}
