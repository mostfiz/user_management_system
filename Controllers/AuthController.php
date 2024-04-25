<?php
require_once __DIR__ . '/../Services/AuthService.php';
require_once __DIR__ . '/../Services/Database.php';

class AuthController {
    private $authService;

    public function __construct() {
        $db = Database::getInstance();
        $pdo = $db->getConnection();
        $this->authService = new AuthService($pdo);
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"), true);
        $username = $data['username'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        $response = $this->authService->login($username, $password);

        echo json_encode($response);
    }
}
?>
