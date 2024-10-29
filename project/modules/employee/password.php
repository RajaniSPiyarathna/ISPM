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

        /* Reduce image size */
        .lesson-image {
            max-width: 400px; /* Set max width */
            height: auto; /* Maintain aspect ratio */
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
            <h2 class="text-center mb-4">How to Keep Your Data Safe with a Password Manager</h2>
            <div class="row">
                <div class="col-lg-12">
                    <p>
                        Using a password manager helps keep your data safe by securely storing and encrypting your passwords in a single, protected location. It allows you to create and store strong, unique passwords for every account, preventing credential reuse.
                    </p>

                    <!-- Image Placeholder -->
                    <div class="text-center mb-4">
                        <img src="../../assets/images/image11.jpg" alt="Password Manager" class="lesson-image img-fluid">
                    </div>

                    <h3>How to Keep Your Data Safe with a Password Manager?</h3>
                    <ul>
                        <li><strong>Use a Strong Master Password:</strong> Create a unique, complex master password to secure your password manager. Include a mix of uppercase, lowercase letters, numbers, and special characters.</li>
                        <li><strong>Enable Two-Factor Authentication (2FA):</strong> Add an extra layer of security by enabling 2FA. This requires a second verification step, like a code sent to your phone or biometric authentication (fingerprint, face scan).</li>
                        <li><strong>Keep Your Password Manager Updated:</strong> Regularly update your password manager to protect against new security vulnerabilities.</li>
                        <li><strong>Use Unique Passwords for Every Account:</strong> Always use different passwords for each account. If one is compromised, others remain safe.</li>
                        <li><strong>Store Sensitive Data Carefully:</strong> Only store necessary information, like credit card details or notes, and make sure they are encrypted.</li>
                        <li><strong>Use a Strong Password Generator:</strong> Take advantage of the built-in password generator to create strong, random passwords for your accounts.</li>
                        <li><strong>Avoid Public Wi-Fi:</strong> Don’t access your password manager over public Wi-Fi without using a VPN, as public networks are often insecure.</li>
                        <li><strong>Use Encryption:</strong> Ensure your password manager encrypts your data both during storage (at rest) and while sending it.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Section -->
    <section class="youtube-section py-5 bg-light">
        <div class="container">
            <h4 class="text-center mb-4">How to Keep Your Data Safe with a Password Manager</h4>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/kLZixLZVplo?si=OxoZHZ3duD71fYMU" title="YouTube video" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Next Button -->
        <div class="text-center mt-5">
            <a href="studymaterials.php" class="btn btn-primary btn-lg">Next</a>
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
