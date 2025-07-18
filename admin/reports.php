<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Fetch report data
$total_clients_query = "SELECT COUNT(*) AS total_clients FROM clients";
$total_clients_result = mysqli_query($conn, $total_clients_query);
$total_clients = mysqli_fetch_assoc($total_clients_result)['total_clients'];

$total_appointments_query = "SELECT COUNT(*) AS total_appointments FROM appointments";
$total_appointments_result = mysqli_query($conn, $total_appointments_query);
$total_appointments = mysqli_fetch_assoc($total_appointments_result)['total_appointments'];

$total_revenue_query = "SELECT SUM(appointment_cost) AS total_revenue FROM appointments";
$total_revenue_result = mysqli_query($conn, $total_revenue_query);
$total_revenue = mysqli_fetch_assoc($total_revenue_result)['total_revenue'];

$top_services_query = "SELECT s.service_name, COUNT(a.service_id) AS count
                       FROM appointments a
                       JOIN services s ON a.service_id = s.service_id
                       GROUP BY a.service_id
                       ORDER BY count DESC
                       LIMIT 5";
$top_services_result = mysqli_query($conn, $top_services_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports Dashboard | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000;
            --darker-gray: #121212;
            --dark-gray: #1E1E1E;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        
        .container {
            background: var(--black);
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
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card h5 {
            color: var(--gold);
            font-weight: 400;
            margin-bottom: 1rem;
        }
        
        .stat-card .stat-value {
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--light-gray);
        }
        
        .report-card {
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            margin-bottom: 2rem;
        }
        
        .report-card-header {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            font-weight: 500;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        .list-group-item {
            background: var(--black);
            color: var(--light-gray);
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem 1.5rem;
        }
        
        .badge-gold {
            background: rgba(212, 175, 55, 0.2);
            color: var(--gold);
            font-weight: 500;
            padding: 0.35rem 0.75rem;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .rupee-symbol {
            color: var(--gold);
            font-weight: 500;
        }
        
        .card-icon {
            color: var(--gold);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        /* Ensure header and footer also use black background */
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body style="background: var(--black);">
    <?php include '../includes/header.php'; ?>
    
    <div class="container py-4" style="background: var(--black);">
        <div class="dashboard-header">
            <h1 class="dashboard-title"><i class="fas fa-chart-line me-2"></i>Reports Dashboard</h1>
        </div>

        <div class="row mt-4">
            <div class="col-md-4 mb-4">
                <div class="stat-card" style="background: var(--black);">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h5>Total Clients</h5>
                    <p class="stat-value"><?= $total_clients ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card" style="background: var(--black);">
                    <div class="card-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h5>Total Appointments</h5>
                    <p class="stat-value"><?= $total_appointments ?></p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card" style="background: var(--black);">
                    <div class="card-icon">
                        <i class="fas fa-rupee-sign"></i>
                    </div>
                    <h5>Total Revenue</h5>
                    <p class="stat-value"><span class="rupee-symbol">Rs.</span> <?= number_format($total_revenue ?? 0, 2) ?></p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-6">
                <div class="report-card" style="background: var(--black);">
                    <div class="report-card-header">
                        <i class="fas fa-star me-2"></i>Top Services
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php 
                        mysqli_data_seek($top_services_result, 0); // Reset pointer
                        while($service = mysqli_fetch_assoc($top_services_result)): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center" style="background: var(--black);">
                                <?= htmlspecialchars($service['service_name']) ?>
                                <span class="badge badge-gold rounded-pill"><?= $service['count'] ?></span>
                            </li>
                        <?php endwhile; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>