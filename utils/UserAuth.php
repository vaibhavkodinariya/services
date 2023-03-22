<?php

use Firebase\JWT\JWT;

require_once('./vendor/firebase/php-jwt/src/JWT.php');
require_once('./vendor/firebase/php-jwt/src/Key.php');

class UserAuth
{
    private static $key = "thisisakey";
    private $user;
    private static $result = array(false, '');

    public function __construct($user = null)
    {
        $this->user = $user;
    }
    // Generate Authentication Token
    private function genJWT()
    {
        $payload = array(
            "ID" => $this->user['ID'],
            "Email" => $this->user['Email'],
            "User_type" => $this->user['User_type']
        );

        return JWT::encode($payload, UserAuth::$key, 'HS256');
    }
    // return token
    public function get_token()
    {
        $token = $this->genJWT();
        return $token;
    }
    // Validates a token
    static function getAuthorizationHeader()
    {
        $headers = null;
        if (isset($_SERVER['Authorization'])) {
            $headers = $_SERVER["Authorization"];
        } elseif (function_exists('apache_request_headers')) {
            $requestHeaders = apache_request_headers();
            // Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
            $requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
            if (isset($requestHeaders['Authorization'])) {
                $headers = trim($requestHeaders['Authorization']);
            }
        }
        return $headers;
    }
    public static function getBearerToken()
    {
        $headers = UserAuth::getAuthorizationHeader();
        // HEADER: Get the access token from the header
        if (!empty($headers)) {
            $arry = explode(" ", $headers);
            $token = explode("=", $arry[1]);
            $decode = JWT::decode($token[0], UserAuth::$key, 'HS256');
            //     return $decode;
        }
        return null;
    }

    // public static function validateJWT()
    // {
    //     if (isset(getallheaders()['Cookie'])) {
    //         $cookie = getallheaders()['Cookie'];
    //         $jwt = explode(";", $cookie);
    //         $token = explode("=", $jwt[0]);
    //         print_r($jwt[0]);
    //         try {
    //             $decode = JWT::decode($token[1], UserAuth::$key, array('HS256'));
    //             UserAuth::$result['0'] = true;
    //             UserAuth::$result['1'] = (array) $decode;
    //         } catch (\Exception $ex) {
    //             header("HTTP/1.1 401 Unauthorised");
    //             exit();
    //         }
    //     } else {
    //         header("HTTP/1.1 401 Unauthorised");
    //         exit();
    //     }

    //     return UserAuth::$result;
    // }
}