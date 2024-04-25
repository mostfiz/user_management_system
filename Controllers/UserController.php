<?php

require_once 'UserService.php';

class UserController {
    private $userService;

    public function __construct($db) {
        $this->userService = new UserService($db);
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

    public function assignRole() {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['userId'] ?? '';
        $role = $data['role'] ?? '';

        $this->userService->assignRole($userId, $role);

        echo json_encode(['success' => true, 'message' => 'Role assigned successfully']);
    }

    public function removeRole() {
        $data = json_decode(file_get_contents("php://input"), true);
        $userId = $data['userId'] ?? '';
        $role = $data['role'] ?? '';

        $this->userService->removeRole($userId, $role);

        echo json_encode(['success' => true, 'message' => 'Role removed successfully']);
    }
}

?>
