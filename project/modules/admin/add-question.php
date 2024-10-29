<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include database connection
include('../../config/config.php'); // Update path as needed

// Get the quiz ID from the URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quiz title (optional, for display purposes)
$stmt = $conn->prepare("SELECT title FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission
    $question_text = $_POST['question_text'];
    $option_1 = $_POST['option_1'];
    $option_2 = $_POST['option_2'];
    $option_3 = $_POST['option_3'];
    $option_4 = $_POST['option_4'];
    $correct_option = $_POST['correct_option'];

    // Insert the question into the database
    $stmt = $conn->prepare("INSERT INTO questions (quiz_id, question_text, option_1, option_2, option_3, option_4, correct_option) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssi", $quiz_id, $question_text, $option_1, $option_2, $option_3, $option_4, $correct_option);
    
    if ($stmt->execute()) {
        // Redirect to manage-questions.php after successful addition
        header("Location: manage-quizzes.php?quiz_id=" . $quiz_id);
        exit();
    } else {
        $error_message = "Error: " . $stmt->error;
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

        <h1>Add Question for: <?php echo $quiz['title']; ?></h1>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="question_text" class="form-label">Question</label>
                <textarea class="form-control" id="question_text" name="question_text" rows="2" required></textarea>
            </div>
            <div class="mb-3">
                <label for="option_1" class="form-label">Option 1</label>
                <input type="text" class="form-control" id="option_1" name="option_1" required>
            </div>
            <div class="mb-3">
                <label for="option_2" class="form-label">Option 2</label>
                <input type="text" class="form-control" id="option_2" name="option_2" required>
            </div>
            <div class="mb-3">
                <label for="option_3" class="form-label">Option 3</label>
                <input type="text" class="form-control" id="option_3" name="option_3" required>
            </div>
            <div class="mb-3">
                <label for="option_4" class="form-label">Option 4</label>
                <input type="text" class="form-control" id="option_4" name="option_4" required>
            </div>
            <div class="mb-3">
                <label for="correct_option" class="form-label">Correct Option</label>
                <select class="form-select" id="correct_option" name="correct_option" required>
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                    <option value="4">Option 4</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Question</button>
            <a href="manage-questions.php?quiz_id=<?php echo $quiz_id; ?>" class="btn btn-secondary">Back to Questions</a>
        </form>
    </div>
</div>


    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
