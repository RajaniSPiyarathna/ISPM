<?php
session_start();

// Check if the user is logged in and is an Employee
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employee') {
    header("Location: ../auth/login.php");
    exit;
}

include '../../config/config.php';

// Get user ID from session
$user_id = $_SESSION['user_id'];

// Fetch employee's quiz data (total marks, quizzes faced, and correct/wrong answers)
$query = "
    SELECT 
        q.title,  -- Fetching title from quizzes table
        qa.quiz_id,
        MAX(qa.total_marks) AS highest_marks,
        qa.correct_answers,
        qa.wrong_answers,
        COUNT(qa.id) AS attempt_count  
    FROM 
        quiz_attempts qa
    JOIN 
        quizzes q ON qa.quiz_id = q.id  -- Join with quizzes table
    WHERE 
        qa.user_id = ?
    GROUP BY 
        qa.quiz_id
";
$stmt = $conn->prepare($query);
if (!$stmt) {
    die("Preparation failed: " . $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$quizzes = [];
while ($row = $result->fetch_assoc()) {
    $quizzes[] = $row;
}

// Calculate overall score and determine employee level
$total_score = 0;
$correct_answers_total = 0;
$wrong_answers_total = 0;

foreach ($quizzes as $quiz) {
    $total_score += $quiz['highest_marks'];
    $correct_answers_total += $quiz['correct_answers'];
    $wrong_answers_total += $quiz['wrong_answers'];
}

// Determine employee level based on total score
if ($total_score === 0) {
    $employee_level = 'Beginner'; // Default level
} elseif ($total_score < 50) {
    $employee_level = 'Moderate'; // 1 to 49 marks
} else {
    $employee_level = 'Expert'; // 50+ marks
}

// Calculate marks needed to reach the next level and progress percentage
$next_level_threshold = ($employee_level === 'Moderate') ? 50 : (($employee_level === 'Expert') ? 100 : 0);
$marks_to_next_level = max(0, $next_level_threshold - $total_score);
$progress_percentage = ($next_level_threshold > 0) ? ($total_score / $next_level_threshold) * 100 : 0;

// Fetch employee's name from users table
$name_query = "SELECT name FROM users WHERE id = ?";
$name_stmt = $conn->prepare($name_query);
if (!$name_stmt) {
    die("Preparation failed: " . $conn->error);
}
$name_stmt->bind_param("i", $user_id);
$name_stmt->execute();
$name_result = $name_stmt->get_result();
$employee_name = $name_result->fetch_assoc()['name'] ?? 'Employee'; // Default to 'Employee' if not found

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            z-index: 10;
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
        canvas {
            max-width: 250px; /* Adjusted pie chart size */
            margin: 0 auto;
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
                    <h6>Hello, <?php echo htmlspecialchars($employee_name); ?></h6>
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
        <div class="row mb-3">
            <div class="col">
                <div class="card p-3 text-center">
                    <h5>Your Knowledge Level</h5>
                    <canvas id="knowledgeLevelChart"></canvas>
                </div>
            </div>
            <div class="col">
                <div class="card p-3 text-center">
                    <h5>Your Progress</h5>
                    <canvas id="progressChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Quiz Details</h5>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Quiz Title</th>
                                    <th>Total Marks</th>
                                    <th>Attempt Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($quizzes as $quiz): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($quiz['title']); ?></td>
                                        <td><?php echo $quiz['highest_marks']; ?></td>
                                        <td><?php echo $quiz['attempt_count']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if (empty($quizzes)): ?>
                                    <tr>
                                        <td colspan="3">No quiz data available.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Data for knowledge level chart
        const knowledgeLevelData = {
            labels: ['Beginner', 'Moderate', 'Expert'],
            datasets: [{
                label: 'Knowledge Level',
                data: [
                    '<?php echo ($employee_level === "Beginner" && $total_score === 0) ? 1 : 0; ?>',
                    '<?php echo ($employee_level === "Moderate" && $total_score >= 1 && $total_score < 50) ? $total_score : 0; ?>',
                    '<?php echo ($employee_level === "Expert" && $total_score >= 50) ? $total_score : 0; ?>'
                ],
                backgroundColor: ['#28a745', '#ffc107', '#dc3545'],
            }],
        };

        // Data for progress chart
        const progressData = {
            labels: ['Achieved Marks', 'Marks to Next Level'],
            datasets: [{
                label: 'Your Progress',
                data: [<?php echo $total_score; ?>, <?php echo $marks_to_next_level; ?>],
                backgroundColor: ['#007bff', '#d3d3d3'],
            }],
        };

        // Configuration for knowledge level chart
        const knowledgeLevelConfig = {
            type: 'doughnut',
            data: knowledgeLevelData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false, // Disable title display from Chart.js
                    }
                }
            },
        };

        // Configuration for progress chart
        const progressConfig = {
            type: 'doughnut',
            data: progressData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: false, // Disable title display from Chart.js
                    }
                }
            },
        };

        // Create the charts
        const knowledgeLevelChart = new Chart(
            document.getElementById('knowledgeLevelChart'),
            knowledgeLevelConfig
        );

        const progressChart = new Chart(
            document.getElementById('progressChart'),
            progressConfig
        );
    </script>
</body>
</html>
