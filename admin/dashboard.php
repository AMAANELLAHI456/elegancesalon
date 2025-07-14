<?php
// Start session and include database/auth
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Check if user is logged in and is an admin (role_id = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Count total clients
$client_result = mysqli_query($conn, "SELECT COUNT(*) AS total_clients FROM Clients");
$client_data = mysqli_fetch_assoc($client_result);

// Count total services
$service_result = mysqli_query($conn, "SELECT COUNT(*) AS total_services FROM Services");
$service_data = mysqli_fetch_assoc($service_result);

// Count today's appointments
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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #121212;
            --dark-gray: #1E1E1E;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
        }
        
        .navbar {
            background: var(--dark-gray) !important;
            border-bottom: 1px solid var(--gold);
        }
        
        .navbar-brand {
            color: var(--gold) !important;
            font-weight: 500;
            letter-spacing: 1px;
        }
        
        .nav-link {
            color: var(--light-gray) !important;
        }
        
        .nav-link:hover {
            color: var(--gold) !important;
        }
        
        .dashboard-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .dashboard-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .stat-card {
            background: var(--dark-gray);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.1);
            border-color: var(--gold);
        }
        
        .stat-card .card-title {
            color: var(--gold);
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .stat-card .card-text {
            color: white;
            font-size: 2rem;
            font-weight: 300;
        }
        
        .btn-outline-gold {
            color: var(--gold);
            border-color: var(--gold);
            background: transparent;
            transition: all 0.3s ease;
        }
        
        .btn-outline-gold:hover {
            background: var(--gold);
            color: var(--black);
        }
        
        .quick-nav {
            margin-top: 2rem;
        }
        
        .quick-nav .btn {
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }
        
        footer {
            background: var(--dark-gray);
            border-top: 1px solid rgba(212, 175, 55, 0.3);
            padding: 1.5rem 0;
            margin-top: 3rem;
        }
        
        .client-card {
            background: rgba(212, 175, 55, 0.05);
            border-left: 3px solid var(--gold);
        }
        
        .appt-card {
            background: rgba(23, 162, 184, 0.05);
            border-left: 3px solid #17a2b8;
        }
        
        .service-card {
            background: rgba(40, 167, 69, 0.05);
            border-left: 3px solid #28a745;
        }
        .a23{
         text-color : var(--gold);
         font-weight: 500;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-crown me-2"></i>Elegance Salon
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="dashboard.php"><i class="fas fa-tachometer-alt me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="clients.php"><i class="fas fa-users me-1"></i> Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="appointments.php"><i class="fas fa-calendar-alt me-1"></i> Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php"><i class="fas fa-sign-out-alt me-1"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="dashboard-header a23" >
            <h1 class="dashboard-title"><i class="fas fa-tachometer-alt me-2"></i>Admin Dashboard</h1>
            <p class=>Welcome back, <?= htmlspecialchars($_SESSION['name']) ?></p>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4">
            <!-- Total Clients -->
            <div class="col-md-4">
                <div class="stat-card client-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Clients</h5>
                            <p class="card-text"><?= $client_data['total_clients'] ?></p>
                        </div>
                        <i class="fas fa-users fa-3x" style="color: rgba(212, 175, 55, 0.3);"></i>
                    </div>
                </div>
            </div>

            <!-- Today's Appointments -->
            <div class="col-md-4">
                <div class="stat-card appt-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Today's Appointments</h5>
                            <p class="card-text"><?= $appt_data['total_appts'] ?></p>
                        </div>
                        <i class="fas fa-calendar-day fa-3x" style="color: rgba(23, 162, 184, 0.3);"></i>
                    </div>
                </div>
            </div>

            <!-- Total Services -->
            <div class="col-md-4">
                <div class="stat-card service-card p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title">Total Services</h5>
                            <p class="card-text"><?= $service_data['total_services'] ?></p>
                        </div>
                        <i class="fas fa-spa fa-3x" style="color: rgba(40, 167, 69, 0.3);"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Navigation -->
        <div class="row quick-nav g-4">
            <div class="col-md-3">
                <a href="services.php" class="btn btn-outline-gold w-100">
                    <i class="fas fa-spa me-2"></i>Manage Services
                </a>
            </div>
            <div class="col-md-3">
                <a href="inventory.php" class="btn btn-outline-gold w-100">
                    <i class="fas fa-boxes me-2"></i>Manage Inventory
                </a>
            </div>
            <div class="col-md-3">
                <a href="staff_schedule.php" class="btn btn-outline-gold w-100">
                    <i class="fas fa-clipboard-list me-2"></i>Staff Schedule
                </a>
            </div>
            <div class="col-md-3">
                <a href="reports.php" class="btn btn-outline-gold w-100">
                    <i class="fas fa-chart-bar me-2"></i>View Reports
                </a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; <?= date('Y') ?> Elegance Salon. All rights reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>