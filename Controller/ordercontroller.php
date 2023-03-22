<?php
require './Model/orderOperator.php';

class OrderController
{
    private $db = null;
    private $requestedMethod = null;
    private $url = null;
    private $OrderOperator = null;
    private $userid = null;
    public function __construct($db, $requestedMethod, $url, $userid)
    {
        $this->db = $db;
        $this->requestedMethod = $requestedMethod;
        $this->url = $url;
        $this->OrderOperator = new OrderOperator($db);
        $this->userid = $userid;
    }
    public function order_process_request()
    {
        switch ($this->requestedMethod) {
            case 'GET':
                $this->get_orderd_products($this->userid);
                break;
            case 'POST':
                $this->single_product_order_request();
                break;
            case 'PUT':
                $this->All_product_request_of_cart();
                break;
            case 'DELETE':
                $this->delete_from_order();
                break;
        }
    }
    public function single_product_order_request()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['purchaseqty']) && isset($input['productid']) && isset($input['totalprice']) && isset($input['sizeid']) && isset($input['userid'])) {
            $data = $this->OrderOperator->order_single_product($input['purchaseqty'], $input['productid'], $input['totalprice'], $input['sizeid'], $input['userid']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $success['ERROR'] = "DATA MISSING";
            $response = json_encode($success);
            print_r($response);
        }
    }
    public function All_product_request_of_cart()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['Userid'])) {
            $data = $this->OrderOperator->orderd_all_product($input['Userid']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $success['ERROR'] = "DATA MISSING";
            $response = json_encode($success);
            print_r($response);
        }
    }
    public function get_orderd_products()
    {
        if (isset($this->userid)) {
            $data = $this->OrderOperator->get_orders($this->userid);
            $response = json_encode($data);
            print_r($response);
        } else {
            $success['ERROR'] = "DATA MISSING";
            $response = json_encode($success);
            print_r($response);
        }
    }
    public function delete_from_order()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['productid']) && isset($input['orderid']) && isset($input['userid']) && isset($input['purchaseqty'])) {
            $data = $this->OrderOperator->delete_order($input['productid'], $input['orderid'], $input['userid'], $input['purchaseqty']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $success['ERROR'] = "DATA MISSING";
            $response = json_encode($success);
            print_r($response);
        }
    }
}