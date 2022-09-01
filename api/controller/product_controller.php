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
        $targetDir = $TARGET_PRODUCT_PHOTO_DIR.$productName."/";
        $targetFile =  $targetDir.basename($uploadedProductPhoto["name"]);
        $imagePath = $productName."/".basename($uploadedProductPhoto["name"]);

        $error = validateUploadedFile($uploadedProductPhoto,$targetFile);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = $error;
            return;
        }

        $error = saveUploadedFile($uploadedProductPhoto,$targetDir);
        if ($error != ""){
            $response['status_code_header'] = $BAD_REQUEST_STATUS_CODE;
            $response['body'] = $error;
            return;
        }

        $result = $this->productModel->create($productName, $imagePath, $price, $description);
        $response['status_code_header'] = $CREATED_STATUS_CODE;
        $response['body'] = json_encode(defaultSuccessResponse());
        return $response;
    }

   
}
