<?php
class OrderOperator
{
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function order_single_product($purchaseqty, $productid, $totalprice, $sizeid, $userid)
    {
        $orderstatus = 2;
        $currentDateTimeObj = new DateTime('now', new DateTimeZone('Asia/Calcutta'));
        $currentDateTime = $currentDateTimeObj->format('Y-m-d H:i:s');

        $productqty = 'Select Quantity from products where ID=?';
        $updateQuantity = 'UPDATE `products` SET `Quantity` = ? WHERE `ID` = ?';
        $buyproduct = 'INSERT INTO `orders` (`DateTime`,`Quantity`,`TotalPrice`,`SizeID`,`ProductId`,`OrderStatusID`,`UserID`) VALUES (?,?, ?, ?, ?, ?, ?)';
        try {
            $productquantity = $this->db->prepare($productqty);
            $productquantity->execute(array($productid));

            $quantity = $productquantity->fetch(PDO::FETCH_ASSOC);
            $remainingqty = $quantity['Quantity'] - $purchaseqty;

            $updateqty = $this->db->prepare($updateQuantity);
            $updateqty->execute(array($remainingqty, $productid));
            $size = null;
            if ($sizeid == 0) {
                $size = NULL;
            } else {
                $size = $sizeid;
            }
            $orderplaced = $this->db->prepare($buyproduct);
            if ($orderplaced->execute(array($currentDateTime, $purchaseqty, $totalprice, $size, $productid, $orderstatus, $userid))) {
                $success['Success'] = true;
                $success['Messege'] = "Order Placed";
                return $success;
            } else {
                $success['Success'] = false;
                $success['Messege'] = "Something went Wrong";
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function orderd_all_product($userid)
    {
        $orderstatus = 2;
        $updatequery = "Update orders set OrderStatusID=? where UserID=?";
        try {
            $updatestatus = $this->db->prepare($updatequery);
            if ($updatestatus->execute(array($orderstatus, $userid))) {
                $success['Success'] = true;
                $success['Messege'] = "Orders Placed";
                return $success;
            } else {
                $success['Success'] = false;
                $success['Messege'] = "Something went Wrong";
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function get_orders($Userid)
    {
        $orderstatus = 2;
        $fetchsize = 'SELECT FixedSize FROM sizes WHERE ID=?';
        $fetchorders = 'Select * from orders where OrderStatusID >= ? and UserID = ?';
        $fetchdetails = 'Select Name,Details,Price,ImagesPath from products where ID=?';
        $OrderStatus = 'Select Name from orderstatus where OrderStatusID=?';
        try {
            $orders = $this->db->prepare($fetchorders);
            $orders->execute(array($orderstatus, $Userid));
            $orderdproducts = $orders->fetchAll(PDO::FETCH_ASSOC);
            if (count($orderdproducts)) {
                for ($i = 0; $i < count($orderdproducts); $i++) {
                    $productdetails = $this->db->prepare($fetchdetails);
                    $productdetails->execute(array($orderdproducts[$i]['ProductId']));
                    $details = $productdetails->fetch(PDO::FETCH_ASSOC);

                    $orderdproducts[$i]['Name'] = $details['Name'];
                    $orderdproducts[$i]['Details'] = $details['Details'];
                    $orderdproducts[$i]['Price'] = $details['Price'];
                    $orderdproducts[$i]['Imagepath'] = $details['ImagesPath'];
                    $image = array_values(array_diff(scandir($details['ImagesPath']), array('.', '..')));
                    $orderdproducts[$i]['Image'] = $image[0];

                    $productstatus = $this->db->prepare($OrderStatus);
                    $productstatus->execute(array($orderdproducts[$i]['OrderStatusID']));
                    $status = $productstatus->fetch(PDO::FETCH_ASSOC);
                    $orderdproducts[$i]['Status'] = $status['Name'];

                    $size = $this->db->prepare($fetchsize);
                    $size->execute(array($orderdproducts[$i]['SizeID']));
                    $productsize = $size->fetch(PDO::FETCH_ASSOC);
                    if (is_bool($productsize)) {
                        $orderdproducts[$i]['Sizes'] = null;
                    } else {
                        $orderdproducts[$i]['Sizes'] = $productsize['FixedSize'];
                    }
                }
                $success['Success'] = true;
                $success['Orders'] = $orderdproducts;
            } else {
                $success['Success'] = false;
            }
            return $success;
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function delete_order($productid, $orderid, $userid, $purchaseqty)
    {
        $productqty = 'Select Quantity from products where ID=?';
        $deletequery = "Delete from orders where ProductId=$productid AND OrderID=$orderid AND UserID=$userid";
        $updateQuantity = 'UPDATE `products` SET `Quantity` = ? WHERE `ID` = ?';
        try {
            $productquantity = $this->db->prepare($productqty);
            $productquantity->execute(array($productid));
            $quantity = $productquantity->fetch(PDO::FETCH_ASSOC);
            $addedqty = $quantity['Quantity'] + $purchaseqty;

            if ($this->db->exec($deletequery)) {
                $success['Success'] = true;
                $success['Messege'] = "Order Cancelled";

                $updateqty = $this->db->prepare($updateQuantity);
                $updateqty->execute(array($addedqty, $productid));
                return $success;
            } else {
                $success['Success'] = false;
                $success['Messege'] = "Something Went Wrong";
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}