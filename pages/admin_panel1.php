<?php

session_start();
print $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Function to send API requests via cURL
function sendRequest($url, $method = 'GET', $data = null) {
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => $data,
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// API endpoints
$addUserUrl = 'ums.local/api.php/users';
$editUserUrl = 'ums.local/api.php/edit-user';
$deleteUserUrl = 'ums.local/api.php/delete-user';
$searchUserUrl = 'ums.local/api.php/search-user';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        // Handle add user action
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $data = json_encode(array('username' => $username, 'email' => $email, 'password' => $password));
        $response = sendRequest($addUserUrl, 'POST', $data);
        // Process $response as needed
    } elseif (isset($_POST['edit_user'])) {
        // Handle edit user action
        // Similar to add user, but with additional parameters for user ID and new data
    } elseif (isset($_POST['delete_user'])) {
        // Handle delete user action
        // Similar to add user, but with user ID instead of username, email, and password
    } elseif (isset($_POST['search_user'])) {
        // Handle search user action
        // Similar to add user, but with keyword instead of username, email, and password
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }
        
        .header {
            background-color: #333;
            color: #fff;
            padding: 10px;
            text-align: center;
        }

        .user-info {
            float: right;
            padding-right: 20px;
            color: #fff;
        }
        
        .container {
            display: flex;
            height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background-color: #333;
            color: #fff;
            padding-top: 20px;
        }
        
        .sidebar h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .sidebar ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }
        
        .sidebar li {
            margin-bottom: 10px;
        }
        
        .sidebar li a {
            display: block;
            padding: 10px 0;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        
        .sidebar li a:hover {
            background-color: #555;
        }
        
        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
        
        .panel {
            background-color: #fff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        
        .panel h2 {
            margin-top: 0;
            margin-bottom: 20px;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
            box-sizing: border-box;
        }
        
        button {
            background-color: #333;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        
        button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>User Management System</h1>
        <div class="user-info">
            <!-- Logged in as: <strong><?php //echo $_SESSION['username']; ?></strong> -->
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <h2>Menu</h2>
            <ul>
                <li><a href="#add-user">Add User</a></li>
                <li><a href="#edit-user">Edit User</a></li>
                <li><a href="#delete-user">Delete User</a></li>
                <li><a href="#search-user">Search User</a></li>
                <li><a href="#user-list">User List</a></li>
            </ul>
        </div>

        <div class="content">
            <div id="add-user" class="panel">
                <h2>Add User</h2>
                <form action="admin_panel.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="add_user">Add User</button>
                </form>
            </div>

            <div id="edit-user" class="panel">
                <h2>Edit User</h2>
                <form action="admin_panel.php" method="post">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" name="add_user">Edit User</button>
                </form>
            </div>

            <div id="user-list" class="user-list-container panel">
                <h2>User List</h2>
                <table class="user-table" id="user-table-body">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- User data will be dynamically inserted here -->
                        <tr>
                            <td>1</td>
                            <td>John Doe</td>
                            <td>john@example.com</td>
                            <td>
                                <button class="edit-btn">Edit</button>
                                <button class="delete-btn">Delete</button>
                            </td>
                        </tr>
                        <!-- More user rows -->
                    </tbody>
                </table>
                <div class="pagination" id="pagination">
                    <!-- Pagination links will be dynamically inserted here -->
                    <a href="#" class="page-link">&laquo; Prev</a>
                    <a href="#" class="page-link">1</a>
                    <a href="#" class="page-link">2</a>
                    <a href="#" class="page-link">3</a>
                    <a href="#" class="page-link">Next &raquo;</a>
                </div>
            </div>


            <!-- Other panels for edit, delete, search user, and user list -->

        </div>
    </div>
    <script>
        // JavaScript to handle menu clicks and show/hide corresponding panels
        const panels = document.querySelectorAll('.panel');

        // Hide all panels except the first one initially
        for (let i = 1; i < panels.length; i++) {
            panels[i].style.display = 'none';
        }

        // Function to show the selected panel and hide others
        function showPanel(panelId) {
            for (let i = 0; i < panels.length; i++) {
                if (panels[i].id === panelId) {
                    panels[i].style.display = 'block';
                } else {
                    panels[i].style.display = 'none';
                }
            }
        }

        // Add event listeners to menu links
        const menuLinks = document.querySelectorAll('.sidebar a');
        menuLinks.forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const panelId = this.getAttribute('href').slice(1);
                showPanel(panelId);
            });
        });
    </script>
</body>
</html>
