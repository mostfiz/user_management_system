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

// API endpoint for adding a user
$addUserUrl = 'ums.local/api.php/users';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate form data
    if (isset($_POST['username'], $_POST['email'], $_POST['password'])) {
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Prepare data for API request
        $data = json_encode(array(
            'username' => $username,
            'email' => $email,
            'password' => $password
        ));

        // Send API request to add user
        $response = sendRequest($addUserUrl, 'POST', $data);

        // Process API response
        if ($response) {
            $responseData = json_decode($response, true);
            if (isset($responseData['success']) && $responseData['success']) {
                // User added successfully
                // Redirect to user list page or show success message
                header("Location: user_list.php");
                exit();
            } else {
                // Error adding user
                // Redirect back to add user page with error message
                header("Location: add_user.php?error=Failed to add user");
                exit();
            }
        } else {
            // Failed to connect to API
            // Redirect back to add user page with error message
            header("Location: add_user.php?error=Failed to connect to API");
            exit();
        }
    } else {
        // Required form fields missing
        // Redirect back to add user page with error message
        header("Location: add_user.php?error=Please fill in all required fields");
        exit();
    }
}
?>
