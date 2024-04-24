<?php
    class UserService{

        public function __construct(){
            $db = Database::getInstance();
            $pdo = $db->getConnection();
        }

        public function addUser($username, $email, $password){

        }

        public function editUser($userId, $newUsername, $newEmail, $newPassword){

        }

        public function deleteUser($userId){

        }
 
    }
?>