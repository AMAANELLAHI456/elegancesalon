<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Elegance Salon - Premium beauty services with luxury experience">
  <title>Elegance Salon | Luxury Beauty Services</title>
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

    .carousel-caption {
      bottom: 30%;
      text-align: left;
      padding: 30px;
      background: rgba(0, 0, 0, 0.5);
      border-radius: 10px;
      backdrop-filter: blur(5px);
      width: 60%;
      left: 10%;
      right: auto;
    }

    .carousel-caption h5 {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--gold);
      margin-bottom: 20px;
      text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .carousel-caption p {
      font-size: 1.2rem;
      line-height: 1.6;
      margin-bottom: 25px;
    }

    .carousel-item img {
      height: 100vh;
      object-fit: cover;
      width: 100%;
      filter: brightness(0.7);
    }

    .carousel-control-prev,
    .carousel-control-next {
      width: 5%;
    }

    .carousel-indicators button {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      margin: 0 8px;
      background-color: #fff;
      opacity: 0.5;
      transition: all 0.3s;
    }

    .carousel-indicators button.active {
      background-color: var(--gold);
      opacity: 1;
      transform: scale(1.3);
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
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    /* .feature-box:before {
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
    } */

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

    .feature-box ul {
      min-height: 160px;
      margin-bottom: 15px;
      list-style: none;
      padding-left: 0;
      text-align: left;
    }

    .feature-box ul li {
      padding: 5px 0;
    }

    .gallery-item {
      position: relative;
      overflow: hidden;
      border-radius: 10px;
      margin-bottom: 30px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transition: all 0.4s;
    }

    .gallery-item img {
      width: 100%;
      height: 280px;
      object-fit: cover;
      transition: transform 0.5s;
    }

    .gallery-item:hover img {
      transform: scale(1.1);
    }

    .gallery-overlay {
      position: absolute;
      bottom: 0;
      left: 0;
      right: 0;
      background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);
      padding: 20px;
      opacity: 0;
      transition: all 0.3s;
    }

    .gallery-item:hover .gallery-overlay {
      opacity: 1;
    }

    .gallery-overlay h5 {
      color: var(--gold);
      font-weight: 600;
      margin-bottom: 5px;
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

    /* Service Button Styles */
    .service-btn {
      background-color: var(--gold);
      color: var(--black);
      border: none;
      padding: 10px 20px;
      border-radius: 30px;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 1px;
      transition: all 0.3s;
      display: block;
      margin: 15px auto 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-decoration: none;
      font-size: 0.9rem;
      width: 60%;
      max-width: 200px;
      text-align: center;
    }

    .service-btn:hover {
      background-color: var(--dark-gold);
      transform: translateY(-3px);
      box-shadow: 0 6px 12px rgba(255, 215, 0, 0.3);
      color: var(--black);
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
      .carousel-caption {
        width: 80%;
        bottom: 20%;
      }

      .carousel-caption h5 {
        font-size: 2rem;
      }

      .carousel-caption p {
        font-size: 1rem;
      }

      section {
        padding: 80px 0;
      }
      
      .feature-box ul {
        min-height: 140px;
      }
    }

    @media (max-width: 768px) {
      .navbar-brand {
        font-size: 1.5rem;
      }

      .section-title {
        font-size: 2.2rem;
      }

      .carousel-caption {
        width: 90%;
        padding: 20px;
        bottom: 15%;
      }

      .carousel-caption h5 {
        font-size: 1.5rem;
        margin-bottom: 10px;
      }
      
      .feature-box ul {
        min-height: auto;
      }
    }

    @media (max-width: 576px) {
      .carousel-caption {
        bottom: 10%;
        left: 5%;
        width: 90%;
      }

      .carousel-caption h5 {
        font-size: 1.2rem;
      }

      .carousel-caption p {
        font-size: 0.9rem;
        margin-bottom: 15px;
      }

      .section-title {
        font-size: 1.8rem;
      }
      
      .service-btn {
        padding: 8px 15px;
        font-size: 0.8rem;
        width: 70%;
        max-width: 150px;
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

  <!-- Carousel Banner -->
  <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
      <button type="button" data-bs-target="#mainCarousel" data-bs-slide-to="3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="assets/images/salon.jpg" class="d-block w-100" alt="Luxury Salon Interior">
        <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInLeft">
          <h5>Experience Luxury Redefined</h5>
          <p>Step into our elegant space where beauty meets sophistication. Our award-winning salon design creates the perfect ambiance for your transformation.</p>
          <a href="about.php" class="btn btn-gold">Discover More</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/haircut.jpg" class="d-block w-100" alt="Professional Hair Services">
        <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInLeft">
          <h5>Masterful Hair Artistry</h5>
          <p>Our certified stylists create personalized looks using only premium products. From precision cuts to vibrant coloring, we bring your vision to life.</p>
          <a href="contactus.php" class="btn btn-gold">Book Appointment</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/nails.jpg" class="d-block w-100" alt="Luxury Nail Services">
        <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInLeft">
          <h5>Luxury Nail Studio</h5>
          <p>Indulge in our spa manicures and pedicures with organic products. Experience nail art that transforms your hands into works of art.</p>
          <a href="contactus.php" class="btn btn-gold">Book Now</a>
        </div>
      </div>
      <div class="carousel-item">
        <img src="assets/images/client services.png" class="d-block w-100" alt="Personalized Client Services">
        <div class="carousel-caption d-none d-md-block animate__animated animate__fadeInLeft">
          <h5>Personalized Beauty Experience</h5>
          <p>Our client-centric approach ensures every visit is tailored to your unique needs and preferences for exceptional results every time.</p>
          <a href="contactus.php" class="btn btn-gold">Book Appointment</a>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Services Section -->
 <section id="services" class="bg-black py-5">
  <div class="container">
    <h2 class="section-title text-white text-center mb-4 animate__animated animate__fadeInUp">Our Premium Services</h2>
    <p class="text-center text-white mb-5 animate__animated animate__fadeInUp">
      We offer a comprehensive range of beauty services performed by specialists in each field.
    </p>

    <div class="row g-4">
      <!-- Hair Services -->
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-1">
        <div class="feature-box text-white p-3 bg-dark rounded h-100">
          <img src="assets/images/haircut.jpg" alt="Hair Services" class="img-fluid rounded mb-3">
          <h5>Hair Services</h5>
          <ul class="text-start ps-3">
            <li>Precision haircuts & styling</li>
            <li>Balayage & creative coloring</li>
            <li>Keratin treatments</li>
            <li>Extensions & weaves</li>
            <li>Bridal hair design</li>
          </ul>
          <a href="request_appointment.php" class="btn btn-outline-light mt-2">Book Appointment</a>
        </div>
      </div>

      <!-- Nail Studio -->
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-2">
        <div class="feature-box text-white p-3 bg-dark rounded h-100">
          <img src="assets/images/nails.jpg" alt="Nail Services" class="img-fluid rounded mb-3">
          <h5>Nail Studio</h5>
          <ul class="text-start ps-3">
            <li>Luxury manicures</li>
            <li>Spa pedicures</li>
            <li>Gel & acrylic extensions</li>
            <li>Nail art & design</li>
            <li>Medical pedicures</li>
          </ul>
          <a href="request_appointment.php" class="btn btn-outline-light mt-2">Book Appointment</a>
        </div>
      </div>

      <!-- Skin Care -->
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-3">
        <div class="feature-box text-white p-3 bg-dark rounded h-100">
          <img src="assets/images/services.jpg" alt="Skin Care" class="img-fluid rounded mb-3">
          <h5>Skin Care</h5>
          <ul class="text-start ps-3">
            <li>Facials & peels</li>
            <li>Microdermabrasion</li>
            <li>LED light therapy</li>
            <li>Waxing & threading</li>
            <li>Eyelash extensions</li>
          </ul>
          <a href="request_appointment.php" class="btn btn-outline-light mt-2">Book Appointment</a>
        </div>
      </div>

      <!-- Makeup Artistry -->
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-1">
        <div class="feature-box text-white p-3 bg-dark rounded h-100">
          <img src="assets/images/makeover.webp" alt="Makeup Services" class="img-fluid rounded mb-3">
          <h5>Makeup Artistry</h5>
          <ul class="text-start ps-3">
            <li>Bridal makeup</li>
            <li>Editorial makeup</li>
            <li>Special occasion</li>
            <li>Airbrush makeup</li>
            <li>Makeup lessons</li>
          </ul>
          <a href="request_appointment.php" class="btn btn-outline-light mt-2">Book Appointment</a>
        </div>
      </div>

      <!-- Spa Services -->
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-2">
        <div class="feature-box text-white p-3 bg-dark rounded h-100">
          <img src="assets/images/client services.png" alt="Spa Services" class="img-fluid rounded mb-3">
          <h5>Spa Services</h5>
          <ul class="text-start ps-3">
            <li>Massage therapy</li>
            <li>Body treatments</li>
            <li>Aromatherapy</li>
            <li>Detox wraps</li>
            <li>Couples packages</li>
          </ul>
          <a href="request_appointment.php" class="btn btn-outline-light mt-2">Book Appointment</a>
        </div>
      </div>

      <!-- Special Packages -->
      <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-3">
        <div class="feature-box text-white p-3 bg-dark rounded h-100">
          <img src="assets/images/rec1.jpg" alt="Special Packages" class="img-fluid rounded mb-3">
          <h5>Special Packages</h5>
          <ul class="text-start ps-3">
            <li>Complete makeovers</li>
            <li>Bridal packages</li>
            <li>Teen beauty days</li>
            <li>Executive grooming</li>
            <li>Membership programs</li>
          </ul>
          <a href="request_appointment.php" class="btn btn-outline-light mt-2">Book Appointment</a>
        </div>
      </div>
    </div>
  </div>
</section>


  <!-- Features -->
  <section id="features" class="bg-dark">
    <div class="container">
      <h2 class="section-title animate__animated animate__fadeInUp">Why Choose Elegance</h2>
      <p class="text-center text-white mb-5 animate__animated animate__fadeInUp">Our commitment to excellence sets us apart in the beauty industry.</p>
      
      <div class="row g-4">
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-1">
          <div class="feature-box">
            <i class="bi bi-people-fill"></i>
            <h5>Expert Stylists</h5>
            <p>Our team consists of industry-certified professionals with specialized training in their respective fields.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-2">
          <div class="feature-box">
            <i class="bi bi-star-fill"></i>
            <h5>Premium Products</h5>
            <p>We use only top-tier professional products from brands like Oribe, Kerastase, and Dermalogica.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-3">
          <div class="feature-box">
            <i class="bi bi-shield-check"></i>
            <h5>Hygiene First</h5>
            <p>Our salon exceeds all health department requirements with hospital-grade sanitation protocols.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-1">
          <div class="feature-box">
            <i class="bi bi-calendar2-check"></i>
            <h5>Easy Booking</h5>
            <p>Schedule appointments 24/7 through our app, website, or by phone with instant confirmations.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-2">
          <div class="feature-box">
            <i class="bi bi-gem"></i>
            <h5>Luxury Experience</h5>
            <p>From champagne service to massage chairs, we pamper you throughout your visit.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-3">
          <div class="feature-box">
            <i class="bi bi-heart-fill"></i>
            <h5>Personalized Care</h5>
            <p>Customized services based on your unique features, lifestyle, and preferences.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-1">
          <div class="feature-box">
            <i class="bi bi-award-fill"></i>
            <h5>Quality Guarantee</h5>
            <p>Not satisfied? We'll make it right. Your happiness is our priority.</p>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-3 animate__animated animate__fadeInUp animate-delay-2">
          <div class="feature-box">
            <i class="bi bi-coin"></i>
            <h5>Loyalty Rewards</h5>
            <p>Earn points with every visit redeemable for services, products, or discounts.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery -->
  <section id="gallery" class="bg-black">
    <div class="container">
      <h2 class="section-title animate__animated animate__fadeInUp">Our Salon Gallery</h2>
      <p class="text-center text-white mb-5 animate__animated animate__fadeInUp">Take a virtual tour of our luxurious space and see our work.</p>
      
      <div class="row g-4">
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-1">
          <div class="gallery-item">
            <img src="assets/images/salon.jpg" alt="Salon Interior">
            <div class="gallery-overlay">
              <h5>Main Salon Area</h5>
              <p class="text-white">Our spacious styling stations with premium equipment</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-2">
          <div class="gallery-item">
            <img src="assets/images/serv1.jpg" alt="Service Area">
            <div class="gallery-overlay">
              <h5>Color Bar</h5>
              <p class="text-white">Specialized area for custom color formulations</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-3">
          <div class="gallery-item">
            <img src="assets/images/rec1.jpg" alt="Reception Area">
            <div class="gallery-overlay">
              <h5>Reception Lounge</h5>
              <p class="text-white">Relax in our comfortable waiting area</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-1">
          <div class="gallery-item">
            <img src="assets/images/haircut.jpg" alt="Hair Services">
            <div class="gallery-overlay">
              <h5>Hair Services</h5>
              <p class="text-white">Precision cutting and styling in action</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-2">
          <div class="gallery-item">
            <img src="assets/images/nails.jpg" alt="Nail Services">
            <div class="gallery-overlay">
              <h5>Nail Studio</h5>
              <p class="text-white">Luxury manicures and pedicures</p>
            </div>
          </div>
        </div>
        
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp animate-delay-3">
          <div class="gallery-item">
            <img src="assets/images/makeover.webp" alt="Makeup Services">
            <div class="gallery-overlay">
              <h5>Makeup Studio</h5>
              <p class="text-white">Professional makeup application area</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section id="testimonials" class="bg-dark">
    <div class="container">
      <h2 class="section-title animate__animated animate__fadeInUp">Client Testimonials</h2>
      <p class="text-center text-white mb-5 animate__animated animate__fadeInUp">Hear what our clients say about their experiences.</p>
      
      <div class="row">
        <div class="col-lg-8 mx-auto">
          <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <div class="testimonial-box p-4 p-lg-5 text-center">
                  <img src="assets/images/bride1.jpg" alt="Client" class="rounded-circle mb-4" width="100">
                  <p class="text-white mb-4">"Elegance Salon transformed my look for my wedding day. The team listened to my vision and executed it perfectly. I felt like the best version of myself!"</p>
                  <h5 class="text-gold mb-1">Sarah Johnson</h5>
                  <p class="text-muted">Bride</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial-box p-4 p-lg-5 text-center">
                  <img src="assets/images/black.jpg" alt="Client" class="rounded-circle mb-4" width="100">
                  <p class="text-white mb-4">"As someone with curly hair, I've struggled to find stylists who understand texture. The curl specialist at Elegance gave me the best cut of my life!"</p>
                  <h5 class="text-gold mb-1">Michael Chen</h5>
                  <p class="text-muted">Regular Client</p>
                </div>
              </div>
              <div class="carousel-item">
                <div class="testimonial-box p-4 p-lg-5 text-center">
                  <img src="assets/images/client services.png" alt="Client" class="rounded-circle mb-4" width="100">
                  <p class="text-white mb-4">"The spa pedicure is worth every penny. My feet have never felt better, and the nail art lasted perfectly for three weeks. Pure luxury!"</p>
                  <h5 class="text-gold mb-1">Emily Rodriguez</h5>
                  <p class="text-muted">Spa Enthusiast</p>
                </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
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
              <li><a href="#services">Hair</a></li>
              <li><a href="#services">Nails</a></li>
              <li><a href="#services">Skin Care</a></li>
              <li><a href="#services">Makeup</a></li>
              <li><a href="#services">Spa</a></li>
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