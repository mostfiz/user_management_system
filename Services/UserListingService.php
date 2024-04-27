<?php 
    require_once 'RoleManagerService.php';
    require_once 'SecurityService.php';
    require_once 'ErrorHandler.php';
    require_once 'PaginationService.php';
    
    class UserListingService {
        private $paginationService;
        private $errorHandler;
        private $securityService;
        private $db;

        public function __construct($db) {
            $this->paginationService = new PaginationService($db);
            $this->errorHandler = new ErrorHandler();
            $this->securityService = new SecurityService();
            $this->db = $db;
        }
    
        public function displayUsers($page, $perPage): array {
            // Validate input
            if (!$this->errorHandler->validateInput([$page, $perPage])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }
            // Sanitized input
            $page = $this->securityService->preventXSS($page);

            $perPage = $this->securityService->preventXSS($perPage);
            // Display list of users in tabular format
            $users = $this->paginationService->paginateUsers($page, $perPage);
            return $users;
        }
    
        public function getUser($userId) {
            // Assuming there's a database table named 'user_roles' with columns 'user_id' and 'role'
            
            // Validate input
            if (!$this->errorHandler->validateInput([$userId])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }

            // Sanitized input
            $userId = $this->securityService->preventXSS($userId);

            // Retrieve the role from the 'user_roles' table
            $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Check if a role was found for the user
            if ($user) {
                return ['success' => true, 'user' => $user];
            } else {
                return ['success' => false, 'message' => 'User not found'];
            }
        }
        public function searchUsers($keyword): array {

            // Validate input
            if (!$this->errorHandler->validateInput([$keyword])) {
                return ['success' => false, 'message' => 'Invalid input'];
            }

            // Sanitized input
            $keyword = $this->securityService->preventXSS($keyword);

            // Prepare SQL query to search for users by username or email
            $sql = "SELECT id, username, email FROM users WHERE username LIKE :keyword OR email LIKE :keyword";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
            $stmt->execute();
    
            // Fetch the matching users
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            unset($users['password']); // Remove password for security
            // Check if any users were found
            if ($users) {
                return ['success' => true, 'users' => $users];
            } else {
                return ['success' => false, 'message' => 'No users found'];
            }
        }
    }
    
?>