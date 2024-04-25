<?php

require_once 'Controllers/UserController.php';
require_once 'Controllers/AuthController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$userController = new UserController();
$authController = new AuthController();

switch ($requestMethod) {
    case 'POST':
        if ($path === '/users') {
            $userController->addUser();
        }elseif($path === '/login'){
            $authController->login();
        }

        // Add more cases for other endpoints
        break;
    case 'PUT':
        if ($path === '/edit-users') {
            $userController->editUser();
        }
        break;
    case 'DELETE':
        if ($path === '/delete-users') {
            $userController->deleteUser();
        }

        // Add more cases for other endpoints
        break;
    case 'GET':
        if ($path === '/get-users') {
            $userController->searchUser();
        }

        // Add more cases for other endpoints
        break;
}

?>
