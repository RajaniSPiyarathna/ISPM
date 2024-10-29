<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php';

// Fetch users excluding those with role 'admin' and their highest scores for each quiz
$query = "
    SELECT 
        u.id AS user_id,
        u.name AS user_name,
        u.email AS user_email,
        COALESCE(SUM(max_total_marks), 0) AS total_marks  -- Total marks, based on highest score per quiz
    FROM 
        users u
    LEFT JOIN 
        (
            SELECT 
                user_id, 
                quiz_id, 
                MAX(total_marks) AS max_total_marks  -- Get the maximum marks for each quiz
            FROM 
                quiz_attempts
            GROUP BY 
                user_id, quiz_id
        ) AS qa ON u.id = qa.user_id
    WHERE 
        u.role != 'admin'  -- Exclude admins
    GROUP BY 
        u.id
";

$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->get_result();

// Function to calculate user status based on total marks
function calculate_user_status($total_marks) {
    if ($total_marks >= 50) { // Expert level
        return 'Expert';
    } elseif ($total_marks >= 1 && $total_marks < 50) { // Moderate level
        return 'Moderate';
    } else {
        return 'Beginner';  // Default beginner status
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Reports - Admin Dashboard</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styling for dashboard layout */
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
        .card {
            background-color: white;
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
                    <h6>Hello, <?php echo htmlspecialchars($_SESSION['name']); ?></h6>
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
        <h2>User Reports</h2>

        <div class="card p-4">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = $users->fetch_assoc()) : ?>
                        <?php
                            // Calculate user's status based on total marks
                            $user_status = calculate_user_status($user['total_marks']);
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo ($user_status == 'Expert') ? 'danger' : ($user_status == 'Moderate' ? 'warning' : 'success'); ?>">
                                    <?php echo htmlspecialchars($user_status); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
