<?php
    class PaginationService{

        private $db;
        public function __construct($db) {
            $this->db = $db;
        }
        public function paginateUsers($page, $perPage) {
            // Calculate the offset for the SQL query
            $offset = ($page - 1) * $perPage;
            // Prepare and execute the SQL query to fetch users for the specified page
            $stmt = $this->db->prepare("SELECT * FROM users LIMIT ?, ?");
            $stmt->bindParam(1, $offset, PDO::PARAM_INT);
            $stmt->bindParam(2, $perPage, PDO::PARAM_INT);
            $stmt->execute();
            // Fetch the users
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

            unset($users['password']); // Remove password for security
            // Check if a user was found
            if ($users) {
                return ['success' => true, 'users' => $users];
            } else {
                return ['success' => false, 'message' => 'Role not found for the user'];
            }
        }
    }
?>