<?php
require './Model/UserOperator.php';

class UserController
{
    private $db = null;
    private $requestMethod = null;
    private $UserOperator;
    private $url = null;

    public function __construct($db, $requestMethod, array $url)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->UserOperator = new UserOperator($db);
        $this->url = $url;
    }
    public function process_request()
    {
        switch ($this->requestMethod) {
            case 'POST':
                if (isset($this->url[3])) {
                    if ($this->url[3] == 'login') {
                        $this->login_user();
                        break;
                    }
                } else {
                    $this->register_user();
                    break;
                }
                break;
            case 'GET':
                $this->getUser();
                break;
        }
    }
    public function login_user()
    {
        $input = (array)json_decode(file_get_contents('php://input'), true);
        if (isset($input['Password']) && isset($input['Email'])) {
            try {
                $data = $this->UserOperator->login_with_email($input['Email'], $input['Password']);
                $response = json_encode($data);
                print_r($response);
            } catch (Exception $e) {
                $response = $e->getMessage();
            }
        } else {
            $body['Error'] = "FORM DATA IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function register_user()
    {
        $input = (array)json_decode(file_get_contents("php://input"), true);
        if (isset($input['email']) && isset($input['password'])  && isset($input['confirmpassword'])) {
            $data = $this->UserOperator->add_user($input['email'], $input['password'], $input['confirmpassword']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "Text is Empty";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function getUser()
    {
        $input = (array)json_decode(file_get_contents('php://input'));
        if (isset($input['id'])) {
            $data = $this->UserOperator->getUserdata($input['id']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "USER ID IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
}