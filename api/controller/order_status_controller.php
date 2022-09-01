<?php


class OrderStatusController {

    private $db;
    private $requestMethod;
    private $orderStatusModel;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->orderStatusModel = new OrderStatus($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $response = $this->getAllUsers();
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

    private function getAllUsers()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->orderStatusModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }
}