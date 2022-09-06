<?php

class Shipper
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }


    public function findAll(){
        $query = "SELECT * FROM Shipper";

        try {
            $result = $this->db->query($query);
            $shipperList = array();

            while($row =  $result->fetch(\PDO::FETCH_ASSOC) ) {
                
                $shipper = array(
                    "ShipperID" => (int) $row["ShipperID"] ,
                    "Username" => $row["Username"],
                    "ProfilePhoto" => $row["ProfilePhoto"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "DistributionHubID" => (int) $row["DistributionHubID"]
                );
                $shipperList[] = $shipper;
             }

            return $shipperList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByUsername($username){
        $query = "SELECT * FROM Shipper WHERE Username = :Username";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":Username" => $username]);

            $shipper = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $shipper = array(
                    "Username" => $row["Username"],
                    "Password" => $row["Password"],
                    "ShipperID" => (int) $row["ShipperID"],
                    "ProfilePhoto" => $row["ProfilePhoto"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "DistributionHubID" => (int) $row["DistributionHubID"]
                );
             }

            return $shipper;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function findByShipperID($shipperID){
        $query = "SELECT * FROM Shipper WHERE ShipperID = :ShipperID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":ShipperID" => $shipperID]);

            $shipper = array();

            while($row =  $stmt->fetch(\PDO::FETCH_ASSOC) ) {
                
                $shipper = array(
                    "ShipperID" => $row["ShipperID"],
                );
             }

            return $shipper;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function create($username,$password,$distributionHubID, $profilePhoto)
    {
        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        $query = "INSERT INTO Shipper(Username,Password,ProfilePhoto,DistributionHubID,CreatedAt,UpdatedAt) VALUES(:Username,:Password,:ProfilePhoto,:DistributionHubID,:CreatedAt,:UpdatedAt)";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":Username", $username);
            $stmt->bindValue(":Password", $password);
            $stmt->bindValue(":DistributionHubID", $distributionHubID);
            $stmt->bindValue(":UpdatedAt", $currentDateTime);
            $stmt->bindValue(":CreatedAt", $currentDateTime);
            $stmt->bindValue(":ProfilePhoto", $profilePhoto);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }

    public function delete($shipperID){
        $query = "DELETE FROM Shipper WHERE ShipperID = :ShipperID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":ShipperID", $shipperID);
            $stmt->execute();
    
            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }
}
