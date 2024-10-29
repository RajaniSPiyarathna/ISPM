<?php
// Start session
session_start();

// Display all errors for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Set the default time zone for PHP
date_default_timezone_set('Asia/Colombo'); // Change to your timezone as needed

// Include your database connection file
include('../../config/config.php');

// Include PHPMailer classes
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Variable to store error or success messages
$message = '';
$name = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User exists, generate a password reset token
        $user = $result->fetch_assoc();
        $reset_token = bin2hex(random_bytes(16)); // Generate a random token
        $reset_token_hash = hash("sha256", $reset_token);
        $reset_token_expiration = date('Y-m-d H:i:s', strtotime('+30 minutes')); // Token expires in 30 minutes

        // Store the reset token and its expiration time in the database
        $updateQuery = "UPDATE users SET reset_token_hash = ?, reset_token_expires_at = ? WHERE email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sss", $reset_token_hash, $reset_token_expiration, $email);
        $stmt->execute();

        // Send reset email
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com";
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Username = "leco88507@gmail.com";
        $mail->Password = "dfzh mxhi glkf gzij";  // Ensure this is correct

        // Recipients
        $mail->setFrom('leco88507@gmail.com', 'LECO Team');
        $mail->addAddress($email, $name);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body = 'We received a request to reset your password. Click <a href="http://localhost/cyber/modules/auth/reset-password.php?token=' . $reset_token . '">here</a> to reset your password.
        This link will expire in 30 minutes. If you did not request this, please ignore this email.';

        try {
            $mail->send();
            $message = "Message sent, please check your inbox.";
        } catch (Exception $e) {
            $message = "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    } else {
        $message = "Email address not found in our records.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../../assets/images/background.jpg'); /* Path to your background image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            background-color: rgba(255, 255, 255, 0.85); /* Semi-transparent background for the card */
            border-radius: 10px;
            padding: 20px;
        }
        .card h3 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Forgot Password</h3>

                        <?php if (!empty($message)): ?>
                            <div class="alert alert-info"><?php echo htmlspecialchars($message); ?></div>
                        <?php endif; ?>

                        <form action="forget-password.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Enter your email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
