<?php
    class DatabaseOperation{

        
        public function __construct(){

            // instantiate database
			
			$db = $this->getConnection();
			$this->pdo = $db;
        }

        public function getConnection(){

        }
    }
?>