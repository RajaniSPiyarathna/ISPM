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
    <title>LECO Security Awareness - DDoS Attacks</title>
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
        max-width: 500%;
        max-height: 500px;
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
                Learn about the threats posed by DDoS attacks and how to safeguard your systems.
            </p>
        </div>
    </header>

    <!-- Lesson Section -->
    <section class="lesson-section py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">What is a DDoS Attack?</h2>
            <div class="row">
                <div class="col-lg-12">
                    <p>A Distributed Denial-of-Service (DDoS) attack is a malicious attempt to disrupt the normal functioning of a targeted server, service, or network by overwhelming it with a flood of internet traffic.</p>

                         <!-- Image Placeholder -->
                    <div class="text-center mb-4">
                        <img src="../../assets/images/image8.avif" alt="DDoS Attacks Overview" class="lesson-image img-fluid">
                    </div>

                    <h3>How DDoS Attacks Work:</h3>
                    <p>Attackers use multiple compromised systems to launch the attack, making it difficult to stop because the traffic originates from many different sources.</p>

                    <h3>Types of DDoS Attacks:</h3>
                    <ul>
                        <li><strong>Volume-Based Attacks:</strong> These include ICMP floods and UDP floods, aiming to consume the bandwidth of the target.</li>
                        <li><strong>Protocol Attacks:</strong> Exploit server resources and involve attacks like SYN floods, which target the TCP handshake.</li>
                        <li><strong>Application Layer Attacks:</strong> Target specific applications and involve HTTP floods to overwhelm web servers.</li>
                    </ul>

                    <h3>Impact of DDoS Attacks:</h3>
                    <ul>
                        <li>Website downtime, leading to potential revenue loss.</li>
                        <li>Reputation damage for businesses and service providers.</li>
                        <li>Increased operational costs for mitigation and recovery.</li>
                    </ul>

                    <h3>Preventing DDoS Attacks:</h3>
                    <ul>
                        <li><strong>Use a DDoS Protection Service:</strong> Implement services designed to absorb or deflect attack traffic.</li>
                        <li><strong>Increase Bandwidth:</strong> Having more bandwidth can help mitigate the effects of an attack.</li>
                        <li><strong>Implement Rate Limiting:</strong> Control the amount of incoming traffic to prevent overload.</li>
                        <li><strong>Keep Systems Updated:</strong> Regular updates to software and hardware can help prevent vulnerabilities.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Video Embed Section -->
    <section class="youtube-section py-5 bg-light">

        <div class="container">
            <h4 class="text-center mb-4">Refer to the Introduction to DDoS Attacks video</h4>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/yLbC7G71IyE" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

                <!-- Next Button -->
        <div class="text-center mt-5">
            <a href="ddosquiz.php" class="btn btn-primary btn-lg">Next</a>
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
