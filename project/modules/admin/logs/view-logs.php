<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include('../../../config/config.php');

// Check if the database connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set default filters
$event_type = $_GET['event_type'] ?? '';
$status = $_GET['status'] ?? '';

// Prepare the dynamic query based on filters
$query = "SELECT event_logs.*, users.email 
          FROM event_logs 
          LEFT JOIN users ON event_logs.user_id = users.id 
          WHERE 1=1";

$params = [];
if (!empty($event_type)) {
    $query .= " AND event_type = ?";
    $params[] = $event_type; // Add parameter for event_type
}
if (!empty($status)) {
    $query .= " AND status = ?";
    $params[] = $status; // Add parameter for status
}
$query .= " ORDER BY created_at DESC";

// Prepare the statement
$stmt = $conn->prepare($query);

// Bind parameters if they exist
if (!empty($params)) {
    $types = str_repeat('s', count($params)); // Assuming all parameters are strings
    $stmt->bind_param($types, ...$params); // Bind the parameters dynamically
}

$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Logs - LECO Security Awareness</title>
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
        .profile-card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .stats-card {
            background-color: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0px 0px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .stats-card h5 {
            margin-bottom: 20px;
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
        <a href="../admin-dashboard.php" class="active">Dashboard</a> 
        <a href="../manage-quizzes.php">Manage Quizzes</a>
        <a href="../policies.php">Policy Management</a>
        <a href="../notifications.php">Notifications</a>
        <a href="../add-employee.php">Add Employee</a>
        <a href="../employees-list.php">Employees</a>
        <a href="../view-reports.php">View Reports</a>
        <a href="view-logs.php">Security Logs</a>
        <a class="nav-link" href="../../auth/logout.php">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="profile-card">
            <h2>Security Logs</h2>

            <!-- Filters Form -->
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="event_type" class="form-select">
                            <option value="">All Event Types</option>
                            <option value="login_attempt" <?= $event_type == 'login_attempt' ? 'selected' : ''; ?>>Login Attempt</option>
                            <option value="successful_login" <?= $event_type == 'successful_login' ? 'selected' : ''; ?>>Successful Login</option>
                            <option value="unauthorized_access" <?= $event_type == 'unauthorized_access' ? 'selected' : ''; ?>>Unauthorized Access</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="success" <?= $status == 'success' ? 'selected' : ''; ?>>Success</option>
                            <option value="failure" <?= $status == 'failure' ? 'selected' : ''; ?>>Failure</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </form>

            <!-- Table to display logs -->
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Timestamp</th>
                        <th>User Email</th>
                        <th>Event Type</th>
                        <th>IP Address</th>
                        <th>Status</th>
                        <th>Details</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($log = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($log['created_at']); ?></td>
                            <td><?= htmlspecialchars($log['email'] ?: 'Guest'); ?></td>
                            <td><?= htmlspecialchars($log['event_type']); ?></td>
                            <td><?= htmlspecialchars($log['ip_address']); ?></td>
                            <td><?= htmlspecialchars($log['status']); ?></td>
                            <td><?= htmlspecialchars($log['message']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No logs found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
