<?php
require './Model/ProductOperator.php';
class ProductController
{
    private $db = null;
    private $requestMethod = null;
    private $ProductOperator;
    private $url = null;
    private $productid = null;
    public function __construct($db, $requestMethod, array $url, $productid)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->ProductOperator = new ProductOperator($db);
        $this->url = $url;
        $this->productid = $productid;
    }
    public function process_request()
    {
        switch ($this->requestMethod) {
            case 'GET':
                if (isset($this->url[3])) {
                    if ($this->url[3] == 'Male') {
                        $this->for_male();
                        break;
                    } else if ($this->url[3] == 'Female') {
                        $this->for_female();
                        break;
                    } else if ($this->url[3] == 'Category') {
                        $this->get_categories();
                        break;
                    }
                }
                if (isset($this->productid)) {
                    $this->get_product_details($this->productid);
                    break;
                } else {
                    $this->getAllProducts();
                    break;
                }
        }
    }
    public function get_product_details($id)
    {
        $data = $this->ProductOperator->fetch_product_details($id);
        $response = json_encode($data);
        print_r($response);
    }
    public function getAllProducts()
    {
        $data = $this->ProductOperator->fetch_all_products();
        $response = json_encode($data);
        print_r($response);
    }
    public function for_male()
    {
        $data = $this->ProductOperator->fetch_Male_product();
        $response = json_encode($data);
        print_r($response);
    }
    public function for_female()
    {
        $data = $this->ProductOperator->fetch_female_product();
        $response = json_encode($data);
        print_r($response);
    }
    public function get_categories()
    {
        $data = $this->ProductOperator->fetch_categories();
        $response = json_encode($data);
        print_r($response);
    }
    // public function get_subcategory()
    // {
    //     $input = json_decode(file_get_contents('php://input'), true);
    //     $data = $this->ProductOperator->fetch_subcategory($input['id']);
    //     print_r($data);
    //     $response = json_encode($data);
    // }
}