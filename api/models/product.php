<?php

class Product
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        $query = "SELECT * FROM PRODUCT";

        try {
            $result = $this->db->query($query);
            $productList = array();

            while($row =  $result->fetch(\PDO::FETCH_ASSOC) ) {
                
                $product = array(
                    "ProductID" => $row["ProductID"] ,
                    "Name" => $row["Name"],
                    "ImagePath" => $row["ImagePath"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "Price" => $row["Price"],
                    "Description" => $row["Description"],
                );
                $productList[] = $product;
             }

            return $productList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByName($productName){
        $query = "SELECT * FROM PRODUCT WHERE Name = :Name";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":Name" => $productName]);

            $product = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $product = array(
                    "Name" => $row["Name"],
                );
             }

            return $product;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function create($name,$imagePath,$price,$description)
    {
        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $query = "INSERT INTO Product(Name,ImagePath,UpdatedAt,CreatedAt,Price,Description) VALUES(:Name,:ImagePath,:UpdatedAt,:CreatedAt,:Price,:Description)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Name", $name);
            $stmt->bindValue(":ImagePath", $imagePath);
            $stmt->bindValue(":UpdatedAt", $currentDateTime);
            $stmt->bindValue(":CreatedAt", $currentDateTime);
            $stmt->bindValue(":Price", $price);
            $stmt->bindValue(":Description", $description);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }
}
