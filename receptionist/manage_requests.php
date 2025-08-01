<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/receptionheader.php';


// Fetch booked appointments with client and service details
$query = "SELECT a.appointment_id, c.name AS client_name, s.service_name, 
          a.appointment_time, a.status, u.name AS stylist_name, a.appointment_cost
          FROM appointments a
          JOIN clients c ON a.client_id = c.client_id
          JOIN services s ON a.service_id = s.service_id
          JOIN users u ON a.stylist_id = u.user_id
          WHERE a.status = 'booked'";

$result = mysqli_query($conn, $query);

// Fetch upcoming appointments
$upcomingQuery = "SELECT a.appointment_id, c.name AS client_name, s.service_name, 
                  a.appointment_time, u.name AS stylist_name
                  FROM appointments a
                  JOIN clients c ON a.client_id = c.client_id
                  JOIN services s ON a.service_id = s.service_id
                  JOIN users u ON a.stylist_id = u.user_id
                  WHERE a.status = 'booked'
                  ORDER BY a.appointment_time ASC
                  LIMIT 3";
$upcomingResult = mysqli_query($conn, $upcomingQuery);

// Fetch recent payments
$paymentQuery = "SELECT p.amount, p.payment_date, c.name AS client_name 
                FROM payments p
                JOIN appointments a ON p.appointment_id = a.appointment_id
                JOIN clients c ON a.client_id = c.client_id
                ORDER BY p.payment_date DESC 
                LIMIT 3";
