<?php 
    require_once 'RoleManagerService.php';
    require_once 'SecurityService.php';
    require_once 'ErrorHandler.php';
    class UserListingService {
        private $paginationService;
        private $roleManagerService;
    
        public function __construct($roleManagerService, $paginationService) {
            $this->paginationService = $paginationService;
            $this->roleManagerService = $roleManagerService;
        }
    
        public function displayUsers(int $page, int $perPage): array {
            // Display list of users in tabular format
            $users = $this->paginationService->paginateUsers($page, $perPage);
            return $users;
        }
    
        public function searchUsers(string $keyword): array {
            // Prepare the SQL query to search for users by username or email
            $query = "SELECT * FROM users WHERE username LIKE ? OR email LIKE ?";
            $stmt = $this->db->prepare($query);
            
            // Bind the search keyword to the query
            $keyword = "%$keyword%"; // Add wildcard characters to search for partial matches
            $stmt->bindParam(1, $keyword, PDO::PARAM_STR);
            $stmt->bindParam(2, $keyword, PDO::PARAM_STR);
            
            // Execute the query
            $stmt->execute();
            
            // Fetch the users
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Check if any users were found
            if ($users) {
                return ['success' => true, 'users' => $users];
            } else {
                return ['success' => false, 'message' => 'No users found'];
            }
        }
    }
    
?>