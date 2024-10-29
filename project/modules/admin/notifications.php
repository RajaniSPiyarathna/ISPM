<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include '../../config/config.php';

// Delete a notification
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $delete_query = "DELETE FROM notifications WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Notification deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting notification.";
    }
    header('Location: admin-notifications.php');
    exit;
}

// Update notification (mark as read or unread)
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $message = $_POST['message'];
    $is_read = $_POST['is_read'];

    $update_query = "UPDATE notifications SET message = ?, is_read = ? WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sii", $message, $is_read, $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Notification updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating notification.";
    }
    header('Location: admin-notifications.php');
    exit;
}

// Fetch all notifications
$query = "SELECT * FROM notifications";
$result = $conn->query($query);
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
        .profile-card {
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
    <div class="container mt-5 profile-card">
    <div class="row">
        <div class="col-md-12">
            <h3>Manage Notifications</h3>
            
            <!-- Success/Error Messages -->
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Type</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($notification = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $notification['id']; ?></td>
                        <td><?php echo $notification['user_id']; ?></td>
                        <td><?php echo $notification['type']; ?></td>
                        <td><?php echo $notification['message']; ?></td>
                        <td><?php echo $notification['is_read'] ? 'Read' : 'Unread'; ?></td>
                        <td><?php echo $notification['created_at']; ?></td>
                        <td>
                            <!-- Update Button (Trigger Modal) -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#updateModal<?php echo $notification['id']; ?>">Update</button>
                            <!-- Delete Button -->
                            <a href="admin-notifications.php?delete=<?php echo $notification['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this notification?');">Delete</a>
                        </td>
                    </tr>

                    <!-- Update Modal -->
                    <div class="modal fade" id="updateModal<?php echo $notification['id']; ?>" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="admin-notifications.php">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="updateModalLabel">Update Notification</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="id" value="<?php echo $notification['id']; ?>">
                                        <div class="mb-3">
                                            <label for="message" class="form-label">Message</label>
                                            <textarea class="form-control" name="message" required><?php echo $notification['message']; ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="is_read" class="form-label">Status</label>
                                            <select name="is_read" class="form-select" required>
                                                <option value="0" <?php echo $notification['is_read'] == 0 ? 'selected' : ''; ?>>Unread</option>
                                                <option value="1" <?php echo $notification['is_read'] == 1 ? 'selected' : ''; ?>>Read</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="update" class="btn btn-success">Save Changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
