# User Management System

## Introduction
This is a User Management System project developed using PHP. It provides functionalities for managing users, such as adding users, listing users, searching users, and more.

## Features
- **User Management**: Add, edit, delete, and search users.
- **Authentication**: Secure login system for user authentication.
- **Pagination**: Paginate user lists for better performance.

## Installation
1. Clone the repository to your local machine.

    git clone <repository_url>

2. Install dependencies using Composer.

    composer install

3. Set the `BASE_URL` in the `baseUrl.php` .
    $baseUrl = 'http://localhost/user_management_system/');

4. Configure the database connection in the Services/Database.php file located in the services directory.
    - **private $host** = "localhost";
    - **private $user** = "root";
    - **private $pass** = ;
    - **private $dbname** = "user_management_system";

5. Serve the application using PHP's built-in server or configure it with your preferred web server.

## Usage
- **Login** Access the login page to authenticate users..
- **User Management**: Navigate to the admin panel to manage users (add, edit, delete).
- **Search Users**: Use the search functionality to find users by username or email.
- **Pagination**: Navigate through user lists using pagination.


