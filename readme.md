# User Management System

## Introduction
This is a User Management System project developed using PHP. It provides functionalities for managing users, such as adding users, listing users, searching users, and more.

## Features
- **User Management**: Add, edit, delete, and search users.
- **Authentication**: Secure login system for user authentication.
- **Role-based Access Control**: Assign roles to users for different levels of access.
- **Pagination**: Paginate user lists for better performance.
- **Environment Configuration**: Uses a `.env` file for managing environment variables.

## Installation
1. Clone the repository to your local machine.

    git clone <repository_url>

2. Install dependencies using Composer.
    composer install


3. Copy the `.env.example` file and rename it to `.env`. Update the database configuration and other environment variables as needed.

4. Set the `BASE_URL` in the `baseUrl.php` .
    $baseUrl = 'http://localhost/user_management_system/');

5. Configure the database connection in the Services/Database.php file located in the services directory.
    private $host = "localhost";
    private $user = "root";
    private $pass = ;
    private $dbname = "user_management_system";


