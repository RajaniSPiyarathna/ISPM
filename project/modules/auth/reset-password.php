<?php
// Start session
session_start();

// Include your database connection file
include('../../config/config.php');

// Set the time zone for PHP
date_default_timezone_set('Asia/Colombo');

// Variable for error or success messages
$error = '';
$success = '';

// Check if token is set in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Hash the token to match the stored hashed token in the database
    $hashed_token = hash("sha256", $token);

    // Verify the token and check if it's expired
    $query = "SELECT * FROM users WHERE reset_token_hash = ? AND reset_token_expires_at > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $hashed_token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Handle form submission for password reset
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = $_POST['password'];

            // Validate password according to policy
            if (validatePassword($new_password)) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the user's password and clear the reset token
                $query = "UPDATE users SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("si", $hashed_password, $user['id']);

                if ($stmt->execute()) {
                    $success = "Your password has been reset successfully. You can now log in.";
                } else {
                    $error = "Failed to reset your password. Please try again.";
                }
            } else {
                $error = "Password must be at least 8 characters long, include uppercase and lowercase letters, numbers, and special characters.";
            }
        }
    } else {
        $error = "Invalid or expired token.";
    }
} else {
    $error = "No token provided.";
}

// Password validation function
function validatePassword($password) {
    return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - LECO</title>
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

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h3 class="text-center mb-4">Reset Password</h3>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php elseif (!empty($success)): ?>
                            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                        <?php endif; ?>

                        <?php if (empty($success)): ?>
                            <form action="reset-password.php?token=<?php echo htmlspecialchars($token); ?>" method="POST">
                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <small class="form-text text-muted">
                                        Password must be at least 8 characters long and include uppercase letters, lowercase letters, numbers, and special characters.
                                    </small>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                                </div>
                            </form>
                        <?php endif; ?>

                        <hr>

                        <p class="text-center">
                            <a href="login.php">Back to Login</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
