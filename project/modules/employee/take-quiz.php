<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php';

// Fetch quiz ID from URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quiz details (title and duration)
$stmt = $conn->prepare("SELECT title, duration FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$quiz = $stmt->get_result()->fetch_assoc();

// Get the current question number from the URL or default to 1
$current_question_number = isset($_GET['q']) ? intval($_GET['q']) : 1;

// Fetch all questions for this quiz
$stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$questions = $result->fetch_all(MYSQLI_ASSOC);

// Count total number of questions
$total_questions = count($questions);

// Check if the current question number is valid
if ($current_question_number > $total_questions || $current_question_number < 1) {
    echo "Invalid question number!";
    exit;
}

// Get the current question
$current_question = $questions[$current_question_number - 1]; // Array is 0-based

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Save the user's answer to the session or database
    $selected_answer = $_POST['answer'];

    // Store in session (or save to DB for persistence)
    $_SESSION['quiz_answers'][$current_question_number] = $selected_answer;

    // Redirect to the next question
    $next_question_number = $current_question_number + 1;

    // Check if it's the last question
    if ($next_question_number <= $total_questions) {
        header("Location: take-quiz.php?quiz_id=$quiz_id&q=$next_question_number");
        exit;
    } else {
        // Redirect to finish page if all questions are answered
        header("Location: finish-quiz.php?quiz_id=$quiz_id");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Quiz - <?php echo $quiz['title']; ?></title>
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
<body onload="startTimer()">

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
        
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <div class="container">
            <div class="row d-flex justify-content-between align-items-center">
                <div class="col">
                    <h1>Quiz: <?php echo $quiz['title']; ?></h1>
                </div>
                <div class="col">
                    <h5 id="timer" class="text-danger"></h5> 
                </div>
            </div>
            

            <div class="card mt-4">
                <div class="card-body">
                    <h5>Question <?php echo $current_question_number; ?> of <?php echo $total_questions; ?></h5>
                    <p><?php echo $current_question['question_text']; ?></p>

                    <form method="post" id="quizForm">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" value="1" required>
                            <label class="form-check-label"><?php echo $current_question['option_1']; ?></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" value="2" required>
                            <label class="form-check-label"><?php echo $current_question['option_2']; ?></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" value="3" required>
                            <label class="form-check-label"><?php echo $current_question['option_3']; ?></label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="answer" value="4" required>
                            <label class="form-check-label"><?php echo $current_question['option_4']; ?></label>
                        </div>

                        <?php if ($current_question_number < $total_questions): ?>
                            <button type="submit" class="btn btn-primary mt-3">Next Question</button>
                        <?php else: ?>
                            <button type="submit" class="btn btn-success mt-3">Finish</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Timer Script -->
    <script>
        let quizId = <?php echo $quiz_id; ?>;
        let quizDuration = <?php echo $quiz['duration']; ?> * 60; // Duration in minutes converted to seconds
        let storedTimeKey = 'timeLeft_' + quizId; // Unique key for each quiz

        // Check if there's already a timer in localStorage, otherwise start with the full time.
        let timeLeft = localStorage.getItem(storedTimeKey) ? parseInt(localStorage.getItem(storedTimeKey)) : quizDuration;

        function startTimer() {
            let timerElement = document.getElementById("timer");
            let timer = setInterval(function() {
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    localStorage.removeItem(storedTimeKey); // Remove time from local storage when completed
                    document.getElementById("quizForm").submit(); // Auto-submit when time runs out
                }
                let minutes = Math.floor(timeLeft / 60);
                let seconds = timeLeft % 60;
                seconds = seconds < 10 ? '0' + seconds : seconds; // Format seconds
                timerElement.innerHTML = minutes + "m " + seconds + "s";
                timeLeft--;

                // Store the updated time in localStorage
                localStorage.setItem(storedTimeKey, timeLeft);

            }, 1000);
        }
    </script>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5
