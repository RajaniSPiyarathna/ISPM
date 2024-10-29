<?php
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php';

// Get quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;
$user_id = $_SESSION['user_id'];

// Fetch quiz questions and answers
$stmt = $conn->prepare("SELECT id, question_text, correct_option FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch the user's answers from session
$user_answers = isset($_SESSION['quiz_answers']) ? $_SESSION['quiz_answers'] : [];

// Calculate total marks, correct and wrong answers
$total_questions = count($questions);
$correct_answers = 0;
$wrong_answers = 0;

foreach ($questions as $index => $question) {
    $question_id = $question['id'];
    $correct_answer = $question['correct_option'];
    
    if (isset($user_answers[$index + 1])) { // Index starts at 0 but questions start from 1
        if ($user_answers[$index + 1] == $correct_answer) {
            $correct_answers++;
        } else {
            $wrong_answers++;
        }
    } else {
        $wrong_answers++; // Treat unanswered questions as wrong
    }
}

// Calculate total marks (2 marks for each correct answer)
$total_marks = $correct_answers * 2; // Change this line

// Store result in `quiz_attempts` and `quiz_results` tables
$conn->begin_transaction();

try {
    // Insert quiz attempt
    $stmt = $conn->prepare("INSERT INTO quiz_attempts (quiz_id, user_id, total_marks, correct_answers, wrong_answers, attempted_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiiii", $quiz_id, $user_id, $total_marks, $correct_answers, $wrong_answers);
    $stmt->execute();
    $attempt_id = $conn->insert_id; // Get the ID of the last inserted quiz attempt

    // Insert individual question results into `quiz_results`
    foreach ($questions as $index => $question) {
        $question_id = $question['id'];
        $user_answer = isset($user_answers[$index + 1]) ? $user_answers[$index + 1] : null;
        $is_correct = ($user_answer == $question['correct_option']) ? 1 : 0;

        $stmt = $conn->prepare("INSERT INTO quiz_results (attempt_id, question_id, user_answer, is_correct) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiii", $attempt_id, $question_id, $user_answer, $is_correct);
        $stmt->execute();
    }

    // Commit transaction
    $conn->commit();
} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    echo "Error: " . $e->getMessage();
    exit;
}

// Clear session data for this quiz
unset($_SESSION['quiz_answers']);

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
        <div class="container mt-5">
            <h1>Quiz Results</h1>
            
            <div class="card">
                <div class="card-body">
                    <h5>Total Questions: <?php echo $total_questions; ?></h5>
                    <h5>Correct Answers: <?php echo $correct_answers; ?></h5>
                    <h5>Wrong Answers: <?php echo $wrong_answers; ?></h5>
                    <h5>Total Marks: <?php echo $total_marks; ?></h5> <!-- This will now reflect the correct total marks -->
                </div>
            </div>

            <a href="quizzes.php" class="btn btn-primary mt-4">Back to Quizzes</a>
        </div>
    </div>
</div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
