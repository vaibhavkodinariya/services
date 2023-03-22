<?php
class ProductOperator
{
    private $db = null;
    private $success = false;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function fetch_product_details($id)
    {
        $query = "SELECT * FROM products WHERE ID=? AND IsDelete IS NULL";
        $size = "SELECT s.FixedSize,p.Sizeid FROM productssize p,sizes s WHERE p.Sizeid=s.id AND p.ProductId=?";

        try {

            $fetchDetails = $this->db->prepare($query);
            $fetchDetails->execute(array($id));
            $result = $fetchDetails->fetch(PDO::FETCH_ASSOC);

            $smt = $this->db->prepare($size);
            $smt->execute(array($id));

            $productsize = $smt->fetchAll(PDO::FETCH_ASSOC);

            if ($result != null) {
                $images = array_values(array_diff(scandir($result['ImagesPath']), array('.', '..')));

                $result['images'] = $images;
                $result['sizes'] = array();
                if (count($productsize)) {
                    for ($i = 0; $i < count($productsize); $i++) {
                        $size = array('fixedSize' => $productsize[$i]['FixedSize'], 'sizeId' => $productsize[$i]['Sizeid']);
                        array_push($result['sizes'], $size);
                    }
                } else {
                    $result['sizes'] = false;
                }
                $success['Success'] = true;
                $success['Product'] = $result;

                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fetch_all_products()
    {
        $query = "SELECT * FROM products WHERE IsDelete IS NULL";
        try {
            $fetchAllDetails = $this->db->prepare($query);
            $fetchAllDetails->execute();
            $result = $fetchAllDetails->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $imagespath = array_values(array_diff(scandir($result[$i]['ImagesPath']), array('.', '..')));
                    $result[$i]['Image'] = $imagespath[0];
                }
                $success['products'] = $result;
                $success['Success'] = true;
                return array_merge($success);
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fetch_Male_product()
    {
        $query = "SELECT * FROM products  WHERE ForGender=? AND IsDelete IS NULL";
        try {
            $maleproduct = $this->db->prepare($query);
            $maleproduct->execute(array('Male'));
            $result = $maleproduct->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $imagespath = array_values(array_diff(scandir($result[$i]['ImagesPath']), array('.', '..')));
                    $result[$i]['images'] = $imagespath[0];
                }
                $success['Success'] = true;
                $success['Products'] = $result;
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fetch_female_product()
    {
        $query = "SELECT * FROM products  WHERE ForGender=? AND IsDelete IS NULL";
        try {
            $maleproduct = $this->db->prepare($query);
            $maleproduct->execute(array('Female'));
            $result = $maleproduct->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                for ($i = 0; $i < count($result); $i++) {
                    $imagespath = array_values(array_diff(scandir($result[$i]['ImagesPath']), array('.', '..')));
                    $result[$i]['images'] = $imagespath[0];
                }
                $success['Success'] = true;
                $success['Products'] = $result;
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fetch_categories()
    {
        $query = "SELECT * FROM Categories WHERE ParentCategoryID IS NULL";
        try {
            $getcategories = $this->db->prepare($query);
            $getcategories->execute();
            $cat = $getcategories->fetchAll(PDO::FETCH_ASSOC);
            if (count($cat) > 0) {
                for ($i = 0; $i < count($cat); $i++) {
                    $imagespath = array_values(array_diff(scandir($cat[$i]['ImagesPath']), array('.', '..')));
                    $cat[$i]['images'] = $imagespath[0];
                }
                $success['Success'] = true;
                $success['Category'] = $cat;
                return $success;
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
    public function fetch_subcategory($id)
    {
        $query = "SELECT * FROM categories WHERE ParentCategoryID=?";
        try {
            $subcat = $this->db->prepare($query);
            $subcat->execute(array($id));
            $result = $subcat->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                $success['Success'] = true;
                return array($result, $success);
            } else {
                $success['Success'] = false;
                return $success;
            }
        } catch (Exception $e) {
            $e->getMessage();
        }
    }
}