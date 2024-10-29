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
            <h2 class="text-center mb-4">What is Social Engineering?</h2>
            <div class="row">
                <div class="col-lg-12">
                    <p>
                    Social engineering is a manipulation technique that exploits human psychology to trick people into divulging confidential information or performing actions that compromise security. Instead of directly attacking systems, social engineers target people’s trust, emotions, and tendencies, using deception to gain access to sensitive data or restricted areas.</p>

                    <!-- Image Placeholder -->
                    <div class="text-center mb-4">
                        <img src="../../assets/images/image10.gif" alt="Cybersecurity Overview" class="lesson-image img-fluid">
                    </div>

                    <h3>Types of Social Engineering</h3><br>
                    <ul>
                        <li><strong>Phishing :</strong> Fraudulent communication (via email, phone, or text) that tricks individuals into revealing personal information, such as passwords or credit card numbers.</li>
                        <br><li><strong>Pretexting :</strong> An attacker fabricates a scenario (pretext) to convince the target to provide sensitive information or perform actions that allow access to systems or data.</li>
                        <br><li><strong>Baiting :</strong> Attackers offer something enticing (e.g., a free download or a USB drive) to lure individuals into a trap, often infecting their devices with malware.</li>
                        <br><li><strong>Tailgating :</strong> The attacker gains physical access to a secured area by following someone who is authorized, such as slipping through a door before it closes.

</li>
                        <br><li><strong>Quid Pro Quo :</strong> The attacker promises a benefit (e.g., IT help or support) in exchange for information or access to systems.</li>
                        <br><li><strong>Impersonation :</strong> The attacker pretends to be someone else, like a trusted colleague, tech support, or authority figure, to manipulate the victim into granting access or sharing sensitive information.</li>
                    </ul>
                    <br><br>

                    <p>The success of social engineering relies on human error rather than technical vulnerabilities. It can lead to severe security breaches, making awareness and education critical in defending against these tactics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Video Embed Section -->
    <section class="youtube-section py-5 bg-light">
        <div class="container">
            <h4 class="text-center mb-4">Refer the Social Engineering video below</h4>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/uvKTMgWRPw4" allowfullscreen></iframe>
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
