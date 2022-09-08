<?php

class CustomerController
{

    private $db;
    private $requestMethod;
    private $CustomerModel;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->CustomerModel = new Customer($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->addCustomer();
                break;
            case 'GET';
                $response = $this->getCustomers();
                break;
            case 'DELETE';
                $response = $this->deleteCustomer();
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

    private function addCustomer()
    {
        global $BAD_REQUEST_STATUS_CODE, $TARGET_CUSTOMER_PHOTO_DIR, $CREATED_STATUS_CODE,$DEFAULT_AVATAR_PROFILE_PHOTO;

        $error = $this->validateCreateCustomerInputs();
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $username = $_POST["Username"];
        $name = $_POST["Name"];
        $password = $_POST["Password"];
        $address = $_POST["Address"];
        $imagePath = "http://".$_SERVER['SERVER_NAME'].$TARGET_CUSTOMER_PHOTO_DIR.$DEFAULT_AVATAR_PROFILE_PHOTO;
        $password = hashPassword($password);
    

        if (isset($_FILES["ProfilePhoto"])){
            $targetDir = ".".$TARGET_CUSTOMER_PHOTO_DIR.$username."/";

            $error = validateUploadedFile($targetDir,"ProfilePhoto");
            if ($error != ""){
                $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
                $response['body'] = json_encode($error);
                return $response;
            }
    
            $uploadedProfilePhoto = $_FILES["ProfilePhoto"];
            $targetFile =  $targetDir.basename($uploadedProfilePhoto["name"]);
            $imagePath =  "http://".$_SERVER['SERVER_NAME'].$TARGET_CUSTOMER_PHOTO_DIR.$username."/".basename($uploadedProfilePhoto["name"]);
    
            $error = saveUploadedFile($uploadedProfilePhoto,$targetDir);
            if ($error != ""){
                $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
                $response['body'] = json_encode($error);
                return $response;
            }
        }

        $result = $this->CustomerModel->create($username, $password, $name, $imagePath, $address);
        $response['status_code_header'] = $CREATED_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function getCustomers()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->CustomerModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteCustomer(){
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE;
        $input = json_decode(file_get_contents('php://input'), TRUE);

        $error = $this-> validateCustomerID($input);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $result = $this->CustomerModel->delete($input["CustomerID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function validateCreateCustomerInputs(){
        global $EXISTING_USERNAME_ERROR_CODE, $MISSING_REQUIRED_INPUTS_ERROR_CODE,$INVALID_ADDRESS_ERROR_CODE,$INVALID_NAME_ERROR_CODE;

        if (!isset($_POST["Username"]) || !isset($_POST["Name"]) || !isset($_POST["Address"]) || !isset($_POST["Password"])){
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        $username = $_POST["Username"];
        $name = $_POST["Name"];
        $password = $_POST["Password"];
        $address = $_POST["Address"];

        $error = validateUsername($username);
        if ($error != ""){
            return $error;
        }
        $result = $this->CustomerModel->findByUsername($username);
        if (isset( $result["Username"])){
            return errorResponse($EXISTING_USERNAME_ERROR_CODE);
        }

        $error = validatePassword($password);
        if ($error != ""){
            return $error;
        }

        $error = validateRequiredInput($name,$INVALID_NAME_ERROR_CODE );
        if ($error != ""){
            return $error;
        }

        $error = validateRequiredInput($address,$INVALID_ADDRESS_ERROR_CODE);
        if ($error != ""){
            return $error;
        }

        return "";
    }

    private function validateCustomerID($CustomerID){
        global $NON_EXISTING_CUSTOMER_ERROR_CODE;

        if (!isset($CustomerID["CustomerID"])){
            return errorResponse($NON_EXISTING_CUSTOMER_ERROR_CODE);
        }

        $result = $this->CustomerModel->findByCustomerID($CustomerID["CustomerID"]);
        if (!isset( $result["CustomerID"])){
            return errorResponse($NON_EXISTING_CUSTOMER_ERROR_CODE);
        }

        return "";
    }
}
