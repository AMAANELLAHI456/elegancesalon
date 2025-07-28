<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/adminheader.php';

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $delete_sql = "DELETE FROM appointments WHERE appointment_id = '$delete_id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Appointment deleted successfully";
        header("Location: appointments.php");
        exit;
    } else {
        $_SESSION['error'] = "Error deleting appointment: " . mysqli_error($conn);
    }
}

// Fetch all appointments with related data
$sql = "SELECT a.appointment_id, a.appointment_time, a.status, a.appointment_cost,
               c.name AS client_name, c.phone AS client_phone,
               s.service_name, s.price AS service_price,
               u.name AS stylist_name
        FROM appointments a
        JOIN clients c ON a.client_id = c.client_id
        JOIN services s ON a.service_id = s.service_id
        LEFT JOIN users u ON a.stylist_id = u.user_id
        ORDER BY a.appointment_time DESC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments Management | Elegance Salon</title>
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
        
        .services-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .services-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .form-container {
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .form-label {
            color: var(--gold);
            font-weight: 400;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            padding: 0.5rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--gold);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15);
        }
        
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
            border: none;
            color: var(--black);
            font-weight: 500;
            letter-spacing: 0.8px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
        }
        
        .btn-warning {
            background: rgba(212, 175, 55, 0.8);
            border: none;
            color: var(--black);
        }
        
        .btn-warning:hover {
            background: var(--gold);
        }
        
        .table-container {
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .table {
            color: var(--light-gray);
            margin-bottom: 0;
            background: var(--black);
        }
        
        .table-dark {
            background: rgba(212, 175, 55, 0.1) !important;
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-color: rgba(212, 175, 55, 0.3);
            background: var(--black) !important;
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
            background: var(--black);
        }
        
        .rupee-symbol {
            color: var(--gold);
            font-weight: 500;
        }
        
        .action-buttons .btn {
            margin-right: 0.5rem;
        }
        
        .action-buttons .btn:last-child {
            margin-right: 0;
        }
        
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
        
        .badge {
            padding: 0.5em 0.75em;
            font-weight: 500;
        }
        
        .badge.completed {
            background-color: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }
        
        .badge.pending {
            background-color: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }
        
        .badge.cancelled {
            background-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }
    </style>
</head>
<body style="background: var(--black);">
    <?php include '../includes/header.php'; ?>
    
    <div class="container py-4" style="background: var(--black);">
        <div class="services-header">
            <h1 class="services-title"><i class="fas fa-calendar-alt me-2"></i>Appointments Management</h1>
        </div>

        <!-- Add New Appointment Button -->
        <div class="d-flex justify-content-end mb-4">
            <a href="add_appointment.php" class="btn btn-gold">
                <i class="fas fa-plus me-2"></i>Add New Appointment
            </a>
        </div>

        <!-- Display messages -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4">
                <i class="fas fa-check-circle me-2"></i><?= $_SESSION['message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4">
                <i class="fas fa-exclamation-circle me-2"></i><?= $_SESSION['error']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                <?php unset($_SESSION['error']); ?>
            </div>
        <?php endif; ?>

        <!-- Appointments Table -->
        <div class="table-container" style="background: var(--black);">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Stylist</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr style="background: var(--black);">
                            <td><?= htmlspecialchars($row['appointment_id']) ?></td>
                            <td>
                                <strong><?= htmlspecialchars($row['client_name']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($row['client_phone']) ?></small>
                            </td>
                            <td>
                                <?= htmlspecialchars($row['service_name']) ?><br>
                                <small class="text-muted">Rs. <?= number_format($row['service_price'], 2) ?></small>
                            </td>
                            <td><?= htmlspecialchars($row['stylist_name'] ?? 'Not assigned') ?></td>
                            <td><?= date('M j, Y g:i A', strtotime($row['appointment_time'])) ?></td>
                            <td>
                                <span class="badge <?= $row['status'] ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td><span class="rupee-symbol">Rs.</span> <?= number_format($row['appointment_cost'], 2) ?></td>
                            <td class="action-buttons">
                                <a href="edit_appointment.php?id=<?= $row['appointment_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="appointments.php?delete_id=<?= $row['appointment_id'] ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this appointment?')">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>