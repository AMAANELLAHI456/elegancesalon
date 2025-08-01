<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Contact Elegance Salon - Premium beauty services with luxury experience">
  <title>Contact Us | Elegance Salon</title>
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

    .contact-form {
      background: var(--dark-gray);
      padding: 40px;
      border-radius: 15px;
      border: 1px solid var(--gold);
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
      min-height: 150px;
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
      
      .contact-form {
        padding: 25px;
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
          <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
          <li class="nav-item"><a class="nav-link" href="contactus.php">Contact</a></li>
          <li class="nav-item"><a class="nav-link" href="feedback.php">Feedback</a></li>
          <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
            <a class="btn btn-gold" href="contactus.php">Book Now</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Contact Section -->
  <section id="contact" class="bg-black" style="padding-top: 150px;">
    <div class="container">
      <h2 class="section-title animate__animated animate__fadeInUp">Contact Us</h2>
      <p class="text-center text-white mb-5 animate__animated animate__fadeInUp">We'd love to hear from you. Reach out for appointments or inquiries.</p>
      
      <div class="row g-5">
        <div class="col-lg-6 animate__animated animate__fadeInLeft">
          <div class="contact-info p-4 p-lg-5 h-100">
            <h4 class="text-gold mb-4">Contact Information</h4>
            
            <div class="d-flex mb-4">
              <i class="bi bi-geo-alt-fill text-gold me-3 fs-4"></i>
              <div>
                <h5 class="text-white">Location</h5>
                <p class="text-white mb-0">123 Beauty Avenue<br>Luxury District<br>New York, NY 10001</p>
              </div>
            </div>
            
            <div class="d-flex mb-4">
              <i class="bi bi-telephone-fill text-gold me-3 fs-4"></i>
              <div>
                <h5 class="text-white">Phone</h5>
                <p class="text-white mb-0">(212) 555-1234</p>
              </div>
            </div>
            
            <div class="d-flex mb-4">
              <i class="bi bi-envelope-fill text-gold me-3 fs-4"></i>
              <div>
                <h5 class="text-white">Email</h5>
                <p class="text-white mb-0">info@elegancesalon.com</p>
              </div>
            </div>
            
            <div class="d-flex mb-4">
              <i class="bi bi-clock-fill text-gold me-3 fs-4"></i>
              <div>
                <h5 class="text-white">Hours</h5>
                <p class="text-white mb-0">Monday - Friday: 9am - 8pm<br>Saturday: 9am - 6pm<br>Sunday: 10am - 4pm</p>
              </div>
            </div>
            
            <h5 class="text-gold mt-5 mb-3">Follow Us</h5>
            <div class="social-icons">
              <a href="#"><i class="bi bi-facebook"></i></a>
              <a href="#"><i class="bi bi-instagram"></i></a>
              <a href="#"><i class="bi bi-tiktok"></i></a>
              <a href="#"><i class="bi bi-pinterest"></i></a>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6 animate__animated animate__fadeInRight">
          <div class="contact-form">
            <h4 class="text-gold mb-4">Send Us a Message</h4>
            <form>
              <div class="row">
                <div class="col-md-6">
                  <input type="text" class="form-control" placeholder="Your Name" required>
                </div>
                <div class="col-md-6">
                  <input type="email" class="form-control" placeholder="Your Email" required>
                </div>
              </div>
              <input type="text" class="form-control" placeholder="Subject">
              <textarea class="form-control" placeholder="Your Message" required></textarea>
              <button type="submit" class="btn btn-gold w-100">Send Message</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Map Section -->
  <section class="bg-dark">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h4 class="text-gold mb-4 text-center">Find Us On Map</h4>
          <div class="ratio ratio-16x9">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.215209132468!2d-73.9878449242394!3d40.74844097138946!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259a9b3117469%3A0xd134e199a405a163!2sEmpire%20State%20Building!5e0!3m2!1sen!2sus!4v1629915426785!5m2!1sen!2sus" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
          
          <div class="mt-4 text-center">
            <h5 class="text-gold mb-3">Parking Information</h5>
            <p class="text-white">Valet parking available at the front entrance for $15/hour. Several parking garages within a 2-block radius offer discounted rates for salon clients - ask reception for validation.</p>
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