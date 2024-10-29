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

// Example variables to indicate quiz completion status
$quizzesCompleted = [
    'introtocs' => true, 
    'phishing' => false,  
    'ddos' => false,      
    'malware' => false,   
    'social-engineering' => false,
    'password' => false,   
    '11tips' => false,     
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Combined Custom Styles -->
    <style>
        body, html {
            height: 100%;
            margin: 0;
            overflow: hidden; /* Prevents scrolling */
        }
        header {
            background-color: #007bff;
            color: #fff;
            height: 150px;
        }

        .lesson-image {
            max-width: 100%; /* Ensure image is responsive */
            height: auto; /* Keep aspect ratio */
            width: 400px; /* Reduce image size */
        }

        .next-button {
            margin-top: 30px;
        }

        /* Topic Card Styles */
        .topic-card {
            border: 10px solid #ccc;
            border-radius: 20px;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }

        .topic-card:hover {
            transform: scale(1.05);
        }

        .topic-image {
            width: 60%; /* Reduce the width of the image */
            height: auto; /* Maintain aspect ratio */
            max-height: 80px; /* Limit the height of the image */
            object-fit: contain; /* Keep the image within the container without distortion */
        }

        .btn-topic {
            width: 90%;
            margin-top: 10px;
        }

        /* Navbar Styles */
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

        .sidebar {
            width: 250px;
            position: fixed;
            top: 60px;
            bottom: 0;
            background-color: #343a40;
            padding-top: 10px;
            color: #FFF;
            overflow: auto;
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
            height: calc(100vh - 60px); /* Full viewport height minus navbar */
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centers content vertically */
            padding: 10px;
        }

        .study-materials-section {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            height: 100%; /* Ensures the content section takes up all available height */
        }

        .profile-card {
            text-align: center;
            margin-bottom: 20px;
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
                    <h6>Hello, <?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : 'Guest'; ?></h6>
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

    <!-- Main Content Area (Study Materials Section) -->
    <div class="main-content">
        <div class="profile-card">
            <br><h1>Beginner Level</h1>
        </div>

        <!-- Study Materials Section -->
        <section class="study-materials-section">
            <div class="container">
                <div class="row">
                    <!-- Introduction to Cybersecurity -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image17.png" alt="Introduction to Cybersecurity" class="topic-image">
                            <h5>Intro to Cybersecurity</h5>
                            <a href="introtocs.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                    <!-- Phishing Attacks -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image12.png" alt="Phishing Attacks" class="topic-image">
                            <h5>Phishing Attacks</h5>
                            <a href="phishing.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                    <!-- DDoS Attacks -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image13.png" alt="DDoS Attacks" class="topic-image">
                            <h5>DDoS Attacks</h5>
                            <a href="ddos.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                    <!-- Malware -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image14.png" alt="Malware" class="topic-image">
                            <h5>Malware</h5>
                            <a href="malware.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                </div>

                <!-- New Row for Last Three Sections -->
                <div class="row justify-content-center">
                    <!-- Social Engineering Attacks -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image15.png" alt="Social Engineering Attacks" class="topic-image">
                            <h5>Social Engineering Attacks</h5>
                            <a href="social-engineering.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                    <!-- Password Management -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image16.png" alt="Password Management" class="topic-image">
                            <h5>Password Management</h5>
                            <a href="password.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                    <!-- 11 Tips for Cybersecurity -->
                    <div class="col-md-3 mb-4">
                        <div class="topic-card">
                            <img src="../../assets/images/image18.png" alt="11 Tips for Cybersecurity" class="topic-image">
                            <h5>11 Tips for Cybersecurity</h5>
                            <a href="11tips.php" class="btn btn-primary btn-topic">Start Learning</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
