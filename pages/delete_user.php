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

// API endpoint to delete user
$deleteUserUrl = 'ums.local/api.php/delete-users';

// Handle user deletion

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Validate form data
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];
        $data = json_encode(array('userId' => $userId));
        $response = sendRequest($deleteUserUrl, 'POST', $data);
        
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
                header("Location: user_list.php?error=Failed to delete user");
                exit();
            }
        } else {
            // Failed to connect to API
            // Redirect back to add user page with error message
            header("Location: user_list.php?error=Failed to connect to API");
            exit();
        }
    } else {
        // Required form fields missing
        // Redirect back to add user page with error message
        header("Location: user_list.php?error=Please fill in all required fields");
        exit();
    }
}
?>