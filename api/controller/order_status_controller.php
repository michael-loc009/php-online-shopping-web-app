<?php


class OrderStatusController {

    private $db;
    private $requestMethod;
    private $orderStatusModel;
    private $OrderModel;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->orderStatusModel = new OrderStatus($db);
        $this->OrderModel = new Order($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getOrderStatuses();
                break;
            case 'POST';
                $response = $this->updateOrder();
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

    private function getOrderStatuses()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->orderStatusModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function updateOrder()
    {
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE;
        $input = json_decode(file_get_contents('php://input'), true);

        $error = $this->validateOrderID($input);
        if ($error != "") {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $error = $this->validateOrderStatusID($input);
        if ($error != "") {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $result = $this->OrderModel->updateOrderStatus($input["OrderID"], $input["OrderStatusID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
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

    private function validateOrderStatusID($orderStatusID)
    {
        global $NON_EXISTING_ORDER_STATUS_ERROR_CODE, $ORDER_DELIVERED_STATUS, $ORDER_CANCELLED_STATUS;

        if (!isset($orderStatusID["OrderStatusID"]) || ($orderStatusID["OrderStatusID"] != $ORDER_DELIVERED_STATUS && $orderStatusID["OrderStatusID"] != $ORDER_CANCELLED_STATUS)) {
            return errorResponse($NON_EXISTING_ORDER_STATUS_ERROR_CODE);
        }

        return "";
    }
}