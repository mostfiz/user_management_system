<?php

    require_once 'ErrorHandler.php';

    class RoleManagerService{
        private $db;
        private $errorHandler;
        public function __construct($db) {
            $this->errorHandler = new ErrorHandler();
            $this->db = $db;
        }
        public function assignRole($userId, $role) {
            // Assuming there's a database table named 'user_roles' with columns 'user_id' and 'role'
            
            // Validate input
            if (!$this->errorHandler->validateInput([$userId, $role])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
            
            // Insert the role assignment into the 'user_roles' table
            $stmt = $this->db->prepare("INSERT INTO user_roles (user_id, role) VALUES (?, ?)");
            $stmt->execute([$userId, $role]);
            
            // Check if the assignment was successful
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Role assigned successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to assign role'];
            }
        }

        public function removeRole($userId, $role) {
            // Assuming there's a database table named 'user_roles' with columns 'user_id' and 'role'
            
            // Validate input
            if (!$this->errorHandler->validateInput([$userId, $role])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
            
            // Delete the role assignment from the 'user_roles' table
            $stmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = ? AND role = ?");
            $stmt->execute([$userId, $role]);
            
            // Check if the deletion was successful
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Role removed successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to remove role'];
            }
        }
        

        public function getRole($userId) {
            // Assuming there's a database table named 'user_roles' with columns 'user_id' and 'role'
            
            // Validate input
            if (!$this->errorHandler->validateInput([$userId])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
            
            // Retrieve the role from the 'user_roles' table
            $stmt = $this->db->prepare("SELECT role FROM user_roles WHERE user_id = ?");
            $stmt->execute([$userId]);
            $role = $stmt->fetchColumn();
            
            // Check if a role was found for the user
            if ($role) {
                return ['success' => true, 'role' => $role];
            } else {
                return ['success' => false, 'message' => 'Role not found for the user'];
            }
        }
        

        public function removeAllRoles($userId) {
            // Assuming there's a database table named 'user_roles' with columns 'user_id' and 'role'
            
            // Validate input
            if (!$this->errorHandler->validateInput([$userId])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
            
            // Delete all role assignments for the user from the 'user_roles' table
            $stmt = $this->db->prepare("DELETE FROM user_roles WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            // Check if the deletion was successful
            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'All roles removed successfully'];
            } else {
                return ['success' => false, 'message' => 'Failed to remove roles'];
            }
        }
        
    }
?>