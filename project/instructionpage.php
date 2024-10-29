<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LECO Security Awareness</title>
    <!-- Bootstrap 5 CSS -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />
    
    <!-- Internal CSS -->
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #e9f5ff;
      }

      header {
        background: linear-gradient(to right, #007bff, #00b4d8);
        color: #fff;
        height: 160px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.3);
      }

      .header h1 {
        font-size: 3rem;
        font-weight: 700;
      }

      .header p {
        font-size: 1.4rem;
      }

      .btn {
        padding: 12px 25px;
        font-size: 1.1rem;
      }

      .card {
        transition: transform 0.4s, box-shadow 0.4s;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
      }

      .card:hover {
        transform: scale(1.08);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.3);
      }

      .lesson-section {
        padding: 80px 0;
        background-color: #f4f4f4;
      }

      .lesson-section h1 {
        color: #007bff;
        font-size: 2.8rem;
        margin-bottom: 20px;
      }

      .lesson-section h3,
      .lesson-section h4 {
        color: #444;
        font-weight: 600;
      }

      .lesson-section p,
      .lesson-section ul {
        line-height: 1.8;
        color: #333;
      }

      .lesson-section ul {
        list-style-type: disc;
        margin: 20px 0;
        padding-left: 30px;
      }

      .lesson-image {
        max-width: 100%;
        max-height: 500px;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        transition: transform 0.3s;
      }

      .lesson-image:hover {
        transform: rotate(2deg);
      }

      .text-center .btn {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 15px 35px;
        font-size: 1.3rem;
        border-radius: 50px;
        transition: background-color 0.3s;
      }

      .text-center .btn:hover {
        background-color: #0056b3;
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
      }

      footer {
        background-color: #1c1c1c;
        color: #fff;
        text-align: center;
        padding: 20px 0;
        margin-top: 50px;
      }

      footer p {
        font-size: 1.1rem;
        letter-spacing: 1px;
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="#">LECO Security</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="about.php">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="modules/auth/login.php">Login</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <header class="text-white text-center py-5">
      <div class="container">
        <h1 class="display-4">Welcome to LECO's Security Awareness Platform</h1>
        <p class="lead">
          Stay informed, stay secure. Train, learn, and test your cybersecurity
          knowledge.
        </p>
      </div>
    </header>

    <!-- Lesson Section -->
    <section class="lesson-section py-5 bg-light">
      <div class="container">
        <h1 class="text-center mb-4">Security Education, Awareness, and Training</h1>
        <div class="row">
          <div class="col-lg-6 mb-4">
            <img src="assets/images/image4.jpg" class="img-fluid lesson-image" alt="Cybersecurity Training">
          </div>
          <div class="col-lg-6">
            <h3>Why Security Awareness Matters</h3>
            <p>
              In today’s digital world, cyber threats are becoming increasingly sophisticated. 
              For LECO, protecting our data and systems is crucial not only for our company’s security 
              but also for our clients’ trust. That’s why our Security Awareness Training Program is essential. 
              It equips every IT employee with the knowledge and skills to identify, prevent, 
              and respond to potential security threats.
            </p>
            <h4>Key Benefits of Security Training:</h4>
            <ul>
              <li><strong>Preventing Security Breaches</strong>: Understand common threats like phishing and social engineering to avoid falling victim to attacks.</li>
              <li><strong>Protecting Sensitive Data</strong>: Follow proper cybersecurity protocols to secure sensitive company and client data.</li>
              <li><strong>Promoting a Culture of Security</strong>: Awareness training fosters a proactive approach, making security everyone's responsibility.</li>
            </ul>
            <h4>Components of the Training Program:</h4>
            <ul>
              <li><strong>Interactive Modules</strong>: Covering social engineering, phishing, and incident response with engaging content.</li>
              <li><strong>Quizzes and Assessments</strong>: Test and reinforce knowledge, ensuring everyone is up-to-date on best practices.</li>
              <li><strong>Policy Acknowledgment</strong>: Stay informed with regular updates to company policies and security protocols.</li>
            </ul>
          </div>
        </div>

        <div class="row mt-4">
          <div class="col-lg-12">
            <h4>Stay Alert and Informed</h4>
            <p>
              Regularly participating in training and staying updated with policies helps ensure a secure work environment. 
              Remember, cybersecurity is not just an IT responsibility—it’s everyone’s responsibility.
            </p>
            <center><p><strong>Together, we can make LECO a safer, more secure place.</strong></p></center>
            <p>If you have any questions or need further information, please contact the IT Security Team.</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Next Button -->
    <div class="text-center my-4">
      <a href="introtocs.php" class="btn btn-primary btn-lg">Next</a>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
      <div class="container">
        <p class="mb-0">
          &copy; 2024 LECO Security Awareness. All Rights Reserved.
        </p>
      </div>
    </footer>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
  </body>
</html>
