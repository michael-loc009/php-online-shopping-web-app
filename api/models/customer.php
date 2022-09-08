<?php

class Customer
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        $query = "SELECT * FROM Customer";

        try {
            $result = $this->db->query($query);
            $customerList = array();

            while($row =  $result->fetch(\PDO::FETCH_ASSOC) ) {
                
                $customer = array(
                    "CustomerID" => (int) $row["CustomerID"] ,
                    "Username" => $row["Username"],
                    "Name" => $row["Name"],
                    "ProfilePhoto" => $row["ProfilePhoto"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "Address" => $row["Address"]
                );
                $customerList[] = $customer;
             }

            return $customerList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByUsername($username){
        $query = "SELECT * FROM Customer WHERE Username = :Username";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":Username" => $username]);

            $customer = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $customer = array(
                    "Username" => $row["Username"],
                    "Password" => $row["Password"],
                    "CustomerID" => (int) $row["CustomerID"],
                    "Name" => $row["Name"],
                    "ProfilePhoto" => $row["ProfilePhoto"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "Address" => $row["Address"]
                );
             }

            return $customer;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByCustomerID($customerID){
        $query = "SELECT * FROM Customer WHERE CustomerID = :CustomerID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":CustomerID" => $customerID]);

            $customer = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $customer = array(
                    "CustomerID" => $row["CustomerID"],
                );
             }

            return $customer;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function create($username,$password,$name,$profilePhoto,$address)
    {
        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $query = "INSERT INTO Customer(Username,Password,ProfilePhoto,Name,Address,CreatedAt,UpdatedAt) VALUES(:Username,:Password,:ProfilePhoto,:Name,:Address,:CreatedAt,:UpdatedAt)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Username", $username);
            $stmt->bindValue(":Password", $password);
            $stmt->bindValue(":Name", $name);
            $stmt->bindValue(":UpdatedAt", $currentDateTime);
            $stmt->bindValue(":CreatedAt", $currentDateTime);
            $stmt->bindValue(":Address", $address);
            $stmt->bindValue(":ProfilePhoto", $profilePhoto);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function delete($customerID){
        $query = "DELETE FROM Customer WHERE CustomerID = :CustomerID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":CustomerID", $customerID);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function update($username, $profilePhotoPath){
        $query = "UPDATE Customer SET ProfilePhoto = :ProfilePhoto WHERE Username = :Username";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Username", $username);
            $stmt->bindValue(":ProfilePhoto", $profilePhotoPath);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }
}
