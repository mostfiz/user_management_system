<?php
include "../baseUrl.php";
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
$perPage = 5; // Change this as needed
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$getUserUrl = $baseUrl. "paginate-user?page=$page&perPage=$perPage";

// Fetch user data from API
$userData = json_decode(sendRequest($getUserUrl), true);

// Check if user data is retrieved successfully
if ($userData && isset($userData['success']) && $userData['success'] === true) {
    $users = $userData['users'];
} else {
    // Handle error if user data retrieval fails
    $errorMessage = isset($userData['message']) ? $userData['message'] : 'Failed to fetch user data';
    header("Location: user_list.php?error=$errorMessage");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <!-- Add any additional stylesheets or scripts here -->
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
            <div class="user-list">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?php echo $user['id']; ?></td>
                                <td><?php echo $user['username']; ?></td>
                                <td><?php echo $user['email']; ?></td>
                                <td>
                                    <a href="edit_user.php?id=<?php echo $user['id']; ?>">Edit</a> |
                                    <a href="delete_user.php?id=<?php echo $user['id']; ?>">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination links -->
            <div class="pagination">
                <?php if ($page > 1): ?>
                    <a href="user_list.php?page=<?php echo $page - 1; ?>">Previous</a>
                <?php endif; ?>
                <?php if (count($users) >= $perPage): ?>
                    <a href="user_list.php?page=<?php echo $page + 1; ?>">Next</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Add any additional HTML markup or scripts here -->
</body>
</html>
