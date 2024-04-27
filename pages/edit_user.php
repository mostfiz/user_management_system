<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: ../login.php");
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

// API endpoint to fetch user data
$userId = $_GET['id'];
$getUserUrl = "ums.local/api.php/getUser?id=$userId";

// Fetch user data from API
$userData = json_decode(sendRequest($getUserUrl), true);

// Check if user data is retrieved successfully
if ($userData && isset($userData['success']) && $userData['success'] === true) {
    $user = $userData['user'];
} else {
    // Handle error if user data retrieval fails
    $errorMessage = isset($userData['message']) ? $userData['message'] : 'Failed to fetch user data';
    // Redirect back to user list page or display error message
    header("Location: user_list.php?error=$errorMessage");
    exit();
}

// Handle form submission for updating user data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process form data and update user via API
    // Extract form data and make API call to update user
    // Redirect back to user list page or display success/error message
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <!-- Add any additional stylesheets or scripts here -->
</head>
<body>
<div class="header">
        <h1>Edit User</h1>
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
            <form action="edit_user_submit.php" method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" name="username" placeholder="Username" value="<?php echo $user['username']; ?>" required>
                    <input type="hidden" name="userId" value="<?php echo $user['id']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" placeholder="Email" value="<?php echo $user['email']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Pass:</label>
                    <input type="password" name="password" placeholder="Password" value="<?php echo $user['password']; ?>" required>
                </div>
                <!-- Add other input fields as needed -->
                <button type="submit" name="update_user">Update User</button>
            </form>
            <!-- Edit user form -->
        </div>
    </div>
    <!-- Add any additional HTML markup or scripts here -->
</body>
</html>
