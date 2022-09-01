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

        $uploadedProductPhoto = $_FILES["ProductPhoto"];
        $productName = $_POST["Name"];
        $price = floatval($_POST["Price"]);
        $description = $_POST["Description"];
        $targetDir = ".".$TARGET_PRODUCT_PHOTO_DIR.$productName."/";
        $targetFile =  $targetDir.basename($uploadedProductPhoto["name"]);
        $imagePath =  "http://".$_SERVER['SERVER_NAME'].$TARGET_PRODUCT_PHOTO_DIR.$productName."/".basename($uploadedProductPhoto["name"]);

        $error = $this->validateCreateProductInputs($productName, $price);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

        $error = validateUploadedFile($uploadedProductPhoto,$targetFile);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = json_encode($error);
            return $response;
        }

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

    private function validateCreateProductInputs($productName,$price){
        global $INVALID_PRICE, $EXISTING_PRODUCT_NAME_ERROR_CODE;
        $result = $this->productModel->findByName($productName);
        if (isset( $result["Name"])){
            return errorResponse($EXISTING_PRODUCT_NAME_ERROR_CODE);
        }

        if ($price <=0){
            return errorResponse($INVALID_PRICE);
        }

        return "";

    }
}
