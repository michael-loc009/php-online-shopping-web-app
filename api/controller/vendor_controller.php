<?php

class VendorController
{

    private $db;
    private $requestMethod;
    private $VendorModel;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->VendorModel = new Vendor($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->addVendor();
                break;
            case 'GET';
                $response = $this->getVendors();
                break;
            case 'DELETE';
                $response = $this->deleteVendor();
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

    private function addVendor()
    {
        global $BAD_REQUEST_STATUS_CODE, $TARGET_VENDOR_PHOTO_DIR , $CREATED_STATUS_CODE,$DEFAULT_AVATAR_PROFILE_PHOTO;

        $error = $this->validateCreateVendorInputs();
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $username = $_POST["Username"];
        $name = $_POST["BusinessName"];
        $password = $_POST["Password"];
        $address = $_POST["BusinessAddress"];
        $imagePath = "http://".$_SERVER['SERVER_NAME'].$TARGET_VENDOR_PHOTO_DIR .$DEFAULT_AVATAR_PROFILE_PHOTO;
        $password = hashPassword($password);
    

        if (isset($_FILES["ProfilePhoto"])){
            $targetDir = ".".$TARGET_VENDOR_PHOTO_DIR .$username."/";

            $error = validateUploadedFile($targetDir,"ProfilePhoto");
            if ($error != ""){
                $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
                $response['body'] = json_encode($error);
                return $response;
            }
    
            $uploadedProfilePhoto = $_FILES["ProfilePhoto"];
            $targetFile =  $targetDir.basename($uploadedProfilePhoto["name"]);
            $imagePath =  "http://".$_SERVER['SERVER_NAME'].$TARGET_VENDOR_PHOTO_DIR .$username."/".basename($uploadedProfilePhoto["name"]);
    
            $error = saveUploadedFile($uploadedProfilePhoto,$targetDir);
            if ($error != ""){
                $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
                $response['body'] = json_encode($error);
                return $response;
            }
        }

        $result = $this->VendorModel->create($username, $password, $name, $imagePath, $address);
        $response['status_code_header'] = $CREATED_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function getVendors()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->VendorModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteVendor(){
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE;
        $input = json_decode(file_get_contents('php://input'), TRUE);

        $error = $this-> validateVendorID($input);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $result = $this->VendorModel->delete($input["VendorID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function validateCreateVendorInputs(){
        global $EXISTING_USERNAME_ERROR_CODE, $MISSING_REQUIRED_INPUTS_ERROR_CODE,$INVALID_ADDRESS_ERROR_CODE,$INVALID_NAME_ERROR_CODE,$EXISTING_BUSINESS_NAME_ERROR_CODE,$EXISTING_BUSINESS_ADDRESS_ERROR_CODE;

        if (!isset($_POST["Username"]) || !isset($_POST["BusinessName"]) || !isset($_POST["BusinessAddress"]) || !isset($_POST["Password"])){
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        $username = $_POST["Username"];
        $name = $_POST["BusinessName"];
        $password = $_POST["Password"];
        $address = $_POST["BusinessAddress"];

        $error = validateUsername($username);
        if ($error != ""){
            return $error;
        }
        $result = $this->VendorModel->findByUsername($username);
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
        $result = $this->VendorModel->findByBusinessname($name);
        if (isset( $result["BusinessName"])){
            return errorResponse($EXISTING_BUSINESS_NAME_ERROR_CODE);
        }

        $error = validateRequiredInput($address,$INVALID_ADDRESS_ERROR_CODE);
        if ($error != ""){
            return $error;
        }
        $result = $this->VendorModel->findByBusinessAddress($address);
        if (isset( $result["BusinessAddress"])){
            return errorResponse($EXISTING_BUSINESS_ADDRESS_ERROR_CODE);
        }

        return "";
    }

    private function validateVendorID($VendorID){
        global $NON_EXISTING_VENDOR_ERROR_CODE;

        if (!isset($VendorID["VendorID"])){
            return errorResponse($NON_EXISTING_VENDOR_ERROR_CODE);
        }

        $result = $this->VendorModel->findByVendorID($VendorID["VendorID"]);
        if (!isset( $result["VendorID"])){
            return errorResponse($NON_EXISTING_VENDOR_ERROR_CODE);
        }

        return "";
    }
}
