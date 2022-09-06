<?php

class ProfilePhotoController
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
                $response = $this->updateProfilePhoto();
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

    private function updateProfilePhoto()
    {
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE, $CUSTOMER_TYPE, $VENDOR_TYPE, $SHIPPER_TYPE, $INVALID_LOGIN_ERROR_CODE,$targetFolderPath , $TARGET_SHIPPER_PHOTO_DIR, $TARGET_VENDOR_PHOTO_DIR,$INTERNAL_SYSTEM_ERROR_CODE;

        $error = $this->validateUpdateProfileInputs($_POST);
        if ($error != "") {
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $type = $_POST["Type"];
        $username = $_POST["Username"];

        switch ($type) {
            case $CUSTOMER_TYPE:
                $error = $this->validateCustomerID($_POST);
                $targetFolderPath = $targetFolderPath ;
                break;
            case $VENDOR_TYPE:
                $error = $this->validateVendorID($_POST);
                $targetFolderPath = $TARGET_VENDOR_PHOTO_DIR;
                break;
            case $SHIPPER_TYPE:
                $error = $this->validateShipperID($_POST);
                $targetFolderPath = $TARGET_SHIPPER_PHOTO_DIR;
                break;
        }

        $targetDir = ".".$targetFolderPath .$username."/";

        $error = validateUploadedFile($targetDir,"ProfilePhoto");
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $uploadedProfilePhoto = $_FILES["ProfilePhoto"];
        $targetFile =  $targetDir.basename($uploadedProfilePhoto["name"]);
        $imagePath =  "http://".$_SERVER['SERVER_NAME'].$targetFolderPath .$username."/".basename($uploadedProfilePhoto["name"]);

        $error = saveUploadedFile($uploadedProfilePhoto,$targetDir);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }


        switch ($type) {
            case $CUSTOMER_TYPE:
                $error = $this->CustomerModel->update($username, $imagePath);
                break;
            case $VENDOR_TYPE:
                $error = $this->VendorModel->update($username, $imagePath);
                break;
            case $SHIPPER_TYPE:
                $error = $this->ShipperModel->update($username, $imagePath);
                break;
        }

        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function validateUpdateProfileInputs($input)
    {
        global $MISSING_REQUIRED_INPUTS_ERROR_CODE,$INVALID_ACCOUNT_TYPE_ERROR_CODE,$CUSTOMER_TYPE, $VENDOR_TYPE, $SHIPPER_TYPE;
    
        if (!isset($input["Type"]) || !isset($input["Username"])) {
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        $type = $input["Type"];

        if ($type !=$CUSTOMER_TYPE && $type != $SHIPPER_TYPE && $type != $VENDOR_TYPE){
            return errorResponse($INVALID_ACCOUNT_TYPE_ERROR_CODE);
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

    private function validateShipperID($ShipperID){
        global $NON_EXISTING_SHIPPER_ERROR_CODE;

        if (!isset($ShipperID["ShipperID"])){
            return errorResponse($NON_EXISTING_SHIPPER_ERROR_CODE);
        }

        $result = $this->ShipperModel->findByShipperID($ShipperID["ShipperID"]);
        if (!isset( $result["ShipperID"])){
            return errorResponse($NON_EXISTING_SHIPPER_ERROR_CODE);
        }

        return "";
    }
}
