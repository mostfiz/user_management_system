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

// API endpoint to search for user
$searchUserUrl = $baseUrl. 'search-users';

// Initialize variables
$searchResults = [];
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['search'])) {
        $keyword = $_POST['keyword'];
        $data = json_encode(array('keyword' => $keyword));
        $response = sendRequest($searchUserUrl, 'POST', $data);
        $responseData = json_decode($response, true);
        if ($responseData && isset($responseData['success']) && $responseData['success'] === true) {
            $searchResults = $responseData['users'];
        } else {
            $error = isset($responseData['message']) ? $responseData['message'] : 'Failed to search for users';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search User</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
    <!-- Add any additional stylesheets or scripts here -->
</head>
<body>
    <div class="header">
        <h1>Search Users</h1>
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
            <div class="panel">
                <h2>Search User</h2>
                <form method="POST" action="">
                <div class="form-group">
                    <input type="text" name="keyword" placeholder="Enter username or email" required>
                </div>
                <div class="form-group">
                    <button type="submit" name="search">Search</button>
                </div>
                   
                </form>
            </div>
            <?php if (!empty($searchResults)): ?>
                <div class="panel">
                    <h2>Search Results</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($searchResults as $user): ?>
                                <tr>
                                    <td><?php echo $user['id']; ?></td>
                                    <td><?php echo $user['username']; ?></td>
                                    <td><?php echo $user['email']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php elseif (!empty($error)): ?>
                <div class="panel">
                    <p><?php echo $error; ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Add any additional HTML markup or scripts here -->
</body>
</html>
