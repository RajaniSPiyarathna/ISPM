<?php
session_start();

// Enable full error reporting for debugging purposes (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include your database connection file (replace with actual path)
include('../../config/config.php');

// Include PHPMailer
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include logEvent function
include('logEvent.php');

// Initialize variables for OTP
$otp = '';
$otpSent = false;

// Function to send OTP email
function sendOtpEmail($email, $otp) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';  
        $mail->SMTPAuth   = true;  
        $mail->Username   = 'leco88507@gmail.com';  
        $mail->Password   = 'dfzh mxhi glkf gzij';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port       = 587;

        $mail->setFrom('leco88507@gmail.com', 'LECO Team');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = 'Your OTP code is: <strong>' . $otp . '</strong>';

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email sending failed
    }
}

// Logic to handle login submission
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = isset($_POST['password']) ? trim($_POST['password']) : ''; // Safely access password

    // Check if user is locked out
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Check for lockout status
        if ($user['failed_attempts'] >= 5) {
            $lastAttempt = strtotime($user['last_failed_attempt']);
            if (time() - $lastAttempt < 1800) { // 30 minutes lock
                $error = 'Your account is locked due to multiple failed login attempts. Please try again after 30 minutes.';
            } else {
                // Reset failed attempts after 30 minutes
                $updateQuery = "UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE email = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("s", $email);
                $updateStmt->execute();
            }
        } else {
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Reset failed attempts on successful login
                $updateQuery = "UPDATE users SET failed_attempts = 0, last_failed_attempt = NULL WHERE email = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("s", $email);
                $updateStmt->execute();

                // Generate OTP
                $otp = rand(100000, 999999); // Generate a 6-digit OTP
                $_SESSION['otp'] = $otp; // Store OTP in session
                $_SESSION['user_id'] = $user['id']; // Store user ID
                $_SESSION['email'] = $user['email']; // Store email

                // Send OTP to user's email
                if (sendOtpEmail($user['email'], $otp)) {
                    $otpSent = true; // OTP sent successfully
                    logEvent($conn, 'otp_sent', $user['id'], 'success', 'OTP sent to email: ' . $user['email']);
                } else {
                    $error = 'Failed to send OTP. Please try again.';
                }
            } else {
                // Increment failed attempts and log the time
                $failedAttempts = $user['failed_attempts'] + 1;
                $updateQuery = "UPDATE users SET failed_attempts = ?, last_failed_attempt = NOW() WHERE email = ?";
                $updateStmt = $conn->prepare($updateQuery);
                $updateStmt->bind_param("is", $failedAttempts, $email);
                $updateStmt->execute();

                $error = 'Invalid password.';
                logEvent($conn, 'login_attempt', null, 'failure', 'Invalid password for email: ' . $email);
            }
        }
    } else {
        $error = 'No user found with that email.';
        logEvent($conn, 'login_attempt', null, 'failure', 'No user found for email: ' . $email);
    }
}

// Display error message from session if set
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Clear error after displaying it
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LECO Security Awareness</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('../../assets/images/background.jpg'); /* Path to the image */
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
<body>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Login</h3>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <?php if ($otpSent): ?>
                            <div class="alert alert-info">An OTP has been sent to your email. Please enter it below:</div>
                            <form action="verify_otp.php" method="POST">
                                <div class="mb-3">
                                    <label for="otp" class="form-label">Enter OTP</label>
                                    <input type="text" class="form-control" id="otp" name="otp" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <form action="login.php" method="POST">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                                </div>
                            </form>
                        <?php endif; ?>

                        <hr>

                        <p class="text-center">
                            Forgotten Password? <a href="forget-password.php">Click here</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
