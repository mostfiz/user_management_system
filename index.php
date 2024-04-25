<?php

require_once 'Controllers/UserController.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];
$path = $_SERVER['PATH_INFO'];

$userController = new UserController($db);

switch ($requestMethod) {
    case 'POST':
        if ($path === '/users') {
            $userController->addUser();
        }
        // Add more cases for other endpoints
        break;
    // Add cases for other HTTP methods (GET, PUT, DELETE) if needed
}

?>
