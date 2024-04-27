<?php

    class Database{

        private static $instance = null;
        private $conn;

        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $dbname = "user_management_system";
        
        public function __construct(){

            // instantiate database
			try{
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->user, $this->pass);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e){
                echo "Connection failed: ". $e->getMessage();
            }
        }

        public static function getInstance(){
            if(!self::$instance){
                self::$instance = new Database();
            }
            return self::$instance;
        }

        public function getConnection(){
            return $this->conn;
        }
    }
?>