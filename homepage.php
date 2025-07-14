<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

  <style>
    :root {
      --gold: #D4AF37;
      --black: #121212;
      --dark-gray: #1a1a1a;
      --text-light: #f2f2f2;
    }

    body {
      background: var(--black);
      color: var(--text-light);
      font-family: 'Montserrat', sans-serif;
    }

    .navbar {
      background-color: var(--dark-gray);
      border-bottom: 1px solid var(--gold);
    }

    .navbar-brand {
      color: var(--gold);
      font-weight: bold;
      letter-spacing: 1px;
    }

    .nav-link {
      color: var(--text-light);
    }

    .nav-link:hover {
      color: var(--gold);
    }

    .hero {
      background: url('hero-placeholder.jpg') center/cover no-repeat;
      background-color: rgba(0,0,0,0.6);
      background-blend-mode: multiply;
      height: 90vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      text-align: center;
      color: var(--text-light);
      padding: 0 20px;
    }

    .hero h1 {
      font-size: 3rem;
      color: var(--gold);
      font-weight: bold;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 700px;
      margin: auto;
    }

    .section {
      padding: 60px 20px;
    }

    .section h2 {
      color: var(--gold);
      font-weight: 600;
      margin-bottom: 20px;
      border-left: 5px solid var(--gold);
      padding-left: 15px;
    }

    .feature-box {
      background: var(--dark-gray);
      padding: 25px;
      border: 1px solid rgba(212,175,55,0.2);
      border-radius: 10px;
      transition: 0.3s ease;
    }

    .feature-box:hover {
      border-color: var(--gold);
      box-shadow: 0 0 15px rgba(212,175,55,0.1);
    }

    .feature-box i {
      font-size: 2rem;
      color: var(--gold);
      margin-bottom: 10px;
    }

    .gallery img {
      width: 100%;
      height: 250px;
      object-fit: cover;
      border-radius: 8px;
      border: 2px solid var(--gold);
    }

    footer {
      background: var(--dark-gray);
      color: #999;
      text-align: center;
      padding: 20px 10px;
      border-top: 1px solid rgba(212,175,55,0.2);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-crown me-2"></i>Elegance Salon</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Appointments</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Clients</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Inventory</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero">
    <h1>Elegance in Every Detail</h1>
    <p>Streamline your beauty business with modern salon management features — elegant, efficient, and effortless.</p>
  </section>

  <!-- About Section -->
  <section class="section container">
    <h2>About the Project</h2>
    <p>
      Elegance Salon is a complete digital platform designed to simplify daily operations of salons like appointments, inventory, and staff scheduling.
      This management system increases efficiency, enhances customer experience, and keeps everything organized — all in a beautiful black and gold interface.
    </p>
  </section>

  <!-- Features -->
  <section class="section container">
    <h2>Key Features</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-box text-center">
          <i class="fas fa-calendar-check"></i>
          <h5 class="mt-3">Appointment Booking</h5>
          <p>Book, cancel or reschedule with automated notifications.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box text-center">
          <i class="fas fa-user-friends"></i>
          <h5 class="mt-3">Client Profiles</h5>
          <p>Track preferences, visit history, and feedback.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box text-center">
          <i class="fas fa-box-open"></i>
          <h5 class="mt-3">Inventory Alerts</h5>
          <p>Get notified for low stock and auto-generate orders.</p>
        </div>
      </div>
    </div>
    <div class="row g-4 mt-3">
      <div class="col-md-4">
        <div class="feature-box text-center">
          <i class="fas fa-users-cog"></i>
          <h5 class="mt-3">Staff Management</h5>
          <p>Assign shifts, calculate commissions, and track performance.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box text-center">
          <i class="fas fa-chart-line"></i>
          <h5 class="mt-3">Reports & Analytics</h5>
          <p>Understand trends in sales, service demand, and hours.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box text-center">
          <i class="fas fa-envelope-open-text"></i>
          <h5 class="mt-3">Notifications</h5>
          <p>Stay updated with reminders for appointments & tasks.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Gallery -->
  <section class="section container">
    <h2>Gallery</h2>
    <div class="row g-3">
      <div class="col-md-4"><img src="assets/images/salon.jpg" alt="Salon Interior" class="img-fluid gallery"></div>
      <div class="col-md-4"><img src="assets/images/serv1.jpg" alt="Client Services" class="img-fluid gallery"></div>
      <div class="col-md-4"><img src="assets/images/rec1.jpg" alt="Reception Desk" class="img-fluid gallery"></div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>&copy; <?= date('Y') ?> Elegance Salon | Developed by [Your Company/Name]</p>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
