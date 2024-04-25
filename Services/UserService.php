<?php
    // require_once 'RoleManagerService.php';
    // require_once 'SecurityService.php';
    // require_once 'ErrorHandler.php';
    class UserService{

        private $roleManagerService;
        private $securityService;
        private $errorHandler;
        private $db;
        public function __construct($roleManagerService, $securityService, $errorHandler, $db){
            $this->roleManagerService = $roleManagerService;
            $this->securityService = $securityService;
            $this->errorHandler = $errorHandler;
            $this->db = $db;
        }

        public function addUser($username, $email, $password){
            // Validate input
            if(!$this->errorHandler->validateInput([$username, $email, $password])){
                return false;
            }

            // Hash the password
            print $hashedPassword = $this->securityService->hashPassword($password);

            // Add new user to the database
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            return $stmt->execute([$username, $email, $hashedPassword]);
        }

        public function editUser($userId, $newUsername, $newEmail, $newPassword){
            // Validate input
            if (!$this->validateInput([$newUsername, $newEmail, $newPassword])) {
                return false;
            }

            // Hash the new password
            $hashedPassword = $this->hashPassword($newPassword);

            // Update user information in the database
            $stmt = $this->db->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
            $stmt->execute([$newUsername, $newEmail, $hashedPassword, $userId]);

            return true;
        }

        public function deleteUser($userId){
            // Delete user from the database
            $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
            $stmt->execute([$userId]);

            // Remove all roles assigned to the user
            $this->roleManager->removeAllRoles($userId);

            return true;
        }

        public function assignRole($userId, $role) {
            $this->roleManager->assignRole($userId, $role);
        }
    
        public function removeRole($userId, $role) {
            $this->roleManager->removeRole($userId, $role);
        }
 
    }
?>