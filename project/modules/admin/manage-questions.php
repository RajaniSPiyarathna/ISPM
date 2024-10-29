<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include the database configuration file
include '../../config/config.php';

// Get the quiz ID from the URL
$quiz_id = isset($_GET['quiz_id']) ? intval($_GET['quiz_id']) : 0;

// Fetch quiz title for display
$stmt = $conn->prepare("SELECT title FROM quizzes WHERE id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$result = $stmt->get_result();
$quiz = $result->fetch_assoc();

// Delete question if delete_id is set
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $delete_stmt = $conn->prepare("DELETE FROM questions WHERE id = ?");
    $delete_stmt->bind_param("i", $delete_id);
    if ($delete_stmt->execute()) {
        header("Location: manage-questions.php?quiz_id=" . $quiz_id);
        exit();
    }
}

// Update question if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['question_id'])) {
    $question_id = intval($_POST['question_id']);
    $question_text = $_POST['question_text'];
    $option_1 = $_POST['option_1'];
    $option_2 = $_POST['option_2'];
    $option_3 = $_POST['option_3'];
    $option_4 = $_POST['option_4'];
    $correct_option = $_POST['correct_option'];

    $update_stmt = $conn->prepare("UPDATE questions SET question_text = ?, option_1 = ?, option_2 = ?, option_3 = ?, option_4 = ?, correct_option = ? WHERE id = ?");
    $update_stmt->bind_param("ssssssi", $question_text, $option_1, $option_2, $option_3, $option_4, $correct_option, $question_id);

    if ($update_stmt->execute()) {
        echo "<script>alert('Question updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating question: " . $update_stmt->error . "');</script>";
    }
}

// Fetch all questions for the quiz
$stmt = $conn->prepare("SELECT * FROM questions WHERE quiz_id = ?");
$stmt->bind_param("i", $quiz_id);
$stmt->execute();
$questions = $stmt->get_result();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Questions - LECO Security Awareness</title>
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
    <h1>Manage Questions for: <?php echo $quiz['title']; ?></h1>
    <a href="add-question.php?quiz_id=<?php echo $quiz_id; ?>" class="btn btn-primary mb-3">Add Question</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question</th>
                <th>Option 1</th>
                <th>Option 2</th>
                <th>Option 3</th>
                <th>Option 4</th>
                <th>Correct Option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $questions->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['question_text']; ?></td>
                    <td><?php echo $row['option_1']; ?></td>
                    <td><?php echo $row['option_2']; ?></td>
                    <td><?php echo $row['option_3']; ?></td>
                    <td><?php echo $row['option_4']; ?></td>
                    <td><?php echo $row['correct_option']; ?></td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id']; ?>">Edit</button>
                        <a href="manage-questions.php?quiz_id=<?php echo $quiz_id; ?>&delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this question?');">Delete</a>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel">Edit Question</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="manage-questions.php?quiz_id=<?php echo $quiz_id; ?>" method="POST">
                                    <input type="hidden" name="question_id" value="<?php echo $row['id']; ?>">
                                    <div class="mb-3">
                                        <label for="questionText" class="form-label">Question</label>
                                        <input type="text" class="form-control" name="question_text" id="questionText" value="<?php echo $row['question_text']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="option1" class="form-label">Option 1</label>
                                        <input type="text" class="form-control" name="option_1" id="option1" value="<?php echo $row['option_1']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="option2" class="form-label">Option 2</label>
                                        <input type="text" class="form-control" name="option_2" id="option2" value="<?php echo $row['option_2']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="option3" class="form-label">Option 3</label>
                                        <input type="text" class="form-control" name="option_3" id="option3" value="<?php echo $row['option_3']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="option4" class="form-label">Option 4</label>
                                        <input type="text" class="form-control" name="option_4" id="option4" value="<?php echo $row['option_4']; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="correctOption" class="form-label">Correct Option</label>
                                        <input type="text" class="form-control" name="correct_option" id="correctOption" value="<?php echo $row['correct_option']; ?>" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update Question</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap 5 JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
