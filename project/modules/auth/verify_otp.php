<?php
session_start();
include('../../config/config.php'); // Include database connection
include('logEvent.php'); // Include logEvent function

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $inputOtp = trim($_POST['otp']);
    if ($inputOtp == $_SESSION['otp']) {
        // OTP verified successfully
        $userId = $_SESSION['user_id'];

        // Set session variables for the user
        $query = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // Log successful login
            logEvent($conn, 'successful_login', $user['id'], 'success', 'User logged in successfully.');

            // Redirect based on role
            if ($user['role'] == 'admin') {
                header("Location: ../admin/admin-dashboard.php");
            } else {
                header("Location: ../employee/employee-dashboard.php");
            }
            exit;
        }
    } else {
        $error = 'Invalid OTP. Please try again.';
        logEvent($conn, 'otp_verification_attempt', null, 'failure', 'Invalid OTP for email: ' . $_SESSION['email']);
        
        // Redirect back to the login page with error message
        $_SESSION['error'] = $error; // Store error message in session
        header("Location: login.php"); // Redirect to login page
        exit; // Make sure to exit after redirecting
    }
}
?>
