<?php

class DistributionHub
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "select * from DistributionHub";

        try {
            $result = $this->db->query($query);
            $orderStatusList = array();

            while($row =  $result->fetch(\PDO::FETCH_ASSOC) ) {
                
                $orderStatus = array(
                    "DistributionHubID" => (int) $row["DistributionHubID"] ,
                    "Name" => $row["Name"],
                    "Address" => $row["Address"],
                );
                $orderStatusList[] = $orderStatus;
             }

            return $orderStatusList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } 
    }
}
