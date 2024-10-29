<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}


// Check if the user role is not 'employee'
if ($_SESSION['role'] !== 'employee') {
    // Redirect to login page
    header("Location: ../auth/login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>LECO Security Training</title>
    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #e0f0ff;
            color: #002f5e;
            text-align: center;
        }

        header {
            background-color: #005b99;
            padding: 20px;
            color: white;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        header h1 {
            font-size: 2.5em;
        }

        header h2 {
            font-size: 1.5em;
            margin-top: 10px;
        }

        section h4 {
            color: red;
            font-size: 1.0em;
            margin-top: 10px;
        }

        .main-content {
            margin: 40px auto;
            max-width: 800px;
        }

        .training-container {
            background-color: #f0f8ff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .training-container h3 {
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .training-container p {
            font-size: 1.2em;
            margin-bottom: 20px;
        }

        .video-container {
            margin: 20px auto;
            max-width: 640px;
        }

        video {
            width: 100%;
            border: 3px solid #005b99;
            border-radius: 8px;
        }

        .start-training {
            background-color: #005b99;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2em;
            cursor: pointer;
            border-radius: 8px;
            margin-top: 20px;
        }

        .start-training:hover {
            background-color: #003f73;
        }

        .simulation-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #d9effc;
            border-radius: 8px;
        }

        .simulation-section h4 {
            font-size: 1.5em;
            margin-bottom: 15px;
        }

        .simulation-section button {
            background-color: #005b99;
            color: white;
            padding: 10px 20px;
            border: none;
            margin: 5px;
            cursor: pointer;
            border-radius: 8px;
        }

        .simulation-section button:hover {
            background-color: #003f73;
        }

        #response {
            margin-top: 20px;
            font-size: 1.2em;
        }

        footer {
            background-color: black;
            color: white;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>LECO Security</h1>
            <h2>Information System Security Training</h2>
        </div>
    </header>
    <section class="main-content">
        <div class="training-container">
            <h3>Welcome to the Security Training Simulation</h3>
            <h4>Note: You will be informed about the date and time when you should attend to the cyber drill.</h4>
            
            <!-- Video Section -->
            <div class="video-container">
                <video controls>
                    <source src="../../assets/images/vid1.mp4" type="video/mp4">
                </video>
            </div>
        </div>
    </section>
    
    <footer>
        <p>&copy; 2024 LECO Company - All Rights Reserved</p>
    </footer>

    <script>
        function startSimulation() {
            document.getElementById('simulation').style.display = 'block';
        }

        function submitAnswer(answer) {
            const responseDiv = document.getElementById('response');
            if (answer === 'report') {
                responseDiv.innerHTML = "<p style='color:green;'>Correct! Always report suspicious emails to the IT department.</p>";
            } else {
                responseDiv.innerHTML = "<p style='color:red;'>Incorrect. Never reply to suspicious emails, always report them.</p>";
            }
        }
    </script>

</body>
</html>
