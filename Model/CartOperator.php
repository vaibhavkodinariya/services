<?php
class CartOperator
{
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function insert_data_cart($sizeid, $quantity, $productid, $userid)
    {
        $orderStatus = 1;
        $orderfetch = "SELECT * FROM `orders` WHERE `ProductId`=? AND `UserID` = ? AND `OrderStatusID` = ? AND `SizeID`=?";
        $querytofetch = "SELECT `Price`,`Quantity` FROM `products` WHERE `ID` = ?";
        $querytoinsert = "INSERT INTO `orders` (`DateTime`,`Quantity`,`TotalPrice`,`SizeID`,`ProductId`,`OrderStatusID`,`UserID`) VALUES (?,?, ?, ?, ?, ?, ?)";

        try {
            //check Product is already there or not
            if ($sizeid == 0) {
                $size = NULL;
            } else {
                $size = $sizeid;
            }

            $alreadythere = $this->db->prepare($orderfetch);
            $alreadythere->execute(array($productid, $userid, $orderStatus, $size));
            $order = $alreadythere->fetch(PDO::FETCH_ASSOC);
            print_r($order);
            //fetch product details 
            $getproductdetails = $this->db->prepare($querytofetch);
            $getproductdetails->execute(array($productid));
            $products = $getproductdetails->fetch(PDO::FETCH_ASSOC);
            //fetch current time
            $currentDateTimeObj = new DateTime('now', new DateTimeZone('Asia/Calcutta'));
            $currentDateTime = $currentDateTimeObj->format('Y-m-d H:i:s');
            if ($order == null) {

                if ($quantity > $products['Quantity']) {
                    $success['Message'] = 'Quantity is not enough';
                    return $success;
                }
                $totalprice = $quantity * $products['Price'];
                //Insert into cart
                $statement = $this->db->prepare($querytoinsert);
                if ($statement->execute(array($currentDateTime, $quantity, $totalprice, $size, $productid, $orderStatus, $userid))) {
                    $success['Success'] = true;
                    $success['Messege'] = "Added to Cart";
                    return $success;
                } else {
                    $success['Success'] = false;
                    $success['Messege'] = "Something went Wrong";
                    return $success;
                }
            } else {
                //if product is there add it
                $newQuantity = $order['Quantity'] + $quantity;
                $newTotalPrice = $products['Price'] * $newQuantity;
                $query = "UPDATE `orders` SET `Quantity` = ?,`TotalPrice` = ? WHERE `OrderID` = ?";
                $statement = $this->db->prepare($query);
                if ($statement->execute(array($newQuantity, $newTotalPrice, $order['OrderID']))) {
                    $success['Success'] = true;
                    $success['Messege'] = "Product added to Cart";
                    return $success;
                } else {
                    $success['Success'] = false;
                    return $success;
                }
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function get_cart_products($userId)
    {
        $orderstatus = 1;
        $Finalprice = null;
        $fetchcart = "SELECT OrderID,DateTime,Quantity,ProductId,TotalPrice,SizeID FROM orders WHERE OrderStatusID=? AND UserID=?";
        $fetchsize = "SELECT `FixedSize` FROM `sizes` WHERE ID=?";
        $fetchproduct = "SELECT `ID`,`Name`,`Price`,`ImagesPath`,`Details` FROM `products` WHERE `ID` = ?";
        try {
            $getcart = $this->db->prepare($fetchcart);
            $getcart->execute(array($orderstatus, $userId));
            $cart = $getcart->fetchAll(PDO::FETCH_ASSOC);

            if (count($cart) > 0) {

                for ($i = 0; $i < count($cart); $i++) {
                    if ($cart != null) {
                        $products = $this->db->prepare($fetchproduct);
                        $products->execute(array($cart[$i]['ProductId']));
                        $details = $products->fetch(PDO::FETCH_ASSOC);
                        $imagespath = array_values(array_diff(scandir($details['ImagesPath']), array('.', '..')));
                        $cart[$i]['Name'] = $details['Name'];
                        $cart[$i]['Price'] = $details['Price'];
                        $cart[$i]['Details'] = $details['Details'];
                        $cart[$i]['ImagePath'] = $details['ImagesPath'];
                        $cart[$i]['Image'] = $imagespath[0];
                        $Finalprice += $cart[$i]['TotalPrice'];
                    }
                    $size = $this->db->prepare($fetchsize);
                    $size->execute(array($cart[$i]['SizeID']));
                    $productsize = $size->fetch(PDO::FETCH_ASSOC);
                    $cart[$i]['Sizes'] = is_bool($productsize);
                    if (is_bool($productsize)) {
                        $cart[$i]['Sizes'] = null;
                    } else {
                        $cart[$i]['Sizes'] = $productsize['FixedSize'];
                    }
                }
                $success['Success'] = true;
                $success['FinalPrice'] = $Finalprice;
                $success['Cart'] = $cart;
                return $success;
            } else {
                $success["Success"] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function cart_update($quantity, $productid, $userid, $orderid)
    {
        $query = "SELECT `Price` FROM `products` WHERE `ID` = ?";
        $cartupdate = "UPDATE `orders` SET `Quantity` = ?, `TotalPrice` = ? WHERE `productid` = ? AND `UserID` = ? AND `OrderID` = ?";
        try {
            $productsprice = $this->db->prepare($query);
            $productsprice->execute(array($productid));
            $price = $productsprice->fetch(PDO::FETCH_ASSOC);

            $finalprice = $price['Price'] * $quantity;
            $statement = $this->db->prepare($cartupdate);

            if ($statement->execute(array($quantity, $finalprice, $productid, $userid, $orderid))) {
                $success['Success'] = true;
                $success['Messege'] = "Your Cart is Updated";
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function delete_from_cart($orderid, $userid)
    {
        $query = "DELETE FROM orders WHERE OrderID=$orderid AND UserID=$userid";
        try {
            if ($this->db->exec($query)) {
                $success['Success'] = true;
                $success['Messege'] = "Product Removed from Cart";
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}