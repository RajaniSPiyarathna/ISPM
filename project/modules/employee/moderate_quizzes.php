<?php
session_start();

// Check if the user is logged in and is an Employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderate Quizzes - LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <h2 class="text-center">Moderate Level</h2>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Quiz Title</th>
                    <th>Description</th>
                    <th>Duration</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($quizzes)) : ?>
                    <?php foreach ($quizzes as $quiz) : ?>
                        <tr>
                            <td><?php echo $quiz['title']; ?></td>
                            <td><?php echo $quiz['description']; ?></td>
                            <td><?php echo $quiz['duration']; ?> minutes</td>
                            <td>
                                <?php if (in_array($quiz['id'], $attempted_quizzes)) : ?>
                                    <a href="take-quiz.php?quiz_id=<?php echo $quiz['id']; ?>" class="btn btn-warning">Reattempt</a>
                                <?php else : ?>
                                    <a href="take-quiz.php?quiz_id=<?php echo $quiz['id']; ?>" class="btn btn-primary">Start Quiz</a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="4">No quizzes available at the moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
