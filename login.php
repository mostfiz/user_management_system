<?php
session_start();

// Function to perform login using cURL
function login($username, $password) {
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'ums.local/api.php/login',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => json_encode(array('username' => $username, 'password' => $password)),
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get username and password from form submission
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Perform login
    $response = login($username, $password);
    
    // Check if login is successful
    $responseData = json_decode($response, true);
    if ($responseData['success']) {
        // Set session variable to indicate user is logged in
        $_SESSION['username'] = $username;
        header("Location: pages/admin_panel.php"); // Redirect to admin panel upon successful login
        exit();
    } else {
        // Display error message if login fails
        $errorMessage = $responseData['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="header">
        <h1>User Management System</h1>
    </header>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
            <?php if (isset($errorMessage)): ?>
                <p class="error"><?php echo $errorMessage; ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

