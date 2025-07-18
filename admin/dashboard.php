<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Fetch data
$client_result = mysqli_query($conn, "SELECT COUNT(*) AS total_clients FROM Clients");
$client_data = mysqli_fetch_assoc($client_result);

$service_result = mysqli_query($conn, "SELECT COUNT(*) AS total_services FROM Services");
$service_data = mysqli_fetch_assoc($service_result);

$today = date('Y-m-d');
$appt_result = mysqli_query($conn, "SELECT COUNT(*) AS total_appts FROM Appointments WHERE DATE(appointment_time) = '$today'");
$appt_data = mysqli_fetch_assoc($appt_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #FFD700;
      --black: #000;
      --light: #eeeeee;
    }

    body {
      background-color: var(--black);
      color: var(--light);
      font-family: Arial, sans-serif;
      padding: 20px;
    }

    .dashboard-container {
      max-width: 1200px;
      margin: 0 auto;
    }

    .logo {
      height: 80px;
      display: block;
      margin: 0 auto 20px;
    }

    .dashboard-title {
      text-align: center;
      color: var(--gold);
      margin-bottom: 30px;
    }

    .stat-card, .nav-card {
      background: rgba(30, 30, 30, 0.8);
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      text-align: center;
      transition: all 0.3s ease;
    }

    .stat-card:hover, .nav-card:hover {
      border-color: var(--gold);
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
    }

    .stat-icon, .nav-icon {
      font-size: 24px;
      color: var(--gold);
      margin-bottom: 10px;
    }

    .stat-value {
      font-size: 28px;
      color: var(--gold);
      margin: 10px 0;
    }

    .stat-title, .nav-title {
      font-size: 16px;
      color: var(--light);
    }

    a.nav-card {
      display: block;
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <img src="../assets/images/salonlogo.jpg" alt="Elegance Salon" class="logo">
    <h1 class="dashboard-title">Admin Dashboard</h1>

    <!-- Stats -->
    <div class="row">
      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-users"></i></div>
          <div class="stat-value"><?= $client_data['total_clients'] ?></div>
          <div class="stat-title">Total Clients</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
          <div class="stat-value"><?= $appt_data['total_appts'] ?></div>
          <div class="stat-title">Today's Appointments</div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-spa"></i></div>
          <div class="stat-value"><?= $service_data['total_services'] ?></div>
          <div class="stat-title">Total Services</div>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <div class="row">
      <div class="col-md-3 col-6">
        <a href="clients.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-users"></i></div>
          <div class="nav-title">Clients</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="appointments.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-calendar-alt"></i></div>
          <div class="nav-title">Appointments</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="services.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-spa"></i></div>
          <div class="nav-title">Services</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="inventory.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-boxes"></i></div>
          <div class="nav-title">Inventory</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="staff_schedule.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-clipboard-list"></i></div>
          <div class="nav-title">Staff Schedule</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="reports.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-chart-bar"></i></div>
          <div class="nav-title">Reports</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="users.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-user-cog"></i></div>
          <div class="nav-title">Manage Users</div>
        </a>
      </div>
      <div class="col-md-3 col-6">
        <a href="view_feedback.php" class="nav-card">
          <div class="nav-icon"><i class="fas fa-comment-dots"></i></div>
          <div class="nav-title">View Feedback</div>
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>