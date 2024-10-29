<?php
session_start();

// Check if the user is logged in and is an Employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../../config/config.php';

$user_id = $_SESSION['user_id'];

// Fetch unread notifications for the logged-in employee
$notif_query = "SELECT * FROM notifications WHERE user_id = ? AND is_read = 0 ORDER BY created_at DESC";
$notif_stmt = $conn->prepare($notif_query);
$notif_stmt->bind_param("i", $user_id);
$notif_stmt->execute();
$notifications = $notif_stmt->get_result();
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
            z-index: 10;
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
    </style>
</head>
<body>

    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">LECO Dashboard</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <h6>Hello, <?php echo $_SESSION['name']; ?></h6>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <a href="../employee-dashboard.php">Dashboard</a>
        <a href="../quizzes.php">Quizzes</a>
        <a href="../policies.php">Policies</a>
        <a href="notifications.php">Notifications</a>
        <a href="../edit-profile.php">Edit Profile</a>
        <a class="nav-link" href="../../auth/logout.php">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
       
        <h2>Notifications</h2>
        <ul class="list-group">
            <?php while ($notif = $notifications->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center <?php echo $notif['is_read'] ? 'list-group-item-success' : ''; ?>">
                    <div>
                        <?php echo $notif['message']; ?> 
                    </div>
                    <div>
                        <!-- Form to mark notification as read -->
                        <form method="POST" action="mark-as-read.php" class="d-inline">
                            <input type="hidden" name="notification_id" value="<?php echo $notif['id']; ?>">
                            <button type="submit" class="btn btn-sm btn-primary <?php echo $notif['is_read'] ? 'disabled' : ''; ?>" <?php echo $notif['is_read'] ? 'disabled' : ''; ?>>
                                <?php echo $notif['is_read'] ? 'Read' : 'Mark as Read'; ?>
                            </button>
                        </form>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>

    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
