<?php

class Order
{

    private $db = null;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function findAll($distributionHubID)
    {
        $query = "SELECT a.*, c.Name, c.Address, d.Label, json_group_array( json_object('ProductID',b.ProductID,'Name',e.Name,'ImagePath', e.ImagePath, 'Price', e.Price,'Quantity', b.Quantity)) as OrderDetails  FROM 'Order' a join 'OrderDetails' b on a.OrderID = b.OrderID join DistributionHub c on c.DistributionHubID = a.DistributionHubID join OrderStatus d on d.OrderStatusID = a.Status join Product e on e.ProductID = b.ProductID where a.Status = 1 and a.DistributionHubID = :DistributionHubID group by b.OrderID;";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":DistributionHubID" => $distributionHubID]);

            $orderList = array();

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {

                $order = array(
                    "OrderID" => (int) $row["OrderID"],
                    "CustomerID" => (int) $row["CustomerID"],
                    "UpdatedAt" => $row["UpdatedAt"],
                    "CreatedAt" => $row["CreatedAt"],
                    "Status" => (int) $row["Status"],
                    "StatusLabel" =>  $row["Label"],
                    "DistributionHubID" => (int) $row["DistributionHubID"],
                    "DistributionHubName" =>  $row["Name"],
                    "DistributionHubAddress" => $row["Address"],
                    "Total" => (float)  $row["Total"],
                    "OrderDetails" => (array)  $row["OrderDetails"],
                );
                $orderList[] = $order;
            }

            return $orderList;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function findByOrderID($orderID)
    {
        $query = "SELECT * FROM 'Order' WHERE OrderID = :OrderID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute([":OrderID" => $orderID]);

            $order = array();

            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {

                $order = array(
                    "OrderID" => $row["OrderID"],
                );
            }

            return $order;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function create($customerID, $distributionHubID, $statusID, $total, $orderItems)
    {
        $currentDateTime = gmdate("Y-m-d\TH:i:s\Z");

        try {

            $query = "INSERT INTO 'Order'('CustomerID', 'Status', 'DistributionHubID', 'Total', 'CreatedAt', 'UpdatedAt') VALUES (:CustomerID,:OrderStatus,:DistributionHubID,:Total,:CreatedAt,:UpdatedAt)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(':CustomerID', $customerID);
            $stmt->bindValue(':OrderStatus', $statusID);
            $stmt->bindValue(':DistributionHubID', $distributionHubID);
            $stmt->bindValue(':Total', $total);
            $stmt->bindValue(':UpdatedAt', $currentDateTime);
            $stmt->bindValue(':CreatedAt', $currentDateTime);
          
            $stmt->execute();

            $orderID = (int) $this->db->lastInsertId();

         
            foreach ($orderItems as $key => $val) {
                $query = "INSERT INTO 'OrderDetails'('OrderID','ProductID','Quantity') VALUES(:OrderID,:ProductID,:Quantity)";
                $stmt = $this->db->prepare($query);
                $stmt->bindValue(':OrderID', $orderID);
                $stmt->bindValue(':ProductID', $val["ProductID"]);
                $stmt->bindValue(':Quantity', $val["Quantity"]);
                $stmt->execute();
            }

            return true;
        } catch (PDOException $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function delete($orderID)
    {
        $query = "DELETE FROM 'Order' WHERE OrderID = :OrderID";
        $query1 = "DELETE FROM OrderDetails WHERE OrderID = :OrderID";

        try {
            $stmt = $this->db->prepare($query1);
            $stmt->bindValue(":OrderID", $orderID);
            $stmt->execute();

            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":OrderID", $orderID);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }

    public function updateOrderStatus($orderID,$orderStatus)
    {
        $query = "Update 'Order' SET Status = :OrderStatus WHERE OrderID = :OrderID";

        try {
            $stmt = $this->db->prepare($query);
            $stmt->bindValue(":OrderStatus", $orderStatus);
            $stmt->bindValue(":OrderID", $orderID);
            $stmt->execute();

            return true;
        } catch (Exception $e) {
            echo 'Database exception: ' . $e->getMessage();
            exit($e->getMessage());
        }
    }
}
