<?php
ini_set("memory_limit", "-1");
set_time_limit(0);

include_once '../Services/Database.php';
include_once '../Services/UserService.php';
require_once '../Services/RoleManagerService.php';
require_once '../Services/SecurityService.php';
require_once '../Services/ErrorHandler.php';

// Initialize objects
$db = Database::getInstance();
$pdo = $db->getConnection();
$userService = new UserService(new RoleManagerService(), new SecurityService(), new ErrorHandler(), $pdo);

// Get the HTTP method, path, and body of the request
$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

// Create SQL based on HTTP method
switch ($method) {
    case 'GET':
        $userService->addUser('testuser', 'test@example.com', 'password123');
        break;
    case 'PUT':
        // Handle PUT request
        break;
    case 'POST':
        // Handle POST request
        $userService->addUser('testuser', 'test@example.com', 'password123');
        break;
    case 'DELETE':
        // Handle DELETE request
        break;
}

function response($status, $status_message, $data)
{
    header("HTTP/1.1 " . $status);

    $response['status'] = $status;
    $response['status_message'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    echo $json_response;
}
