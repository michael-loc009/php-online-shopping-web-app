<?php

class Vendor
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        $query = "SELECT * FROM Vendor";

        try {
            $result = $this->db->query($query);
            $vendorList = array();

            while($row =  $result->fetch(\PDO::FETCH_ASSOC) ) {
                
                $vendor = array(
                    "VendorID" => (int) $row["VendorID"] ,
                    "Username" => $row["Username"],
                    "BusinessName" => $row["BusinessName"],
                    "ProfilePhoto" => $row["ProfilePhoto"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "BusinessAddress" => $row["BusinessAddress"]
                );
                $vendorList[] = $vendor;
             }

            return $vendorList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByUsername($username){
        $query = "SELECT * FROM Vendor WHERE Username = :Username";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":Username" => $username]);

            $vendor = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $vendor = array(
                    "Username" => $row["Username"],
                    "Password" => $row["Password"],
                    "VendorID" => (int) $row["VendorID"],
                    "BusinessName" => $row["BusinessName"],
                    "ProfilePhoto" => $row["ProfilePhoto"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "BusinessAddress" => $row["BusinessAddress"]
                );
             }

            return $vendor;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByBusinessAddress($businessAddress){
        $query = "SELECT * FROM Vendor WHERE BusinessAddress = :BusinessAddress";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":BusinessAddress" => $businessAddress]);

            $vendor = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $vendor = array(
                    "BusinessAddress" => $row["BusinessAddress"],
                );
             }

            return $vendor;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByBusinessname($businessName){
        $query = "SELECT * FROM Vendor WHERE BusinessName = :BusinessName";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":BusinessName" => $businessName]);

            $vendor = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $vendor = array(
                    "BusinessName" => $row["BusinessName"],
                );
             }

            return $vendor;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByVendorID($vendorID){
        $query = "SELECT * FROM Vendor WHERE VendorID = :VendorID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":VendorID" => $vendorID]);

            $vendor = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $vendor = array(
                    "VendorID" => $row["VendorID"],
                );
             }

            return $vendor;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function create($username,$password,$name,$profilePhoto,$address)
    {
        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $query = "INSERT INTO Vendor(Username,Password,ProfilePhoto,BusinessName,BusinessAddress,CreatedAt,UpdatedAt) VALUES(:Username,:Password,:ProfilePhoto,:BusinessName,:BusinessAddress,:CreatedAt,:UpdatedAt)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Username", $username);
            $stmt->bindValue(":Password", $password);
            $stmt->bindValue(":BusinessName", $name);
            $stmt->bindValue(":UpdatedAt", $currentDateTime);
            $stmt->bindValue(":CreatedAt", $currentDateTime);
            $stmt->bindValue(":BusinessAddress", $address);
            $stmt->bindValue(":ProfilePhoto", $profilePhoto);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function delete($vendorID){
        $query = "DELETE FROM Vendor WHERE VendorID = :VendorID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":VendorID", $vendorID);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }
}
