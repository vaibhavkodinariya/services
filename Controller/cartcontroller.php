<?php
require './Model/CartOperator.php';
class CartController
{
    private $db = null;
    private $url = null;
    private $requestMethod = null;
    private $CartOperator = null;
    private $userid = null;

    public function __construct($db, $url, $requestMethod, $userid)
    {
        $this->db = $db;
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->userid = $userid;
        $this->CartOperator = new CartOperator($db);
    }
    public function request_process()
    {
        switch ($this->requestMethod) {
            case 'POST':
                $this->insert_into_cart();
                break;
            case 'GET':
                $this->get_cart($this->userid);
                break;
            case 'PUT':
                $this->update_cart();
                break;
            case 'DELETE':
                $this->remove_product_cart();
                break;
        }
    }
    public function insert_into_cart()
    {
        $input = (array)json_decode(file_get_contents('php://input'), true);
        if (isset($input['Sizeid']) && isset($input['Quantity']) && isset($input['Productid']) && isset($input['UserId'])) {
            $data = $this->CartOperator->insert_data_cart($input['Sizeid'], $input['Quantity'], $input['Productid'], $input['UserId']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "DATA IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function get_cart($userid)
    {
        if (isset($userid)) {
            $data = $this->CartOperator->get_cart_products($userid);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "DATA IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function update_cart()
    {
        $input = (array)json_decode(file_get_contents('php://input'), true);
        if (isset($input['quantity']) && isset($input['productid']) && isset($input['userid']) && isset($input['orderid'])) {
            $data = $this->CartOperator->cart_update($input['quantity'], $input['productid'], $input['userid'], $input['orderid']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "FORM DATA IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function remove_product_cart()
    {
        $input = (array)json_decode(file_get_contents('php://input'), true);
        if (isset($input['orderid']) && isset($input['userid'])) {
            $data = $this->CartOperator->delete_from_cart($input['orderid'], $input['userid']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "FAILED TO DELETE IN CART";
            $response = json_encode($body);
            print_r($response);
        }
    }
}