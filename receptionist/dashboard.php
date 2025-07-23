<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Count total appointments
$appt_result = mysqli_query($conn, "SELECT COUNT(*) AS total_appts FROM appointments");
$appt_data = mysqli_fetch_assoc($appt_result);

// Count total clients
$client_result = mysqli_query($conn, "SELECT COUNT(*) AS total_clients FROM clients");
$client_data = mysqli_fetch_assoc($client_result);

// Count pending payments
$pending_payments_result = mysqli_query($conn, "SELECT COUNT(*) AS total_pending FROM payments WHERE status = 'Pending'");
$pending_payments_data = mysqli_fetch_assoc($pending_payments_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000;
            --darker-gray: #121212;
            --light-gray: #E0E0E0;
        }
        
        body {
            background-color: var(--black) !important;
            color: var(--light-gray);
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
            background-color: var(--black);
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
            background-color: var(--black);
        }
        
        .logo {
            height: 80px;
            width: auto;
            margin-bottom: 1rem;
        }
        
        .dashboard-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            text-align: center;
            margin-bottom: 2rem;
            background-color: var(--black);
        }
        
        .welcome-text {
            color: var(--light-gray);
            text-align: center;
            opacity: 0.8;
            margin-bottom: 3rem;
            background-color: var(--black);
        }
        
        .stat-card {
            background: var(--darker-gray);
            border: 1px solid rgba(212, 175, 55, 0.3);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(212, 175, 55, 0.1);
            border-color: var(--gold);
        }
        
        .stat-icon {
            color: var(--gold);
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        
        .stat-title {
            color: var(--gold);
            font-size: 1rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
        }
        
        .stat-value {
            color: white;
            font-size: 2.2rem;
            font-weight: 300;
        }
        
        .stat-detail {
            color: var(--light-gray);
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        .nav-btn {
            background: var(--darker-gray);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            color: var(--light-gray);
            display: block;
            text-decoration: none;
        }
        
        .nav-btn:hover {
            border-color: var(--gold);
            transform: translateY(-3px);
            color: var(--gold);
        }
        
        .nav-icon {
            color: var(--gold);
            font-size: 1.8rem;
            margin-bottom: 1rem;
        }
        
        /* Ensure header and footer are also black */
        header, footer {
            background-color: var(--black) !important;
            border-color: var(--dark-gold) !important;
        }
    </style>
</head>
<body style="background-color: var(--black);">
    <?php include '../includes/header.php'; ?>
    
    <div class="dashboard-container">
        <!-- Logo and Header -->
        <div class="logo-container">
            <img src="../assets/images/salonlogo.jpg" alt="Elegance Salon" class="logo" onerror="this.src='../assets/images/default-logo.jpg'">
            <h1 class="dashboard-title">Receptionist Dashboard</h1>
            <p class="welcome-text">Welcome back, <?= htmlspecialchars($_SESSION['name']) ?></p>
        </div>

        <!-- Stats Row -->
        <div class="row">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5 class="stat-title">Total Appointments</h5>
                    <p class="stat-value"><?= $appt_data['total_appts'] ?></p>
                    <p class="stat-detail">All booked appointments</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5 class="stat-title">Total Clients</h5>
                    <p class="stat-value"><?= $client_data['total_clients'] ?></p>
                    <p class="stat-detail">Registered clients</p>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </div>
                    <h5 class="stat-title">Pending Payments</h5>
                    <p class="stat-value"><?= $pending_payments_data['total_pending'] ?></p>
                    <p class="stat-detail">Awaiting completion</p>
                </div>
            </div>
        </div>

        <!-- Quick Access Buttons -->
        <div class="row mt-4">
            <div class="col-md-4">
                <a href="appointments.php" class="nav-btn">
                    <div class="nav-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <h6 class="nav-title">Manage Appointments</h6>
                </a>
            </div>
            
            <div class="col-md-4">
                <a href="clients.php" class="nav-btn">
                    <div class="nav-icon">
                        <i class="fas fa-user-friends"></i>
                    </div>
                    <h6 class="nav-title">Manage Clients</h6>
                </a>
            </div>
            
            <div class="col-md-4">
                <a href="payments.php" class="nav-btn">
                    <div class="nav-icon">
                        <i class="fas fa-credit-card"></i>
                    </div>
                    <h6 class="nav-title">Manage Payments</h6>
                </a>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>