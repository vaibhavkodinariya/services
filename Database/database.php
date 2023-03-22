<?php
    class Database
    {
        private $server = "localhost";
        private $dbName = "hastkala";
        private $username = "root";
        private $password = "";
        private $database=null;
        
        private function __construct()
        {
            try
            {
                $connectionString = "mysql:host=$this->server;dbname=$this->dbName";
                $this->database = new \PDO($connectionString, $this->username, $this->password);
            }
            catch(\Exception $e)
            {
                echo("Connection Failed..");
            }
        }
        public static function get_con()
        {
            $con=new Database();
            return $con->database;
        }
    }
?>