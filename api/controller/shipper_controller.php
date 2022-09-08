<?php

class ShipperController
{
    private $requestMethod;
    private $ShipperModel;
    private $DistributionHubModel;

    public function __construct($accountDb,$shopDb, $requestMethod)
    {
        $this->requestMethod = $requestMethod;

        $this->ShipperModel = new Shipper($accountDb);
        $this->DistributionHubModel = new DistributionHub($shopDb);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->addShipper();
                break;
            case 'GET';
                $response = $this->getShippers();
                break;
            case 'DELETE';
                $response = $this->deleteShipper();
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

    private function addShipper()
    {
        global $BAD_REQUEST_STATUS_CODE, $TARGET_SHIPPER_PHOTO_DIR, $CREATED_STATUS_CODE,$DEFAULT_AVATAR_PROFILE_PHOTO;

        $error = $this->validateCreateShipperInputs();
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $username = $_POST["Username"];
        $distributionHubID = (int) $_POST["DistributionHubID"];
        $password = $_POST["Password"];
        $imagePath = "http://".$_SERVER['SERVER_NAME'].$TARGET_SHIPPER_PHOTO_DIR.$DEFAULT_AVATAR_PROFILE_PHOTO;
        $password = hashPassword($password);
    

        if (isset($_FILES["ProfilePhoto"])){
            $targetDir = ".".$TARGET_SHIPPER_PHOTO_DIR.$username."/";

            $error = validateUploadedFile($targetDir,"ProfilePhoto");
            if ($error != ""){
                $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
                $response['body'] = json_encode($error);
                return $response;
            }
    
            $uploadedProfilePhoto = $_FILES["ProfilePhoto"];
            $targetFile =  $targetDir.basename($uploadedProfilePhoto["name"]);
            $imagePath =  "http://".$_SERVER['SERVER_NAME'].$TARGET_SHIPPER_PHOTO_DIR.$username."/".basename($uploadedProfilePhoto["name"]);
    
            $error = saveUploadedFile($uploadedProfilePhoto,$targetDir);
            if ($error != ""){
                $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
                $response['body'] = json_encode($error);
                return $response;
            }
        }

        $result = $this->ShipperModel->create($username, $password, $distributionHubID, $imagePath);
        $response['status_code_header'] = $CREATED_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function getShippers()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->ShipperModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteShipper(){
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE;
        $input = json_decode(file_get_contents('php://input'), TRUE);

        $error = $this-> validateShipperID($input);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $result = $this->ShipperModel->delete($input["ShipperID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function validateCreateShipperInputs(){
        global $EXISTING_USERNAME_ERROR_CODE, $MISSING_REQUIRED_INPUTS_ERROR_CODE,$INVALID_ADDRESS_ERROR_CODE,$INVALID_NAME_ERROR_CODE,$NON_EXISTING_DISTRIBUTION_HUB_ERROR_CODE;

        if (!isset($_POST["Username"]) || !isset($_POST["DistributionHubID"]) || !isset($_POST["Password"])){
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        $username = $_POST["Username"];
        $distributionHubID = (int) $_POST["DistributionHubID"];
        $password = $_POST["Password"];

        $error = validateUsername($username);
        if ($error != ""){
            return $error;
        }
        $result = $this->ShipperModel->findByUsername($username);
        if (isset( $result["Username"])){
            return errorResponse($EXISTING_USERNAME_ERROR_CODE);
        }

        $error = validatePassword($password);
        if ($error != ""){
            return $error;
        }

        $result = $this->DistributionHubModel->findByDistributionHubID($distributionHubID);
        if (isset( $result["DistributionHubID"]) != true){
            return errorResponse($NON_EXISTING_DISTRIBUTION_HUB_ERROR_CODE);
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
