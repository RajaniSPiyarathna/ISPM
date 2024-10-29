<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php'; // Include your database connection

// Check if the request method is POST and a file is uploaded
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["policy_file"])) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $file = $_FILES['policy_file'];

    // Save file to server
    $upload_dir = '../../uploads/policies/';
    $file_name = basename($file["name"]);
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        // Save policy information to database
        $query = "INSERT INTO policies (title, description, file_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $title, $description, $target_file);
        $stmt->execute();

        // Fetch all employee IDs to send notifications
        $employee_query = "SELECT id FROM users WHERE role = 'employee'";
        $employee_result = $conn->query($employee_query);
        
        while ($employee = $employee_result->fetch_assoc()) {
            $user_id = $employee['id'];
            $notification_message = "A new policy has been added: $title";
            $type = 'policy_change';

            // Insert notification into the notifications table
            $notification_query = "INSERT INTO notifications (user_id, type, message) VALUES (?, ?, ?)";
            $notif_stmt = $conn->prepare($notification_query);
            $notif_stmt->bind_param("iss", $user_id, $type, $notification_message);
            $notif_stmt->execute();
        }

        // Set success message in the session
        $_SESSION['success'] = "Policy uploaded and notifications sent successfully!";
    } else {
        // Set error message in the session
        $_SESSION['error'] = "Error uploading file.";
    }

    header('Location: policies.php');
    exit;
}

// Delete Policy
if (isset($_GET['deleteID'])) {
    $policy_id = intval($_GET['deleteID']);
    $query = "DELETE FROM policies WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $policy_id);
    if ($stmt->execute()) {
        $_SESSION['success'] = "Policy deleted successfully.";
        header("Location: policies.php");
        exit; 
    } else {
        $_SESSION['error'] = "Failed to delete policy.";
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
        <div class="container">
            <h2>Manage Policies</h2>

            <?php
            if (isset($_SESSION['success'])) {
                echo "<div class='alert alert-success'>{$_SESSION['success']}</div>";
                unset($_SESSION['success']);
            }

            if (isset($_SESSION['error'])) {
                echo "<div class='alert alert-danger'>{$_SESSION['error']}</div>";
                unset($_SESSION['error']);
            }
            ?>

            <div class="row">
                <div class="col-lg-4">
                    <div class="profile-card">
                        <!-- Form to upload policy -->
                        <form method="POST" enctype="multipart/form-data" class="mb-4">
                            <div class="mb-3">
                                <label for="title" class="form-label">Policy Title:</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="policy_file" class="form-label">Upload Policy Document (PDF):</label>
                                <input type="file" name="policy_file" class="form-control" accept="application/pdf" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload Policy</button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-8">
                    <div class="profile-card">
                        <h4>Uploaded Policies</h4>
                        <div class="list-group">
                            <?php
                            // Fetch all policies
                            $query = "SELECT * FROM policies";
                            $result = $conn->query($query);

                            if ($result->num_rows > 0) {
                                echo "<table class='table table-bordered'>";
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th>Title</th>";
                                echo "<th>Description</th>";
                                echo "<th>Actions</th>";
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                            
                                while ($policy = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>{$policy['title']}</td>";
                                    echo "<td>{$policy['description']}</td>";
                                    echo "<td>";
                                    echo "<a href='{$policy['file_path']}' class='btn btn-success' download>Download Policy</a> ";
                                    echo "<a href='policies.php?deleteID={$policy['id']}' class='btn btn-danger'>Delete Policy</a> ";
                                    echo "<a href='view-acknowledgements.php?policy_id={$policy['id']}' class='btn btn-primary'>View Acknowledgements</a>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            
                                echo "</tbody>";
                                echo "</table>";
                            } else {
                                echo "<p>No policies have been uploaded yet.</p>";
                            }
                            
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
