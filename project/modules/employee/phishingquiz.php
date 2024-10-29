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

    <!-- Quiz Section -->
    <section class="quiz-section py-5 bg-light">
    <div class="container">
        <h2 class="text-center mb-4">Test Your Knowledge on Phishing</h2>
        <form id="quizForm">
            <div class="row">
                <div class="col-lg-12">
                    <ol>
                        <li>
                            <strong>What is phishing?</strong><br>
                            <label>
                                <input type="radio" name="q1" value="A"> A) A form of social engineering
                            </label><br>
                            <label>
                                <input type="radio" name="q1" value="B"> B) A method to speed up computers
                            </label><br>
                            <label>
                                <input type="radio" name="q1" value="C"> C) A way to block spam
                            </label><br>
                            <label>
                                <input type="radio" name="q1" value="D"> D) A type of antivirus software
                            </label><br><br>
                        </li>

                        <li>
                            <strong>Which of the following is a common sign of a phishing email?</strong><br>
                            <label>
                                <input type="radio" name="q2" value="A"> A) Personalized greeting
                            </label><br>
                            <label>
                                <input type="radio" name="q2" value="B"> B) Request for sensitive information
                            </label><br>
                            <label>
                                <input type="radio" name="q2" value="C"> C) Official company logo
                            </label><br>
                            <label>
                                <input type="radio" name="q2" value="D"> D) Attached image
                            </label><br><br>
                        </li>

                        <li>
                            <strong>Phishing attacks often involve:</strong><br>
                            <label>
                                <input type="radio" name="q3" value="A"> A) Downloading software
                            </label><br>
                            <label>
                                <input type="radio" name="q3" value="B"> B) Tricking users into revealing personal information
                            </label><br>
                            <label>
                                <input type="radio" name="q3" value="C"> C) Speeding up internet connection
                            </label><br>
                            <label>
                                <input type="radio" name="q3" value="D"> D) Encrypting files for security
                            </label><br><br>
                        </li>

                        <li>
                            <strong>What should you do if you receive a suspicious email?</strong><br>
                            <label>
                                <input type="radio" name="q4" value="A"> A) Click on the links to investigate
                            </label><br>
                            <label>
                                <input type="radio" name="q4" value="B"> B) Reply with your details
                            </label><br>
                            <label>
                                <input type="radio" name="q4" value="C"> C) Delete it or report it
                            </label><br>
                            <label>
                                <input type="radio" name="q4" value="D"> D) Forward it to friends
                            </label><br><br>
                        </li>

                        <li>
                            <strong>A phishing email usually asks you to:</strong><br>
                            <label>
                                <input type="radio" name="q5" value="A"> A) Open an attachment
                            </label><br>
                            <label>
                                <input type="radio" name="q5" value="B"> B) Visit a legitimate website
                            </label><br>
                            <label>
                                <input type="radio" name="q5" value="C"> C) Confirm your password
                            </label><br>
                            <label>
                                <input type="radio" name="q5" value="D"> D) Install security updates
                            </label><br><br>
                        </li>
                    </ol>

                    <button type="button" class="btn btn-primary" onclick="checkAnswers()">Submit Answers</button>

                    <!-- Results Section -->
                    <div id="result" class="mt-4"></div>
                </div>
            </div>
        </form>
    </div>
</section>

<!-- Next button (Initially hidden) -->
<div class="container text-center">
       <center><button id="nextBtn" class="btn btn-success mt-4" style="display: none;" onclick="goToNextPage()">Next</button></center>
       </div><br><br>

<!-- Footer -->
<footer class="bg-dark text-white text-center py-4 mt-5">
    <div class="container">
        <p>&copy; 2024 Phishing Awareness. All Rights Reserved.</p>
    </div>
</footer>

<!-- Script to check answers and display the result -->
<script>
    function checkAnswers() {
        var score = 0;
        var totalQuestions = 5;

        // Correct answers
        var answers = {
            q1: "A",
            q2: "B",
            q3: "B",
            q4: "C",
            q5: "C"
        };

        var resultHtml = '';
        for (var question in answers) {
            var selectedAnswer = document.querySelector(`input[name="${question}"]:checked`);
            if (selectedAnswer) {
                if (selectedAnswer.value === answers[question]) {
                    score++;
                    resultHtml += `<strong>${question}: Correct!</strong><br>`;
                } else {
                    resultHtml += `<strong>${question}: Incorrect!</strong> Correct Answer: ${answers[question]}<br>`;
                }
            } else {
                resultHtml += `<strong>${question}: Not answered!</strong><br>`;
            }
        }

        resultHtml += `<h4>You scored ${score} out of ${totalQuestions}</h4>`;
        document.getElementById('result').innerHTML = resultHtml; // Display results

        // Display the "Next" button after showing the result
        document.getElementById('nextBtn').style.display = 'block';
    }

    function goToNextPage() {
        // Redirect to the next page (e.g., results.html or any page)
        window.location.href = 'studymaterials.php';
    }
</script>

<!-- Bootstrap 5 JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
