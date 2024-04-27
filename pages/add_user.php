<?php

session_start();
print $_SESSION['username'];
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    
</head>
<body>
    <div class="header">
        <h1>Add User</h1>
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
            <form action="add_user_submit.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <input type="submit" value="Add User">
                </div>
            </form>
        </div>
    </div>
</body>
</html>
