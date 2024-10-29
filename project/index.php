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
    <link href="assets/css/styles.css" rel="stylesheet" />
    <style>
      body {
        font-family: 'Arial', sans-serif;
      }

      /* Navbar */
      .navbar {
        background: linear-gradient(90deg, #6a11cb 0%, #2575fc 100%);
      }

      /* Hero Section */
      header {
        background: linear-gradient(120deg, #89f7fe 0%, #66a6ff 100%);
        color: white;
      }
      header .display-4 {
        font-weight: bold;
      }
      header p {
        font-size: 1.25rem;
      }

      /* Card Styles */
      .card {
        border-radius: 15px;
        transition: transform 0.3s, box-shadow 0.3s;
      }
      .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
      }

      .card-img-top {
        border-radius: 15px 15px 0 0;
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
      }
      .card:hover .card-img-top {
        transform: scale(1.1);
      }

      /* Add some color effects to the cards */
      .card-title {
        color: #2575fc;
      }
      .card-text {
        font-size: 1.1rem;
      }

      /* Footer */
      footer {
        background-color: #333;
        color: white;
      }

      /* Animations */
      .fade-in {
        opacity: 0;
        transform: translateY(20px);
        animation: fadeIn 1s forwards;
      }

      @keyframes fadeIn {
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      /* Responsive Adjustments */
      @media (max-width: 768px) {
        header h1 {
          font-size: 2.5rem;
        }
        header p {
          font-size: 1rem;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
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
        <a href="modules/auth/login.php" class="btn btn-light btn-lg mt-3">Get Started</a>
      </div>
    </header>

    <!-- Features Section -->
    <section class="py-5">
      <div class="container">
        <div class="row text-center">
          <!-- First Card -->
          <div class="col-lg-4 mb-4 fade-in">
            <div class="card h-100 shadow-sm">
              <img
                class="card-img-top"
                src="assets/images/image1.png"
                alt="Interactive Training"
              />
              <div class="card-body">
                <h5 class="card-title">Interactive Training</h5>
                <p class="card-text">
                  Learn the latest cybersecurity practices with interactive
                  modules designed for the IT team.
                </p>
              </div>
            </div>
          </div>

          <!-- Second Card -->
          <div class="col-lg-4 mb-4 fade-in">
            <div class="card h-100 shadow-sm">
              <img
                class="card-img-top"
                src="assets/images/image2.jpg"
                alt="Quizzes and Study Materials"
              />
              <div class="card-body">
                <h5 class="card-title">Quizzes and Study Materials</h5>
                <p class="card-text">
                  Test your knowledge with quizzes, study materials, and rise from
                  Beginner, Moderator, to Expert.
                </p>
              </div>
            </div>
          </div>

          <!-- Third Card -->
          <div class="col-lg-4 mb-4 fade-in">
            <div class="card h-100 shadow-sm">
              <img
                class="card-img-top"
                src="assets/images/image3.avif"
                alt="Policy Management"
              />
              <div class="card-body">
                <h5 class="card-title">Policy Management</h5>
                <p class="card-text">
                  Admins can manage security policies and keep everyone updated on
                  the latest protocols.
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="text-white text-center py-4">
      <div class="container">
        <p class="mb-0">
          &copy; 2024 LECO Security Awareness. All Rights Reserved.
        </p>
      </div>
    </footer>

    <!-- Bootstrap 5 JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

    <script>
      // Add fade-in effect to cards when scrolling into view
      const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("fade-in");
          }
        });
      });

      document.querySelectorAll(".fade-in").forEach((el) => {
        observer.observe(el);
      });
    </script>
  </body>
</html>
