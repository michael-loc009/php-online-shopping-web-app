<?php

class OrderStatus
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll()
    {
        $query = "select * from OrderStatus";

        try {
            $result = $this->db->query($query);
            $orderStatusList = array();

            while($row =  $result->fetch(\PDO::FETCH_ASSOC) ) {
                
                $orderStatus = array(
                    "OrderStatusID" => $row["OrderStatusID"] ,
                    "Label" => $row["Label"],
                );
                $orderStatusList[] = $orderStatus;
             }

            return $orderStatusList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        } finally{
            // $this->db->close();
        }
    }
}
