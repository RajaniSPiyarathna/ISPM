<?php
session_start();

// Check if the user is logged in and is an Employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php'; 
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
            z-index: 1030; /* Ensure navbar stays on top */
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
            z-index: 1020; /* Ensure sidebar stays below the navbar */
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
        <a href="employee-dashboard.php">Dashboard</a>
        <a href="quizzes.php">Quizzes</a>
        <a href="policies.php">Policies</a>
        <a href="notifications/notifications.php">Notifications</a>
        <a href="edit-profile.php">Edit Profile</a>
        <a class="nav-link" href="../auth/logout.php">Logout</a>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <h1 class="mb-4">Available Policies</h1>

        <?php
        // Fetch all policies
        $query = "SELECT * FROM policies";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            echo '<div class="row">';
            while ($policy = $result->fetch_assoc()) {
                echo '<div class="col-md-6 mb-4">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo "<h4 class='card-title'>{$policy['title']}</h4>";
                echo "<p class='card-text'>{$policy['description']}</p>";
                echo "<a href='{$policy['file_path']}' class='btn btn-success mb-2' download>Download Policy</a><br>";

                // Check if the employee has already acknowledged the policy
                $employee_id = $_SESSION['user_id'];
                $ack_query = "SELECT * FROM policy_acknowledgements WHERE policy_id = ? AND employee_id = ?";
                $stmt = $conn->prepare($ack_query);
                $stmt->bind_param("ii", $policy['id'], $employee_id);
                $stmt->execute();
                $ack_result = $stmt->get_result();

                if ($ack_result->num_rows > 0) {
                    echo "<p class='text-success'>You have already acknowledged this policy.</p>";
                } else {
                    echo "<form method='POST' action='acknowledge-policy.php'>";
                    echo "<input type='hidden' name='policy_id' value='{$policy['id']}'>";
                    echo "<button type='submit' class='btn btn-primary'>Acknowledge Policy</button>";
                    echo "</form>";
                }
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        } else {
            echo '<div class="alert alert-info">No policies available at the moment.</div>';
        }
        ?>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
