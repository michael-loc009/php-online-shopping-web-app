<?php

class AuthenticationController
{
    private $requestMethod;
    private $CustomerModel;
    private $ShipperModel;
    private $VendorModel;

    public function __construct($db, $requestMethod)
    {
        $this->requestMethod = $requestMethod;

        $this->CustomerModel = new Customer($db);
        $this->ShipperModel = new Shipper($db);
        $this->VendorModel = new Vendor($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->login();
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

    private function login()
    {
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE, $CUSTOMER_TYPE, $VENDOR_TYPE, $SHIPPER_TYPE, $INVALID_LOGIN_ERROR_CODE;

        $input = json_decode(file_get_contents('php://input'), true);

        $error = $this->validateLoginInputs($input);
        if ($error != "") {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $username = $input["Username"];
        $type = $input["Type"];
        $password = $input["Password"];

        switch ($type) {
            case $CUSTOMER_TYPE:
                $result = $this->CustomerModel->findByUsername($username);
                break;
            case $VENDOR_TYPE:
                $result = $this->VendorModel->findByUsername($username);
                break;
            case $SHIPPER_TYPE:
                $result = $this->ShipperModel->findByUsername($username);
                break;
        }

        if (!isset($result["Username"]) || !password_verify($password,$result["Password"])) {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode(errorResponse($INVALID_LOGIN_ERROR_CODE));
            return $response;
        }

        unset($result["Password"]);

        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function validateLoginInputs($input)
    {
        global $MISSING_REQUIRED_INPUTS_ERROR_CODE,$INVALID_ACCOUNT_TYPE_ERROR_CODE,$CUSTOMER_TYPE, $VENDOR_TYPE, $SHIPPER_TYPE;
    
        if (!isset($input["Username"]) || !isset($input["Password"]) || !isset($input["Type"])) {
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        $username = $input["Username"];
        $type = $input["Type"];
        $password = $input["Password"];

        $error = validateUsername($username);
        if ($error != "") {
            return $error;
        }
    
        $error = validatePassword($password);
        if ($error != "") {
            return $error;
        }

        if ($type !=$CUSTOMER_TYPE && $type != $SHIPPER_TYPE && $type != $VENDOR_TYPE){
            return errorResponse($INVALID_ACCOUNT_TYPE_ERROR_CODE);
        }

        return "";
    }
}
