<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include '../../config/config.php';

// Include PHPMailer classes
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Initialize variables
$error = '';
$success = '';

// Function to send email with plaintext password
function sendPasswordEmail($email, $name, $password) {
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();                                           // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                  // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                // Enable SMTP authentication
        $mail->Username   = 'leco88507@gmail.com';            // SMTP username
        $mail->Password   = 'dfzh mxhi glkf gzij';                     // SMTP password (App Password)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;     // Enable TLS encryption
        $mail->Port       = 587;                                 // TCP port to connect to

        // Recipients
        $mail->setFrom('leco88507@gmail.com', 'LECO Team');
        $mail->addAddress($email, $name);                       // Add a recipient

        // Content
        $mail->isHTML(true);                                    // Set email format to HTML
        $mail->Subject = 'Your Account Password';
        $mail->Body    = 'Hello ' . htmlspecialchars($name) . ',<br>Your account has been created. Your password is: <strong>' . htmlspecialchars($password) . '</strong>. Please change it after logging in.';

        $mail->send();
    } catch (Exception $e) {
        // Handle error
        return "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = "PWD" . rand(123456, 999999); // Generate a random password

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        // Hash the password for storage
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // Check if email already exists
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = 'Email is already registered.';
        } else {
            // Insert the new user into the database as an Employee
            $insert_query = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'employee')";
            $stmt = $conn->prepare($insert_query);
            $stmt->bind_param("sss", $name, $email, $hashed_password);

            if ($stmt->execute()) {
                // Send email with plaintext password
                $email_result = sendPasswordEmail($email, $name, $password);
                if ($email_result) {
                    $error = $email_result; // Handle email sending error
                } else {
                    $success = 'Employee added successfully. The password has been sent to the user\'s email.';
                }
            } else {
                $error = 'Request Failed. Please try again.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
        }
        .navbar-top {
            height: 60px;
            background-color: #343a40;
            color: #e9ecef;
            position: fixed;
            top: 0;
            width: 100%;
        }
        .navbar-top .navbar-brand {
            color: #e9ecef;
            font-weight: bold;
        }
        .navbar-top .nav-link {
            color: #e9ecef;
        }
        .sidebar {
            width: 250px;
            position: fixed;
            top: 60px;
            bottom: 0;
            background-color: #343a40;
            padding-top: 10px;
            color: #FFF;
        }
        .sidebar a {
            font-size: 1rem;
            padding: 15px 20px;
            display: block;
            color: #FFF;
            text-decoration: none;
        }
        .sidebar a:hover {
            background-color: #e9ecef;
            color: #007bff;
        }
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 40px;
            min-height: calc(100vh - 60px);
            background-color: #f8f9fa;
        }
        .employee-card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LECO Admin Dashboard</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <h6>Hello, <?php echo $_SESSION['name']; ?></h6>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <a href="admin-dashboard.php" class="active">Dashboard</a> 
        <a href="manage-quizzes.php">Manage Quizzes</a>
        <a href="policies.php">Policy Management</a>
        <a href="notifications.php">Notifications</a>
        <a href="add-employee.php">Add Employee</a>
        <a href="employees-list.php">Employees</a>
        <a href="view-reports.php">View Reports</a>
        <a href="logs/view-logs.php">Security Logs</a>
        <a class="nav-link" href="../auth/logout.php">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="mb-4">Add Employee</h1>

        <div class="employee-card">
                        <!-- Display error message -->
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                        <?php endif; ?>

                        <!-- Display success message -->
                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form action="add-employee.php" method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-block">Add Employee</button>
                            </div>
                        </form>
                        </div>

    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>