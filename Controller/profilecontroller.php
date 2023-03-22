<?php
include './Model/ProfileOperator.php';
class ProfileController
{
    private $db = null;
    private $requestMethod = null;
    private $ProfileOperator;
    private $url = null;
    private $userid = null;

    public function __construct($db, $requestMethod, array $url, $userid)
    {
        $this->db = $db;
        $this->requestMethod = $requestMethod;
        $this->ProfileOperator = new profileoperator($db);
        $this->url = $url;
        $this->userid = $userid;
    }
    public function process_request()
    {
        switch ($this->requestMethod) {
            case 'GET':
                $this->get_user_profile($this->userid);
                break;
            case 'POST':
                $this->create_profile();
                break;
            case 'PUT':
                $this->update_profile();
                break;
        }
    }
    public function create_profile()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['id']) || isset($input['Name']) || isset($input['Mobileno']) || isset($input['Address']) || isset($input['State']) || isset($input['Pincode']) || isset($input['Gender'])) {
            $data = $this->ProfileOperator->user_create_profile($input['id'], $input['Name'], $input['Mobileno'], $input['Address'], $input['State'], $input['Pincode'], $input['Gender']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "FORM DATA IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function update_profile()
    {
        $input = json_decode(file_get_contents("php://input"), true);
        if (isset($input['id']) || isset($input['Name']) || isset($input['Mobileno']) || isset($input['Address']) || isset($input['State']) || isset($input['Pincode']) || isset($input['Gender'])) {
            $data = $this->ProfileOperator->user_update_profile($input['id'], $input['Name'], $input['Mobileno'], $input['Address'], $input['State'], $input['Pincode'], $input['Gender']);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "FORM DATA IS MISSING";
            $response = json_encode($body);
            print_r($response);
        }
    }
    public function get_user_profile($userid)
    {
        if (isset($userid)) {
            $data = $this->ProfileOperator->get_profile($userid);
            $response = json_encode($data);
            print_r($response);
        } else {
            $body['Error'] = "FAILED TO USER DATA";
            $response = json_encode($body);
            print_r($response);
        }
    }
}