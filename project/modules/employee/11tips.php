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

        /* Fixed size for the GIF */
        .lesson-image {
            width: 50%; /* Reducing the width to 50% */
            height: auto;
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
            <h2 class="text-center mb-4">11 Internet Safety Tips for Your Online Security</h2>
            <div class="row">
                <div class="col-lg-12">
                    <p>Here are 11 key internet safety tips to help protect your online security:</p>

                    <ol>
                        <li><strong>Use Strong Passwords :</strong> Create unique, complex passwords for each account, and avoid using easily guessed information like birthdays or common words. A password manager can help you store and generate strong passwords.</li>
                        <br>
                        <li><strong>Enable Two-Factor Authentication (2FA) :</strong> Add an extra layer of security by requiring a second form of verification (such as a code sent to your phone) in addition to your password.</li>
                        <br>
                        <li><strong>Be Wary of Phishing Scams :</strong> Avoid clicking on suspicious links or attachments in unsolicited emails or messages. Always verify the sender’s legitimacy before sharing any sensitive information.</li>
                        <br>
                        <li><strong>Keep Software Updated :</strong> Regularly update your operating system, apps, and antivirus software to protect against the latest security vulnerabilities.</li>
                        <br>
                        <li><strong>Avoid Public Wi-Fi for Sensitive Transactions :</strong> Public Wi-Fi networks can be insecure. Use a Virtual Private Network (VPN) or avoid accessing sensitive accounts when using them.</li>
                        <br>
                        <li><strong>Secure Your Home Network :</strong> Use strong, unique passwords for your router and enable WPA3 encryption to protect your home Wi-Fi network.</li>
                        <br>
                        <li><strong>Limit Personal Information Shared Online :</strong> Be cautious about what personal information you share on social media and websites. Attackers can use this data for identity theft or phishing attacks.</li>
                        <br>
                        <li><strong>Use Antivirus and Anti-Malware Software :</strong> Install reputable antivirus and anti-malware programs on your devices to detect and remove threats.</li>
                        <br>
                        <li><strong>Regularly Monitor Accounts for Suspicious Activity :</strong> Keep an eye on your financial and online accounts for any signs of unauthorized access or transactions.</li>
                        <br>
                        <li><strong>Backup Important Data :</strong> Regularly back up your files to a secure cloud service or external drive to prevent data loss in case of an attack or hardware failure.</li>
                        <br>
                        <li><strong>Be Cautious with Downloads :</strong> Only download software and apps from trusted sources to avoid inadvertently installing malware or spyware.</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Video Embed Section -->
    <section class="youtube-section py-5 bg-light">
        <div class="container">
            <h4 class="text-center mb-4">Refer the video below</h4>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/aO858HyFbKI" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Button -->
        <div class="text-center mt-5">
            <a href="quizzes.php" class="btn btn-primary btn-lg">Next</a>
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
