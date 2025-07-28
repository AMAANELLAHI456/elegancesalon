<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="About Elegance Salon - Premium beauty services with luxury experience">
  <title>About Us | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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

    .feature-box {
      background: var(--dark-gray);
      border: 1px solid var(--gold);
      border-radius: 15px;
      padding: 30px;
      text-align: center;
      transition: all 0.4s ease;
      height: 100%;
      position: relative;
      overflow: hidden;
    }

    .feature-box:before {
      content: '';
      position: absolute;
      top: -50%;
      left: -50%;
      width: 200%;
      height: 200%;
      background: linear-gradient(
        to bottom right,
        rgba(255, 215, 0, 0.1),
        rgba(255, 215, 0, 0)
      );
      transform: rotate(30deg);
      transition: all 0.6s ease;
      opacity: 0;
    }

    .feature-box:hover:before {
      opacity: 1;
      transform: rotate(0deg);
    }

    .feature-box:hover {
      transform: translateY(-10px);
      box-shadow: 0 15px 30px rgba(255, 215, 0, 0.2);
      border-color: var(--gold);
    }

    .feature-box i {
      font-size: 2.5rem;
      color: var(--gold);
      margin-bottom: 20px;
    }

    .feature-box h5 {
      font-size: 1.5rem;
      font-weight: 600;
      margin-bottom: 15px;
    }

    .feature-box p {
      color: var(--light-gray);
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

    /* Animation classes */
    .animate-delay-1 {
      animation-delay: 0.2s;
    }

    .animate-delay-2 {
      animation-delay: 0.4s;
    }

    .animate-delay-3 {
      animation-delay: 0.6s;
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
    }
  </style>
</head>

<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="assets/images/salonlogo.jpg" alt="Elegance Salon Logo">
        ELEGANCE SALON
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link active" href="homepage.php">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="aboutus.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
            <a class="btn btn-gold" href="contactus.php">Book Now</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- About Section -->
  <section id="about" class="bg-dark" style="padding-top: 150px;">
    <div class="container">
      <h2 class="section-title animate__animated animate__fadeInUp">About Elegance Salon</h2>
      <div class="row align-items-center">
        <div class="col-lg-6 mb-5 mb-lg-0 animate__animated animate__fadeInLeft">
          <img src="assets/images/rec desk.jpg" alt="Elegance Salon Reception" class="img-fluid rounded shadow-lg">
          <div class="row mt-4">
            <div class="col-6">
              <img src="assets/images/serv1.jpg" alt="Salon Service Area" class="img-fluid rounded shadow-lg mb-3">
            </div>
            <div class="col-6">
              <img src="assets/images/rec1.jpg" alt="Salon Waiting Area" class="img-fluid rounded shadow-lg mb-3">
            </div>
          </div>
        </div>
        <div class="col-lg-6 animate__animated animate__fadeInRight">
          <div class="ps-lg-5">
            <h3 class="text-gold mb-4">Redefining Beauty Standards Since 2010</h3>
            <p class="text-white mb-4">Elegance Salon stands as a beacon of luxury and innovation in the beauty industry. Founded by master stylist Elena Rodriguez, our salon has grown from a single-chair boutique to a 2,500 sq ft luxury beauty destination, earning numerous industry awards along the way.</p>
            
            <div class="d-flex mb-4">
              <div class="me-4">
                <h4 class="text-gold">15+</h4>
                <p class="text-white">Professional Stylists</p>
              </div>
              <div class="me-4">
                <h4 class="text-gold">10K+</h4>
                <p class="text-white">Happy Clients</p>
              </div>
              <div>
                <h4 class="text-gold">50+</h4>
                <p class="text-white">Industry Awards</p>
              </div>
            </div>
            
            <p class="text-white mb-4">What sets us apart is our holistic approach to beauty. We don't just change your look; we enhance your natural features while considering your lifestyle, personality, and preferences. Our team regularly attends international training sessions in Paris, Milan, and New York to stay at the forefront of beauty trends.</p>
            
            <h5 class="text-gold mb-3">Our Philosophy</h5>
            <p class="text-white mb-4">We believe true beauty comes from confidence. Our mission is to provide services that make you look incredible while creating an experience that makes you feel valued and pampered. Every product we use is carefully selected for quality, sustainability, and performance.</p>
            
            <div class="row">
              <div class="col-md-6 mb-3">
                <div class="d-flex">
                  <i class="bi bi-check-circle-fill text-gold me-2"></i>
                  <span class="text-white">Cruelty-free products</span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex">
                  <i class="bi bi-check-circle-fill text-gold me-2"></i>
                  <span class="text-white">Sanitation certified</span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex">
                  <i class="bi bi-check-circle-fill text-gold me-2"></i>
                  <span class="text-white">Eco-conscious practices</span>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="d-flex">
                  <i class="bi bi-check-circle-fill text-gold me-2"></i>
                  <span class="text-white">Accessibility features</span>
                </div>
              </div>
            </div>
            
            <a href="contact.html" class="btn btn-gold mt-3">Visit Us Today</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Team Section -->
  <section id="team" class="bg-black">
    <div class="container">
      <h2 class="section-title animate__animated animate__fadeInUp">Meet Our Team</h2>
      <p class="text-center text-white mb-5 animate__animated animate__fadeInUp">Our talented professionals are dedicated to making you look and feel your best.</p>
      
      <div class="row g-4">
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-1">
          <div class="feature-box">
            <img src="assets/images/p1.jpg" alt="Elena Rodriguez" class="img-fluid rounded-circle mb-3" width="150">
            <h5>Elena Rodriguez</h5>
            <p class="text-gold">Founder & Master Stylist</p>
            <p class="text-white">With 20 years of experience, Elena specializes in precision cutting and color correction.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-2">
          <div class="feature-box">
            <img src="assets/images/p3.jpg" alt="Marcus Johnson" class="img-fluid rounded-circle mb-3" width="150">
            <h5>Marcus Johnson</h5>
            <p class="text-gold">Creative Director</p>
            <p class="text-white">Marcus is our balayage expert and extension specialist with training from Paris.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-3">
          <div class="feature-box">
            <img src="assets/images/nail.webp" alt="Sophia Chen" class="img-fluid rounded-circle mb-3" width="150">
            <h5>Sophia Chen</h5>
            <p class="text-gold">Nail Artist</p>
            <p class="text-white">Sophia creates stunning nail art designs and specializes in medical pedicures.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-1">
          <div class="feature-box">
            <img src="assets/images/p4.jpg" alt="David Kim" class="img-fluid rounded-circle mb-3" width="150">
            <h5>David Kim</h5>
            <p class="text-gold">Makeup Artist</p>
            <p class="text-white">David is our bridal makeup specialist with airbrush certification from Milan.</p>
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
              <li><a href="about.html">About Us</a></li>
              <li><a href="about.html#team">Our Team</a></li>
              <li><a href="contact.html">Contact</a></li>
              <li><a href="#">Blog</a></li>
              <li><a href="#">Press</a></li>
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
        <p class="mb-0">&copy; <?= date('Y') ?> Elegance Salon. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms of Service</a></p>
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

    // Animation on scroll
    function animateOnScroll() {
      const elements = document.querySelectorAll('.animate__animated');
      
      elements.forEach(element => {
        const elementPosition = element.getBoundingClientRect().top;
        const screenPosition = window.innerHeight / 1.2;
        
        if (elementPosition < screenPosition) {
          const animationClass = element.getAttribute('data-animation');
          element.classList.add(animationClass);
        }
      });
    }

    window.addEventListener('scroll', animateOnScroll);
    window.addEventListener('load', animateOnScroll);
  </script>
</body>
</html>