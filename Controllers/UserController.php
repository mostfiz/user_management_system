<?php

require_once __DIR__ . '/../Services/UserService.php';
require_once __DIR__ . '/../Services/Database.php';
require_once __DIR__ . '/../Services/UserListingService.php';

class UserController {
    private $userService;
    private $userListingService;

    public function __construct() {

        $db = Database::getInstance();
        $pdo = $db->getConnection();
        $this->userService = new UserService($pdo);
        $this->userListingService = new UserListingService($pdo);
    }

    public function addUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $response = $this->userService->addUser($username, $email, $password);

        echo json_encode($response);
    }

    public function editUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['userId'] ?? '';
        $newUsername = $data['newUsername'] ?? '';
        $newEmail = $data['newEmail'] ?? '';
        $newPassword = $data['newPassword'] ?? '';

        $response = $this->userService->editUser($userId, $newUsername, $newEmail, $newPassword);

        echo json_encode($response);
    }

    public function deleteUser() {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['userId'] ?? '';

        $response = $this->userService->deleteUser($userId);

        echo json_encode($response);
    }

    public function getPaginateUsers(){
        // $data = json_decode(file_get_contents("php://input"), true);
        $page = $_GET['page'] ?? '';
        $perPage = $_GET['perPage'] ?? '';

        $response = $this->userListingService->displayUsers($page, $perPage);

        echo json_encode($response);
    }
    public function getUser(){
        // $data = json_decode(file_get_contents("php://input"), true);
        $id = $_GET['id'] ?? '';
        $response = $this->userListingService->getUser($id);

        echo json_encode($response);
    }
    public function searchUser(){
        $data = json_decode(file_get_contents("php://input"), true);
        $keyword = $data['keyword'] ?? '';
        
        $response = $this->userListingService->searchUsers($keyword);

        echo json_encode($response);
    }

    // public function assignRole() {
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     $userId = $data['userId'] ?? '';
    //     $role = $data['role'] ?? '';

    //     $this->userService->assignRole($userId, $role);

    //     echo json_encode(['success' => true, 'message' => 'Role assigned successfully']);
    // }

    // public function removeRole() {
    //     $data = json_decode(file_get_contents("php://input"), true);
    //     $userId = $data['userId'] ?? '';
    //     $role = $data['role'] ?? '';

    //     $this->userService->removeRole($userId, $role);

    //     echo json_encode(['success' => true, 'message' => 'Role removed successfully']);
    // }
}

?>
