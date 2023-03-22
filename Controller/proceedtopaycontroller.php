<?php
require './Model/proceedtopayOperator.php';
class ProceedtopayController
{
    private $db = null;
    private $url = null;
    private $requestMethod = null;
    private $ProceedtopayOperator = null;

    public function __construct($db, $url, $requestMethod)
    {
        $this->db = $db;
        $this->url = $url;
        $this->requestMethod = $requestMethod;
        $this->ProceedtopayOperator = new ProceedtopayOperator($db);
    }
    public function order_request_process()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if (isset($this->url[3])) {
                    if ($this->url[3] == 'Buy') {
                        $this->single_product_request();
                        break;
                    }
                } else {
                    $this->all_product_request();
                    break;
                }
                break;
        }
    }
    public function single_product_request()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['quantity']) && isset($input['productid']) && isset($input['sizeid'])) {
            $data = $this->ProceedtopayOperator->single_product_request($input['quantity'], $input['productid'], $input['sizeid']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['ERROR'] = "DATA MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function all_product_request()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        if (isset($input['userid'])) {
            $data = $this->ProceedtopayOperator->all_products_request($input['userid']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['ERROR'] = "DATA MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
}