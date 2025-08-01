<?php
// Database connection
$servername = "127.0.0.1";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "elegancesalondb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$feedbackMessage = "";
$successMessage = "";
$errorMessage = "";

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = !empty($_POST['user_id']) ? intval($_POST['user_id']) : NULL;
    $message = trim($_POST['message']);
    
    // Validate input
    if (empty($message)) {
        $errorMessage = "Please enter your feedback message.";
    } else {
        // If user_id is provided, verify it exists
        if ($user_id !== NULL) {
            $checkUser = $conn->prepare("SELECT user_id FROM users WHERE user_id = ?");
            $checkUser->bind_param("i", $user_id);
            $checkUser->execute();
            $checkUser->store_result();
            
            if ($checkUser->num_rows == 0) {
                $errorMessage = "Invalid user ID. Please enter a valid user ID or leave blank.";
                $checkUser->close();
            } else {
                $checkUser->close();
                
                // Prepare and bind with user_id
                $stmt = $conn->prepare("INSERT INTO feedback (user_id, message, submitted_at) VALUES (?, ?, NOW())");
                $stmt->bind_param("is", $user_id, $message);
            }
        } else {
            // Prepare and bind without user_id
            $stmt = $conn->prepare("INSERT INTO feedback (message, submitted_at) VALUES (?, NOW())");
            $stmt->bind_param("s", $message);
        }
        
        // Execute if no errors
        if (empty($errorMessage)) {
            if ($stmt->execute()) {
                $successMessage = "Thank you for your feedback! We appreciate your input.";
                $feedbackMessage = ""; // Clear the form
            } else {
                $errorMessage = "Error submitting feedback. Please try again later.";
            }
            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Feedback - Elegance Salon">
  <title>Feedback | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    :root {
      --gold: #FFD700;
      --dark-gold: #D4AF37;
      --black: #0a0a0a;
      --dark-gray: #1a1a1a;
      --light-gray: #e0e0e0;
    }

    body {
      margin: 0;
      font-family: 'Montserrat', 'Segoe UI', sans-serif;
      background-color: var(--black);
      color: #fff;
      scroll-behavior: smooth;
    }

    .navbar {
      background: rgba(10, 10, 10, 0.9);
      border-bottom: 2px solid var(--gold);
      backdrop-filter: blur(10px);
      transition: all 0.3s ease;
    }

    .navbar.scrolled {
      background: rgba(10, 10, 10, 0.95);
      padding-top: 5px;
      padding-bottom: 5px;
    }

    .navbar-brand {
      font-weight: 700;
      color: var(--gold);
      font-size: 1.8rem;
      letter-spacing: 1px;
    }

    .navbar-brand img {
      height: 40px;
      margin-right: 10px;
    }

    .nav-link {
      color: #eee;
      font-weight: 500;
      margin: 0 10px;
      position: relative;
    }

    .nav-link:before {
      content: '';
      position: absolute;
      width: 0;
      height: 2px;
      bottom: 0;
      left: 0;
      background-color: var(--gold);
      visibility: hidden;
      transition: all 0.3s ease-in-out;
    }

    .nav-link:hover:before,
    .nav-link.active:before {
      visibility: visible;
      width: 100%;
    }

    .nav-link:hover {
      color: var(--gold);
    }

    .btn-gold {
      background-color: var(--gold);
      color: var(--black);
      font-weight: 600;
      border: none;
      transition: all 0.3s;
    }

    .btn-gold:hover {
      background-color: var(--dark-gold);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(255, 215, 0, 0.3);
    }

    section {
      padding: 100px 0;
      position: relative;
    }

    .section-title {
      font-size: 2.8rem;
      color: var(--gold);
      margin-bottom: 60px;
      text-align: center;
      position: relative;
      font-weight: 700;
    }

    .section-title:after {
      content: '';
      display: block;
      width: 80px;
      height: 3px;
      background: var(--gold);
      margin: 15px auto;
    }

    .feedback-form {
      background: var(--dark-gray);
      padding: 40px;
      border-radius: 15px;
      border: 1px solid var(--gold);
      max-width: 800px;
      margin: 0 auto;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      color: #fff;
      padding: 12px 15px;
      margin-bottom: 20px;
    }

    .form-control:focus {
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      box-shadow: 0 0 0 0.25rem rgba(255, 215, 0, 0.25);
    }

    textarea.form-control {
      min-height: 200px;
    }

    .alert-success {
      background-color: rgba(40, 167, 69, 0.2);
      border-color: rgba(40, 167, 69, 0.3);
      color: #fff;
    }

    .alert-danger {
      background-color: rgba(220, 53, 69, 0.2);
      border-color: rgba(220, 53, 69, 0.3);
      color: #fff;
    }

    .footer {
      background: var(--dark-gray);
      padding: 60px 0 30px;
      color: #ccc;
      position: relative;
    }

    .footer:before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 3px;
      background: linear-gradient(to right, var(--gold), var(--dark-gold));
    }

    .footer-logo {
      font-size: 2rem;
      font-weight: 700;
      color: var(--gold);
      margin-bottom: 20px;
      display: inline-block;
    }

    .footer-links h5 {
      color: var(--gold);
      font-weight: 600;
      margin-bottom: 20px;
      font-size: 1.2rem;
    }

    .footer-links ul {
      list-style: none;
      padding: 0;
    }

    .footer-links li {
      margin-bottom: 10px;
    }

    .footer-links a {
      color: #ccc;
      text-decoration: none;
      transition: all 0.3s;
    }

    .footer-links a:hover {
      color: var(--gold);
      padding-left: 5px;
    }

    .social-icons a {
      display: inline-block;
      width: 40px;
      height: 40px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      border-radius: 50%;
      text-align: center;
      line-height: 40px;
      margin-right: 10px;
      transition: all 0.3s;
    }

    .social-icons a:hover {
      background: var(--gold);
      color: var(--black);
      transform: translateY(-5px);
    }

    .copyright {
      border-top: 1px solid rgba(255, 255, 255, 0.1);
      padding-top: 20px;
      margin-top: 40px;
      font-size: 0.9rem;
    }

    .back-to-top {
      position: fixed;
      bottom: 30px;
      right: 30px;
      width: 50px;
      height: 50px;
      background: var(--gold);
      color: var(--black);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.2rem;
      z-index: 99;
      opacity: 0;
      visibility: hidden;
      transition: all 0.3s;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .back-to-top.active {
      opacity: 1;
      visibility: visible;
    }

    .back-to-top:hover {
      background: var(--dark-gold);
      transform: translateY(-3px);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      section {
        padding: 80px 0;
      }
    }

    @media (max-width: 768px) {
      .navbar-brand {
        font-size: 1.5rem;
      }

      .section-title {
        font-size: 2.2rem;
      }
    }

    @media (max-width: 576px) {
      .section-title {
        font-size: 1.8rem;
      }
      
      .feedback-form {
        padding: 25px;
      }
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="index.html">
        <img src="assets/images/salonlogo.jpg" alt="Elegance Salon Logo">
        ELEGANCE SALON
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="homepage.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
          <li class="nav-item"><a class="nav-link active" href="feedback.php">Feedback</a></li>
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
            <a class="btn btn-gold" href="contactus.php">Book Now</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Feedback Section -->
  <section id="feedback" class="bg-black" style="padding-top: 150px;">
    <div class="container">
      <h2 class="section-title">Share Your Feedback</h2>
      <p class="text-center text-white mb-5">We value your opinion. Let us know about your experience at Elegance Salon.</p>
      
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <?php if (!empty($successMessage)): ?>
            <div class="alert alert-success text-center mb-4">
              <?php echo $successMessage; ?>
            </div>
          <?php endif; ?>
          
          <?php if (!empty($errorMessage)): ?>
            <div class="alert alert-danger text-center mb-4">
              <?php echo $errorMessage; ?>
            </div>
          <?php endif; ?>
          
          <div class="feedback-form">
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
              <div class="mb-4">
                <label for="user_id" class="form-label text-gold">User ID (if applicable)</label>
                <input type="number" class="form-control" id="user_id" name="user_id" placeholder="Enter your user ID (optional)">
                <small class="text-muted">Leave blank if you're not a registered user</small>
              </div>
              
              <div class="mb-4">
                <label for="message" class="form-label text-gold">Your Feedback *</label>
                <textarea class="form-control" id="message" name="message" required><?php echo htmlspecialchars($feedbackMessage); ?></textarea>
              </div>
              
              <button type="submit" class="btn btn-gold w-100">Submit Feedback</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 mb-5 mb-lg-0">
          <div class="footer-about">
            <div class="footer-logo mb-3">ELEGANCE SALON</div>
            <p class="text-white">Redefining beauty with luxury services, premium products, and exceptional customer care since 2010.</p>
            <div class="mt-4">
              <a href="contactus.php" class="btn btn-gold">Book Appointment</a>
            </div>
          </div>
        </div>
        
        <div class="col-sm-6 col-lg-2 mb-4 mb-sm-0">
          <div class="footer-links">
            <h5>Services</h5>
            <ul>
              <li><a href="index.html#services">Hair</a></li>
              <li><a href="index.html#services">Nails</a></li>
              <li><a href="index.html#services">Skin Care</a></li>
              <li><a href="index.html#services">Makeup</a></li>
              <li><a href="index.html#services">Spa</a></li>
            </ul>
          </div>
        </div>
        
        <div class="col-sm-6 col-lg-2 mb-4 mb-sm-0">
          <div class="footer-links">
            <h5>Company</h5>
            <ul>
               <li><a href="about.php">About Us</a></li>
              <li><a href="about.php">Our Team</a></li>
              <li><a href="contactus.php">Contact</a></li>
            </ul>
          </div>
        </div>
        
        <div class="col-lg-4">
          <div class="footer-newsletter">
            <h5>Join Our Newsletter</h5>
            <p class="text-white">Subscribe for beauty tips, special offers, and exclusive events.</p>
            <form class="mt-3">
              <div class="input-group">
                <input type="email" class="form-control" placeholder="Your email" required>
                <button class="btn btn-gold" type="submit">Subscribe</button>
              </div>
            </form>
            
            <div class="social-icons mt-4">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-tiktok"></i></a>
              <a href="#"><i class="bi bi-youtube"></i></a>
              <a href="#"><i class="bi bi-pinterest"></i></a>
            </div>
          </div>
        </div>
      </div>
      
      <div class="copyright text-center">
        <p class="mb-0">&copy; <?php echo date('Y'); ?> Elegance Salon. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
      </div>
    </div>
  </footer>

  <!-- Back to Top Button -->
  <a href="#" class="back-to-top"><i class="bi bi-arrow-up"></i></a>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });

    // Back to top button
    const backToTopButton = document.querySelector('.back-to-top');
    window.addEventListener('scroll', function() {
      if (window.scrollY > 300) {
        backToTopButton.classList.add('active');
      } else {
        backToTopButton.classList.remove('active');
      }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>