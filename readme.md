User Management System
Introduction
This is a User Management System project developed using PHP. It provides functionalities for managing users, such as adding users, listing users, searching users, and more.

Features
User Management: Add, edit, delete, and search users.
Authentication: Secure login system for user authentication.
Role-based Access Control: Assign roles to users for different levels of access.
Pagination: Paginate user lists for better performance.
Environment Configuration: Uses a .env file for managing environment variables.
Installation
Clone the repository to your local machine.
bash
Copy code
git clone <repository_url>
Install dependencies using Composer.
bash
Copy code
composer install
Copy the .env.example file and rename it to .env. Update the database configuration and other environment variables as needed.
Set the BASE_URL in the baseUrl.php file located in the config directory.
php
Copy code
define('BASE_URL', 'http://localhost/user_management_system/');
Configure the database connection in the Database.php file located in the services directory.
php
Copy code
private $host = $_ENV['DB_HOST'];
private $user = $_ENV['DB_USER'];
private $pass = $_ENV['DB_PASSWORD'];
private $dbname = $_ENV['DB_NAME'];
Serve the application using PHP's built-in server or configure it with your preferred web server.
Usage
Login: Access the login page to authenticate users.
User Management: Navigate to the admin panel to manage users (add, edit, delete).
Search Users: Use the search functionality to find users by username or email.
Pagination: Navigate through user lists using pagination.
Contributing
Contributions are welcome! If you find any issues or have suggestions for improvements, feel free to open an issue or submit a pull request.

License
This project is licensed under the MIT License.

