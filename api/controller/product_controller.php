<?php

class ProductController
{

    private $db;
    private $requestMethod;
    private $productModel;

    public function __construct($db, $requestMethod)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;

        $this->productModel = new Product($db);
    }

    public function processRequest()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $response = $this->addProduct();
                break;
            case 'GET';
                $response = $this->getProducts();
                break;
            case 'DELETE';
                $response = $this->deleteProduct();
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

    private function addProduct()
    {
        global $BAD_REQUEST_STATUS_CODE, $TARGET_PRODUCT_PHOTO_DIR, $CREATED_STATUS_CODE;

        $productName = $_POST["Name"];
        $price = floatval($_POST["Price"]);
        $description = $_POST["Description"];
        $targetDir = ".".$TARGET_PRODUCT_PHOTO_DIR.$productName."/";
       

        $error = $this->validateCreateProductInputs($productName, $price);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $error = validateUploadedFile($targetDir, "ProductPhoto");
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $uploadedProductPhoto = $_FILES["ProductPhoto"];
        $targetFile =  $targetDir.basename($uploadedProductPhoto["name"]);
        $imagePath =  "http://".$_SERVER['SERVER_NAME'].$TARGET_PRODUCT_PHOTO_DIR.$productName."/".basename($uploadedProductPhoto["name"]);

        $error = saveUploadedFile($uploadedProductPhoto,$targetDir);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }
        
        $result = $this->productModel->create($productName, $imagePath, $price, $description);
        $response['status_code_header'] = $CREATED_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function getProducts()
    {
        global $SUCCESS_STATUS_CODE;

        $result = $this->productModel->findAll();
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode($result);
        return $response;
    }

    private function deleteProduct(){
        global $BAD_REQUEST_STATUS_CODE, $SUCCESS_STATUS_CODE;
        $input = json_decode(file_get_contents('php://input'), TRUE);

        $error = $this-> validateProductID($input);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $result = $this->productModel->delete($input["ProductID"]);
        $response['status_code_header'] = $SUCCESS_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

    private function validateCreateProductInputs($productName,$price){
        global $MISSING_REQUIRED_INPUTS_ERROR_CODE,$INVALID_PRICE_ERROR_CODE, $EXISTING_PRODUCT_NAME_ERROR_CODE,$INVALID_PRODUCT_NAME_ERROR_CODE,$INVALID_DESCRIPTION_ERROR_CODE;

        if (!isset($_POST["Price"]) || !isset($_POST["Name"])){
            return errorResponse($MISSING_REQUIRED_INPUTS_ERROR_CODE);
        }

        if (strlen($productName) <10 ||strlen($productName)>20){
            return errorResponse($INVALID_PRODUCT_NAME_ERROR_CODE);
        }

        if (isset($_POST["Description"]) && strlen($_POST["Description"]) >500){
            return errorResponse($INVALID_DESCRIPTION_ERROR_CODE);
        }
        
        if ($price <=0){
            return errorResponse($INVALID_PRICE_ERROR_CODE);
        }

        $result = $this->productModel->findByName($productName);
        if (isset( $result["Name"])){
            return errorResponse($EXISTING_PRODUCT_NAME_ERROR_CODE);
        }

        return "";
    }

    private function validateProductID($productID){
        global $NON_EXISTING_PRODUCT_ERROR_CODE;

        if (!isset($productID["ProductID"])){
            return errorResponse($NON_EXISTING_PRODUCT_ERROR_CODE);
        }

        $result = $this->productModel->findByProductID($productID["ProductID"]);
        if (!isset( $result["ProductID"])){
            return errorResponse($NON_EXISTING_PRODUCT_ERROR_CODE);
        }

        return "";
    }
}
