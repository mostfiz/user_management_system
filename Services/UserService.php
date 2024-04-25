<?php
    require_once 'RoleManagerService.php';
    require_once 'SecurityService.php';
    require_once 'ErrorHandler.php';
    
    class UserService{

        private $roleManagerService;
        private $securityService;
        private $errorHandler;
        private $db;
        // public function __construct($roleManagerService, $securityService, $errorHandler, $db){
        //     $this->roleManagerService = $roleManagerService;
        //     $this->securityService = $securityService;
        //     $this->errorHandler = $errorHandler;
        //     $this->db = $db;
        // }
        public function __construct($db) {
            $this->roleManagerService = new RoleManagerService();
            $this->securityService = new SecurityService();
            $this->errorHandler = new ErrorHandler();
            $this->db = $db;
        }
    
        public function addUser($username, $email, $password) {
            // Validate input
            if (!$this->errorHandler->validateInput([$username, $email, $password])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
        
            // Hash the password
            $hashedPassword = $this->securityService->hashPassword($password);
        
            // Add new user to the database
            $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            if ($stmt->execute([$username, $email, $hashedPassword])) {
                return ['success' => true, 'message' => 'User added successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to add user'];
            }
        }

        public function editUser($userId, $newUsername, $newEmail, $newPassword) {
            // Validate input
            if (!$this->errorHandler->validateInput([$newUsername, $newEmail, $newPassword])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
        
            // Hash the new password
            $hashedPassword = $this->securityService->hashPassword($newPassword);
        
            // Update user information in the database
            $stmt = $this->db->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
            if ($stmt->execute([$newUsername, $newEmail, $hashedPassword, $userId])) {
                return ['success' => true, 'message' => 'User updated successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to update user'];
            }
        }
        

        public function deleteUser($userId) {
            // Delete user from the database
            $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
            if ($stmt->execute([$userId])) {
                // Remove all roles assigned to the user
                $this->roleManagerService->removeAllRoles($userId);
                return ['success' => true, 'message' => 'User deleted successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to delete user'];
            }
        }

        public function assignRole($userId, $role) {
            $this->roleManagerService->assignRole($userId, $role);

            return ['success' => true, 'message' => 'Role assigned successfully'];
        }

        public function removeRole($userId, $role) {
            $this->roleManagerService->removeRole($userId, $role);

            return ['success' => true, 'message' => 'Role removed successfully'];
        }
    }
?>