<?php
session_start();

// Check if the user is logged in and is an Admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Include the database configuration file
include '../../config/config.php';

// Fetch all quizzes from the database =======================================
$query = "SELECT * FROM quizzes ORDER BY created_at DESC";
$result = $conn->query($query);

// Add or Edit quiz =========================================================
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = trim($_POST['title']);
    $duration = trim($_POST['duration']);
    $description = trim($_POST['description']);
    $quiz_id = isset($_POST['quiz_id']) ? intval($_POST['quiz_id']) : 0;

    // Validate inputs
    if (empty($title)) {
        $error = "Title is required.";
    } else {
        if ($quiz_id > 0) {
            // Update existing quiz
            $stmt = $conn->prepare("UPDATE quizzes SET title = ?, description = ?, duration = ? WHERE id = ?");
            $stmt->bind_param("ssii", $title, $description, $duration, $quiz_id);
            if ($stmt->execute()) {
                header("Location: manage-quizzes.php?message=Quiz updated successfully.");
                exit;
            } else {
                $error = "Failed to update quiz. Please try again.";
            }
        } else {
            // Insert new quiz
            $stmt = $conn->prepare("INSERT INTO quizzes (title, description, duration) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $title, $description, $duration);
            if ($stmt->execute()) {
                // Insert notification into the notifications table
                $employee_query = "SELECT id FROM users WHERE role = 'employee'";
                $employee_result = $conn->query($employee_query);

                while ($employee = $employee_result->fetch_assoc()) {
                    $user_id = $employee['id'];
                    $notification_message = "A new quiz has been added: $title";
                    $type = 'incomplete_assessment';

                    // Insert notification
                    $notification_query = "INSERT INTO notifications (user_id, type, message) VALUES (?, ?, ?)";
                    $notif_stmt = $conn->prepare($notification_query);
                    $notif_stmt->bind_param("iss", $user_id, $type, $notification_message);
                    $notif_stmt->execute();
                }

                header("Location: manage-quizzes.php?message=Quiz created successfully!");
                exit;
            } else {
                $error = "Failed to create quiz. Please try again.";
            }
        }
    }
}

// Delete quiz
if (isset($_GET['delete_id'])) {
    $quiz_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    if ($stmt->execute()) {
        header("Location: manage-quizzes.php?message=Quiz deleted successfully.");
        exit;
    } else {
        header("Location: manage-quizzes.php?error=Failed to delete quiz.");
        exit;
    }
    $stmt->close();
}

// Fetch quiz for editing ===================================================
if (isset($_GET['edit_id'])) {
    $quiz_id = intval($_GET['edit_id']);
    $stmt = $conn->prepare("SELECT * FROM quizzes WHERE id = ?");
    $stmt->bind_param("i", $quiz_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $quiz = $result->fetch_assoc();
    $stmt->close();
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
        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-10">
                <h2 class="mb-4">Manage Quizzes</h2>
            </div>
            <div class="col-lg-2">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addQuizeModal">
                    Add Quiz
                </button>
            </div>
        </div>

        <!-- Display quizzes in a table -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Duration (in min)</th>
                    <th>Description</th>
                    <th>Created At</th>
                    <th>Question</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['duration']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Question
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <li><button class="dropdown-item" type="button">
                                            <a href="add-question.php?quiz_id=<?php echo $row['id']; ?>" class="btn btn-sm">Add Question</a>
                                        </button></li>
                                    <li><button class="dropdown-item" type="button">
                                            <a href="manage-questions.php?quiz_id=<?php echo $row['id']; ?>" class="btn btn-sm">All Questions</a>
                                        </button></li>
                                </ul>
                            </div>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#editModal<?php echo $row['id']; ?>">Edit
                            </button>
                            <a href="manage-quizzes.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this quiz?')">Delete</a>
                        </td>
                    </tr>

                    <!-- Edit Quiz Modal -->
                    <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editQuizModal"
                         aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Quiz</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="manage-quizzes.php" method="post">
                                        <input type="hidden" name="quiz_id" value="<?php echo $row['id']; ?>">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Quiz Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                   value="<?php echo $row['title']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="duration" class="form-label">Duration (in minutes)</label>
                                            <input type="number" class="form-control" id="duration" name="duration"
                                                   value="<?php echo $row['duration']; ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="description" class="form-label">Quiz Description</label>
                                            <textarea class="form-control" id="description" name="description"
                                                      rows="3"><?php echo $row['description']; ?></textarea>
                                        </div>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel
                                        </button>
                                        <button type="submit" class="btn btn-primary">Update Quiz</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No quizzes found.</p>
        <?php endif; ?>

        <!-- Add Quiz Modal -->
        <div class="modal fade" id="addQuizeModal" tabindex="-1" aria-labelledby="addQuizModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Add New Quiz</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="manage-quizzes.php" method="post">
                            <div class="mb-3">
                                <label for="title" class="form-label">Quiz Title</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="duration" class="form-label">Duration (in minutes)</label>
                                <input type="number" class="form-control" id="duration" name="duration" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Quiz Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Quiz</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>
