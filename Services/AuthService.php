<?php
    
    class AuthService {
        private $db;

        public function __construct($db) {
            $this->db = $db;
        }

        public function login($username, $password) {
            // Check if the username exists in the database
            $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // If user not found or password doesn't match, return error
            if (!$user || !password_verify($password, $user['password'])) {
                return ['success' => false, 'message' => 'Invalid username or password'];
            }

            // User authenticated, return success and user details
            unset($user['password']); // Remove password for security
            return ['success' => true, 'user' => $user];
        }
    }
?>