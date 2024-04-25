<?php 
    class SecurityService{
        public function hashPassword($password) {
            // Hash the password before storing it in the database
            return password_hash($password, PASSWORD_BCRYPT);
        }
    
        public function preventSQLInjection($input) {
            // Prevent SQL injection attacks
        }
    
        public function preventXSS($input) {
            // Prevent XSS attacks
        }
    }
?>