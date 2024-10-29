<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include '../../config/config.php';

// Fetch data for dashboard overview (number of employees, quizzes, etc.)
$employee_count_query = "SELECT COUNT(*) AS employee_count FROM users WHERE role = 'employee'";
$quiz_count_query = "SELECT COUNT(*) AS quiz_count FROM quizzes";

// Execute queries
$employee_count_result = $conn->query($employee_count_query);
$quiz_count_result = $conn->query($quiz_count_query);

// Fetch results
$employee_count = $employee_count_result->fetch_assoc()['employee_count'];
$quiz_count = $quiz_count_result->fetch_assoc()['quiz_count'];
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
            background-color: #f8f9fa;
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
        }

        /* Larger card sizes */
        .stats-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            height: 250px; /* Increased height */
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }
        .stats-card h5 {
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.5rem;
        }
        .stats-card p {
            font-size: 4rem; /* Larger text for numbers */
            margin-bottom: 15px;
        }
        .stats-icon {
            font-size: 5rem; /* Increased icon size */
            color: #fff;
            position: absolute;
            top: -50px;
            right: 20px;
        }

        /* Card Colors */
        .card-employees {
            background-color: #1e90ff; /* Dodger Blue */
            color: #fff;
        }
        .card-quizzes {
            background-color: #28a745; /* Green */
            color: #fff;
        }
        .card-reports {
            background-color: #ffc107; /* Amber */
            color: #fff;
        }

        /* Make cards fill the entire row */
        .row > .col-md-4 {
            display: flex;
            align-items: stretch;
        }
        .stats-card {
            flex-grow: 1;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .main-content {
                margin-left: 0;
                padding: 20px;
            }
            .sidebar {
                display: none;
            }
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
        <h1 class="mb-4">Admin Dashboard</h1>

        <!-- Dashboard Overview -->
        <div class="row">
            <!-- Total Employees Card -->
            <div class="col-md-4">
                <div class="stats-card card-employees position-relative text-center">
                    <h5>Total Employees</h5>
                    <p class="display-4"><?php echo $employee_count; ?></p>
                    <a href="employees-list.php" class="btn btn-light btn-sm">View Employees</a>
                    <i class="bi bi-people-fill stats-icon"></i>
                </div>
            </div>

            <!-- Total Quizzes Card -->
            <div class="col-md-4">
                <div class="stats-card card-quizzes position-relative text-center">
                    <h5>Total Quizzes</h5>
                    <p class="display-4"><?php echo $quiz_count; ?></p>
                    <a href="manage-quizzes.php" class="btn btn-light btn-sm">Manage Quizzes</a>
                    <i class="bi bi-journal-check stats-icon"></i>
                </div>
            </div>

            <!-- Reports Section -->
            <div class="col-md-4">
                <div class="stats-card card-reports position-relative text-center">
                    <h5>Generate Reports</h5>
                    <p><i class="bi bi-file-earmark-bar-graph display-4"></i></p>
                    <a href="view-reports.php" class="btn btn-light btn-sm">View Reports</a>
                    <i class="bi bi-bar-chart stats-icon"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
