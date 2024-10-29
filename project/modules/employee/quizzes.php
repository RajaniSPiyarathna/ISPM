<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Optional: Check user role if needed
if ($_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php';

// Get the logged-in user ID
$user_id = $_SESSION['user_id'];

// Fetch available quizzes
$stmt = $conn->prepare("SELECT id, title, description, duration FROM quizzes");
$stmt->execute();
$quizzes_result = $stmt->get_result();

// Collect quizzes into an array
$quizzes = [];
while ($quiz = $quizzes_result->fetch_assoc()) {
    $quizzes[] = $quiz;
}

// Check if user has attempted each quiz
$attempted_quizzes = [];
$attempt_stmt = $conn->prepare("SELECT quiz_id FROM quiz_attempts WHERE user_id = ?");
$attempt_stmt->bind_param("i", $user_id);
$attempt_stmt->execute();
$attempt_result = $attempt_stmt->get_result();

while ($row = $attempt_result->fetch_assoc()) {
    $attempted_quizzes[] = $row['quiz_id'];
}

// Fetch the total marks, calculating the highest score for each quiz
$total_marks_stmt = $conn->prepare("
    SELECT COALESCE(SUM(max_total_marks), 0) as total_marks
    FROM (
        SELECT MAX(total_marks) AS max_total_marks
        FROM quiz_attempts
        WHERE user_id = ?
        GROUP BY quiz_id
    ) AS max_scores_per_quiz
");
$total_marks_stmt->bind_param("i", $user_id);
$total_marks_stmt->execute();
$total_marks_result = $total_marks_stmt->get_result();
$total_marks = $total_marks_result->fetch_assoc()['total_marks'];

// Determine level availability based on total marks
$can_access_moderate = $total_marks > 0; // Unlock moderate level if user has any marks
$can_access_expert = $total_marks >= 50; // Unlock expert level if user has 50 or more marks
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        .level-container {
            display: flex; /* Enables flexbox layout */
            justify-content: space-around; /* Distributes boxes evenly */
            flex-wrap: wrap; /* Allows wrapping of boxes to next line */
        }
        .level-box {
            flex: 1; /* Makes the boxes take equal space */
            min-width: 250px; /* Sets a minimum width for smaller screens */
            max-width: 300px; /* Sets a maximum width for larger screens */
            padding: 20px; /* Increased padding for a larger box */
            height: 200px; /* Reduced height for each box */
            margin: 10px; /* Margin for spacing between boxes */
            border-radius: 12px; /* More rounded corners */
            text-align: center;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: flex; /* Enables flexbox in the box */
            justify-content: center; /* Centers text horizontally */
            align-items: center; /* Centers text vertically */
            color: #fff; /* Text color */
            font-weight: bold; /* Bold text */
            cursor: pointer; /* Cursor change on hover */
        }
        .level-box:hover {
            transform: scale(1.05);
        }
        /* Button colors */
        .level-box:nth-child(1) {
            background-color: #4caf50; /* Green */
        }
        .level-box:nth-child(2) {
            background-color: #ff9800; /* Orange */
        }
        .level-box:nth-child(3) {
            background-color: #f44336; /* Red */
            <?php if (!$can_access_expert): ?>
                opacity: 0.6; /* Locked state */
                pointer-events: none; /* Disable pointer events */
            <?php endif; ?>
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
        <div class="profile-card">
            <center><h2>Let's Check Your Knowledge</h2></center><br>

            <!-- Quiz Levels as Boxes -->
            <div class="level-container mb-4">
                <!-- Beginner Level Box -->
                <div class="level-box" onclick="location.href='studymaterials.php';">
                    <h4 class="text-center">Beginner</h4>
                </div>

                <!-- Moderate Level Box (Always Unlocked if any marks are present) -->
                <div class="level-box" onclick="location.href='moderate_quizzes.php';">
                    <h4 class="text-center">Moderate</h4>
                </div>

                <!-- Expert Level Box (Unlocked or Locked) -->
                <div class="level-box" onclick="<?php echo $can_access_expert ? "location.href='expertlevel.php';" : "event.preventDefault();"; ?>">
                    <h4 class="text-center">
                        Expert 
                        <?php if (!$can_access_expert): ?>
                            <i class="fas fa-lock" title="Locked" style="margin-left: 5px;"></i>
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
