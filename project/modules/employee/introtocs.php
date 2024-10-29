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
            <p class="lead">
                Stay informed, stay secure. Train, learn, and test your cybersecurity knowledge.
            </p>
        </div>
    </header>

    <!-- Lesson Section -->
    <section class="lesson-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Introduction to Cybersecurity for LECO Employees</h2>
            <div class="row">
                <div class="col-lg-12">
                    <h3>What is Cybersecurity?</h3>
                    <p>Cybersecurity is the practice of protecting computers, networks, and data from unauthorized access, theft, and damage. It involves various technologies, processes, and practices designed to keep information safe.</p>

                    <!-- Image Placeholder -->
                    <div class="text-center mb-4">
                        <img src="../../assets/images/image6.jpg" alt="Cybersecurity Overview" class="lesson-image img-fluid">
                    </div>

                    <h3>Why is Cybersecurity Important?</h3>
                    <ul>
                        <li><strong>Protects Sensitive Information:</strong> Cybersecurity helps protect personal and company data from cyber threats such as hackers and malware.</li>
                        <li><strong>Prevents Financial Loss:</strong> Breaches can lead to significant financial losses due to fraud, theft, and system downtime.</li>
                        <li><strong>Maintains Trust:</strong> Keeping customer and business information secure builds trust and ensures business continuity.</li>
                    </ul>

                    <h3>Common Cyber Threats:</h3>
                    <ul>
                        <li>Phishing</li>
                        <li>Distributed Denial-of-Service (DDoS)</li>
                        <li>Malware</li>
                        <li>Social Engineering Attacks</li>
                        <li>Password Security</li>
                    </ul>

                    <h3>Basic Cybersecurity Best Practices:</h3>
                    <h5>Be Cautious with Emails:</h5>
                    <ul>
                        <li>Do not open attachments or click on links from unknown senders.</li>
                        <li>Verify the sender's email address and be wary of urgent or unusual requests.</li>
                    </ul>

                    <h5>Keep Software Updated:</h5>
                    <ul>
                        <li>Regularly update operating systems, browsers, and software to protect against vulnerabilities.</li>
                    </ul>

                    <h5>Use Two-Factor Authentication (2FA):</h5>
                    <ul>
                        <li>Whenever possible, enable 2FA to add an extra layer of security to your accounts.</li>
                    </ul>

                    <h5>Be Aware of Unusual Activity:</h5>
                    <ul>
                        <li>Report any suspicious emails, pop-ups, or unexpected system behavior to the IT department.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Video Embed Section -->
    <section class="youtube-section py-5 bg-light">
    <div class="container">
        <h4 class="text-center mb-4">Refer the below Introduction to Cybersecurity video</h4>
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/88-FENio9Yw" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>

    <!-- Next Button -->
    <div class="text-center mt-5">
        <a href="introquiz.php" class="btn btn-primary btn-lg">Next</a>
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
