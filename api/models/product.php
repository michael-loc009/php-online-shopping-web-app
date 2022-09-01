<?php

class Product
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
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
