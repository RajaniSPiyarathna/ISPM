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

// Set session variable to indicate progression when the Next button is clicked
if (isset($_POST['next'])) {
    $_SESSION['lesson_progress'] = true;
    header("Location: studymaterials.php"); // Redirect to the next page
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Link to your custom styles -->
    <style>
        /* Internal CSS to control YouTube video size */
        header {
            background-color: #007bff;
            color: #fff;
            height: 150px;
        }

        .youtube-section .embed-responsive {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
        }

        .youtube-section .embed-responsive iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none; /* Remove iframe border */
        }

        /* If you want a fixed size, use this instead */
        .fixed-size {
            width: 600px; /* Set fixed width */
            height: 338px; /* 16:9 aspect ratio */
            margin: 0 auto; /* Center align */
        }

        /* Next button styling */
        .next-button {
            margin-top: 30px;
        }

        
        .lesson-image {
        max-width: 400%;
        max-height: 400px;
      }


    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">LECO Security</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="bg-primary text-white text-center py-4">
        <div class="container">
            <h1 class="display-4">Welcome to LECO's Security Awareness Platform</h1>
            <p>
                Stay informed, stay secure. Train, learn, and test your cybersecurity knowledge.
            </p>
        </div>
    </header>

    <!-- Lesson Section -->
    <section class="lesson-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">What is Phishing Attacks</h2>
            <div class="row">
                <div class="col-lg-12">
                    <p>Phishing is a cyberattack where attackers impersonate legitimate entities to trick individuals into revealing sensitive information (e.g., passwords, credit card numbers).</p>
                    <p>Impact: Phishing can lead to data breaches, financial loss, and reputational damage.</p>

                    <h3>Types of Phishing Attacks:</h3>
                    <ul>
                        <li><strong>Email Phishing:</strong> Common method using emails that appear to be from trusted sources.</li>
                        <li><strong>Spear Phishing:</strong> Targets specific individuals with personalized attacks.</li>
                        <li><strong>Whaling:</strong> Focuses on high-profile individuals within an organization.</li>
                        <li><strong>Smishing/Vishing:</strong> Uses SMS (smishing) or voice calls (vishing) to deceive.</li>
                    </ul>

                    <h3>Identifying Phishing Attempts:</h3>
                    <h4>Red Flags in Emails:</h4>
                    <ul>
                        <li>Generic greetings (e.g., "Dear Customer").</li>
                        <li>Poor spelling and grammar.</li>
                        <li>Suspicious links or email addresses.</li>
                        <li>Urgent language or threats (e.g., “Your account will be suspended!”).</li>
                    </ul>

                    <h3>Best Practices to Avoid Phishing:</h3>
                    <ul>
                        <li><strong>Verify the Sender:</strong> Always check the email address and contact the sender through known channels.</li>
                        <li><strong>Do Not Click Links:</strong> Hover over links to see the actual URL before clicking.</li>
                        <li><strong>Use Multi-Factor Authentication:</strong> Adds an extra layer of security.</li>
                        <li><strong>Report Suspicious Emails:</strong> Report phishing attempts to the IT department.</li>
                    </ul>

                </div>

                 <!-- Image Placeholder -->
                 <div class="text-center mb-4">
                        <img src="../../assets/images/image7.jpg" alt="Phishing Example" class="lesson-image img-fluid">
                </div>

            </div>
        </div>
    </section>

    <!-- YouTube Video Embed Section -->
    <section class="youtube-section py-5 bg-light">
        <div class="container">
            <h4 class="text-center mb-4">Refer the below video about Phishing Attackers</h4>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/BnmneAjVrM4" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Button -->
    <div class="text-center mt-5">
        <a href="phishingquiz.php" class="btn btn-primary btn-lg">Next</a>
    </div>

    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-0">&copy; 2024 LECO Security Awareness. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
