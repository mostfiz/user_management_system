<?php
// require_once '../vendor/autoload.php';

// // Looing for .env at the root directory
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();
require_once '../Controllers/UserController.php';
require_once '../Controllers/AuthController.php';

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
        elseif($path === '/paginate-user'){
            $userController->getPaginateUsers();
        }elseif ($path === '/search-users') {
            $userController->searchUser();
        }elseif ($path === '/edit-users') {
            $userController->editUser();
        }elseif ($path === '/delete-users') {
            $userController->deleteUser();
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
        if($path === '/paginate-user'){
            $userController->getPaginateUsers();
        }if($path === '/getUser'){
            $userController->getUser();
        }

        // Add more cases for other endpoints
        break;
}

?>
