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
            $this->roleManagerService = new RoleManagerService($db);
            $this->securityService = new SecurityService();
            $this->errorHandler = new ErrorHandler();
            $this->db = $db;
        }
    
        public function addUser($username, $email, $password) {
            try{
                // Validate input
                if (!$this->errorHandler->validateInput([$username, $email, $password])) {
                    return ['success' => false, 'message' => 'Invalid input'];
                }
            
                // Sanitized input
                $username = $this->securityService->preventXSS($username);
                $email = $this->securityService->preventXSS($email);
                $password = $this->securityService->preventXSS($password);
                // Hash the password
                $hashedPassword = $this->securityService->hashPassword($password);
            
                // Add new user to the database
                $stmt = $this->db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
                if ($stmt->execute([$username, $email, $hashedPassword])) {
                    return ['success' => true, 'message' => 'User added successfully'];
                } else {
                    return ['success' => false, 'message' => 'Failed to add user'];
                }
            }catch(Exception $e){
                return ['success' => false, 'message' => 'Failed to add user', 'msg_details'=>$e];
            }

        }

        public function editUser($userId, $newUsername, $newEmail, $newPassword) {
            try{
                // Validate input
                if (!$this->errorHandler->validateInput([$newUsername, $newEmail, $newPassword, $userId])) {
                    return ['success' => false, 'message' => 'Invalid input'];
                }
            
                // Sanitized input
                $newUsername = $this->securityService->preventXSS($newUsername);
                $newEmail = $this->securityService->preventXSS($newEmail);
                $newPassword = $this->securityService->preventXSS($newPassword);
                $userId = $this->securityService->preventXSS($userId);
                // Hash the new password
                $hashedPassword = $this->securityService->hashPassword($newPassword);
            
                // Update user information in the database
                $stmt = $this->db->prepare("UPDATE users SET username=?, email=?, password=? WHERE id=?");
                if ($stmt->execute([$newUsername, $newEmail, $hashedPassword, $userId])) {
                    return ['success' => true, 'message' => 'User updated successfully'];
                } else {
                    return ['success' => false, 'message' => 'Failed to update user'];
                }
            }catch(Exception $e){
                return ['success' => false, 'message' => 'Failed to update user','msg_details'=>$e];
            }
        }
        

        public function deleteUser($userId) {
            try{
                 // Validate input
                 if (!$this->errorHandler->validateInput([$userId])) {
                    return ['success' => false, 'message' => 'Invalid input'];
                }
                // Sanitized input
                $userId = $this->securityService->preventXSS($userId);
                // Delete user from the database
                $stmt = $this->db->prepare("DELETE FROM users WHERE id=?");
                // Remove all roles assigned to the user
                $this->roleManagerService->removeAllRoles($userId);
                if ($stmt->execute([$userId])) {
                    
                    return ['success' => true, 'message' => 'User deleted successfully'];
                } else {
                    return ['success' => false, 'message' => 'Failed to delete user'];
                }
            }catch(Exception $e){
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