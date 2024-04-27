<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
        
</head>
<body>
    <div class="header">
        <h1>Admin Panel</h1>
        <div class="user-info">
            Logged in as: <strong><?php echo $_SESSION['username']; ?></strong> | <a href="logout.php">Logout</a>
        </div>
    </div>
    <div class="container">
        <div class="sidebar">
            <ul>
                <li><a href="add_user.php">Add User</a></li>
                <li><a href="user_list.php">User List</a></li>
                <li><a href="search_user.php">Search User</a></li>
            </ul>
        </div>
        <div class="content">
            <!-- Content will be loaded here dynamically based on the selected menu -->
            <!-- For example, if "Add User" is clicked, load add_user.php content here -->
        </div>
    </div>
</body>
</html>