$paymentResult = mysqli_query($conn, $paymentQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon | Receptionist Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #0F0F0F;
            --darker-gray: #1A1A1A;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7)), 
                              radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
            min-height: 100vh;
        }
        
        .navbar {
            background: rgba(15, 15, 15, 0.95);
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
        }
        
        .navbar-brand {
            color: var(--gold) !important;
            font-weight: 600;
            letter-spacing: 1px;
        }
        
        .dashboard-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .dashboard-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -10%;
            width: 120%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.05), transparent);
            z-index: -1;
        }
        
        .dashboard-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }
        
        .dashboard-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--gold);
        }
        
        .card {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(5px);
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }
        
        .card:hover {
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.15);
            border-color: rgba(212, 175, 55, 0.3);
            transform: translateY(-5px);
        }
        
        .card-header {
            background: rgba(30, 30, 30, 0.9);
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding: 1.2rem 1.5rem;
            color: var(--gold);
            font-weight: 500;
            letter-spacing: 0.8px;
        }
        
        .table-container {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }
        
        .table {
            color: var(--light-gray);
            margin-bottom: 0;
        }
        
        .table-dark {
            background: transparent !important;
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(30, 30, 30, 0.9) !important;
            padding: 1.2rem 1rem;
        }
        
        .table th:first-child {
            border-radius: 10px 0 0 0;
        }
        
        .table th:last-child {
            border-radius: 0 10px 0 0;
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(212, 175, 55, 0.05) !important;
        }
        
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
            border: none;
            color: var(--black);
            font-weight: 500;
            letter-spacing: 0.8px;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border-radius: 6px;
            text-transform: uppercase;
            font-size: 0.85rem;
            margin-right: 0.5rem;
            min-width: 100px;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
            color: var(--black);
        }
        
        .btn-gold::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .btn-gold:hover::after {
            left: 100%;
        }
        
        .btn-outline-gold {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            transition: all 0.3s ease;
            padding: 0.6rem 1.2rem;
            border-radius: 6px;
            text-transform: uppercase;
            font-size: 0.85rem;
            min-width: 100px;
        }
        
        .btn-outline-gold:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            transform: translateY(-2px);
        }
        
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 50px;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.8px;
        }
        
        .badge-booked {
            background: rgba(0, 123, 255, 0.2);
            color: #007bff;
            border: 1px solid rgba(0, 123, 255, 0.3);
        }
        
        .badge-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }
        
        .stat-card {
            text-align: center;
            padding: 1.5rem;
        }
        
        .stat-value {
            font-size: 2.5rem;
            font-weight: 300;
            color: var(--gold);
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        .footer {
            background: rgba(15, 15, 15, 0.95);
            border-top: 1px solid rgba(212, 175, 55, 0.3);
            padding: 1.5rem 0;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .table thead {
                display: none;
            }
            
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            
            .table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(212, 175, 55, 0.2);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            .table td:last-child {
                border-bottom: none;
            }
            
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: calc(50% - 1rem);
                padding-right: 10px;
                text-align: left;
                font-weight: 500;
                color: var(--gold);
            }
            
            .action-buttons {
                display: flex;
                justify-content: flex-end;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
   
    <!-- Main Content -->
    <div class="container py-4">
        <div class="dashboard-header">
            <h1 class="dashboard-title"><i class="fas fa-calendar-check me-2"></i>Appointment Requests</h1>
            <p class="text-muted mt-2">Review and manage pending appointment requests</p>
        </div>
        
        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="stat-value"><?= mysqli_num_rows($result) ?></div>
                    <div class="stat-label">Pending Requests</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="stat-value"><?= date('d') ?></div>
                    <div class="stat-label">Today's Appointments</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="stat-value">14</div>
                    <div class="stat-label">Available Stylists</div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card stat-card">
                    <div class="stat-value">96%</div>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
        
        <!-- Appointment Requests Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Stylist</th>
                            <th>Date & Time</th>
                            <th>Cost (PKR)</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td data-label="ID">#<?= $row['appointment_id'] ?></td>
                                <td data-label="Client"><?= htmlspecialchars($row['client_name']) ?></td>
                                <td data-label="Service"><?= htmlspecialchars($row['service_name']) ?></td>
                                <td data-label="Stylist"><?= htmlspecialchars($row['stylist_name']) ?></td>
                                <td data-label="Date & Time">
                                    <?= date('M j, Y', strtotime($row['appointment_time'])) ?><br>
                                    <small><?= date('g:i A', strtotime($row['appointment_time'])) ?></small>
                                </td>
                                <td data-label="Cost"><?= number_format($row['appointment_cost'], 2) ?></td>
                                <td data-label="Status">
                                    <span class="status-badge badge-booked"><?= ucfirst($row['status']) ?></span>
                                </td>
                                <td data-label="Actions" class="action-buttons">
                                    <a href="approve_appointment.php?id=<?= $row['appointment_id'] ?>" class="btn btn-gold">
                                        <i class="fas fa-check me-1"></i>Approve
                                    </a>
                                    <a href="reject_appointment.php?id=<?= $row['appointment_id'] ?>" class="btn btn-outline-gold">
                                        <i class="fas fa-times me-1"></i>Reject
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Additional Cards -->
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-clock me-2"></i>Upcoming Appointments
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php while ($row = mysqli_fetch_assoc($upcomingResult)): ?>
                            <li class="list-group-item bg-transparent text-light border-secondary">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($row['client_name']) ?></h6>
                                        <small class="text-muted"><?= htmlspecialchars($row['service_name']) ?></small>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block"><?= date('M j', strtotime($row['appointment_time'])) ?></span>
                                        <small class="text-muted"><?= date('g:i A', strtotime($row['appointment_time'])) ?></small>
                                    </div>
                                </div>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-header">
                        <i class="fas fa-money-bill-wave me-2"></i>Recent Payments
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php while ($payment = mysqli_fetch_assoc($paymentResult)): ?>
                            <li class="list-group-item bg-transparent text-light border-secondary">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($payment['client_name']) ?></h6>
                                        <small class="text-success"><?= number_format($payment['amount'], 2) ?> PKR</small>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block"><?= date('M j', strtotime($payment['payment_date'])) ?></span>
                                        <small class="text-muted"><?= date('g:i A', strtotime($payment['payment_date'])) ?></small>
                                    </div>
                                </div>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">
                <i class="fas fa-copyright me-1"></i> 2025 Elegance Salon. All rights reserved.
            </p>
            <p class="mb-0">
                <i class="fas fa-map-marker-alt me-1"></i> 123 Luxury Avenue, Beverly Hills, CA 90210
                <span class="mx-2">|</span>
                <i class="fas fa-phone me-1"></i> (555) 123-4567
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>