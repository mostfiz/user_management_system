<?php 
    class UserListingService{

        private $paginationService;
        private $roleManagerService;

        public function __constract($roleManagerService, $paginationService){
            $this->paginationService= $paginationService;
            $this->roleManagerService = $roleManagerService;
        }
        public function displayUsers($page, $perPage) {
            // Display list of users in tabular format
            $users = $this->paginationService->paginateUsers($page, $perPage);
        }
    
        public function searchUsers($keyword) {
            // Search for users by username or email
        }

        public function displayUserRoles($userId){
            $roles = $this->roleManagerService->getRoles($userId);
        }
    }
?>