<?php
class ProceedtopayOperator
{
    private $db = null;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function single_product_request($purchaseqty, $productid, $sizeid)
    {
        $qty = (int)$purchaseqty;
        $fetchsize = "SELECT `FixedSize` FROM `sizes` WHERE ID=?";
        $fetchproducts = "SELECT `ID`,`Name`,`Details`,`Price`,`Quantity`,`ImagesPath` FROM `products` WHERE `ID` = ?";
        try {
            $productsdetails = $this->db->prepare($fetchproducts);
            $productsdetails->execute(array($productid));
            $products = $productsdetails->fetchAll(PDO::FETCH_ASSOC);

            if (count($products) > 0) {
                for ($i = 0; $i < count($products); $i++) {

                    $imagespath = array_values(array_diff(scandir($products[$i]['ImagesPath']), array('.', '..')));
                    $products[$i]['Image'] = $imagespath[0];
                    $products[$i]['TotalPrice'] = $products[$i]['Price'] * $qty;
                    $products[$i]['Purchaseqty'] = $qty;
                    if ($sizeid == 0) {
                        $products[$i]['Size'] = false;
                    } else {
                        $size = $this->db->prepare($fetchsize);
                        $size->execute(array($sizeid));
                        $productsize = $size->fetch(PDO::FETCH_ASSOC);
                        $products[$i]['Size'] = $productsize['FixedSize'];
                    }
                }

                $success['Success'] = true;
                $success['Orderdproducts'] = $products;
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function all_products_request($userid)
    {
        $orderstatus = 1;
        $Finalprice = null;
        $fetchsize = "SELECT `FixedSize` FROM `sizes` WHERE ID=?";
        $fetchincartproduct = "SELECT OrderID,DateTime,Quantity,ProductId,TotalPrice,SizeID FROM orders WHERE UserID=? AND OrderStatusID=?";
        $fetchproducts = "SELECT `ID`,`Name`,`Details`,`Price`,`Quantity`,`ImagesPath` FROM `products` WHERE `ID` = ?";
        try {
            $checkouttopay = $this->db->prepare($fetchincartproduct);
            $checkouttopay->execute(array($userid, $orderstatus));
            $checkoutdetails = $checkouttopay->fetchAll(PDO::FETCH_ASSOC);

            if (count($checkoutdetails) > 0) {
                for ($i = 0; $i < count($checkoutdetails); $i++) {
                    $productsdetails = $this->db->prepare($fetchproducts);
                    $productsdetails->execute(array($checkoutdetails[$i]['ProductId']));
                    $products = $productsdetails->fetch(PDO::FETCH_ASSOC);

                    $image = array_values(array_diff(scandir($products['ImagesPath']), array('.', '..')));
                    $checkoutdetails[$i]['Name'] = $products['Name'];
                    $checkoutdetails[$i]['Detail'] = $products['Details'];
                    $checkoutdetails[$i]['Price'] = $products['Price'];
                    $checkoutdetails[$i]['Imagepath'] = $products['ImagesPath'];
                    $checkoutdetails[$i]['Image'] = $image[0];

                    $Finalprice += $checkoutdetails[$i]['TotalPrice'];

                    $size = $this->db->prepare($fetchsize);
                    $size->execute(array($checkoutdetails[$i]['SizeID']));
                    $productsize = $size->fetch(PDO::FETCH_ASSOC);
                    $checkoutdetails[$i]['Size'] = $productsize;
                    if (is_bool($productsize)) {
                        $checkoutdetails[$i]['Size'] = false;
                    } else {
                        $checkoutdetails[$i]['Size'] = $productsize['FixedSize'];
                    }
                }
                $success['Success'] = true;
                $success['FinalPrice'] = $Finalprice;
                $success['Orderdproducts'] = $checkoutdetails;
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}