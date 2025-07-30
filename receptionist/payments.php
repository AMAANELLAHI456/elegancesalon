<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/receptionheader.php';
// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Fetch payments with appointment, client, and method
$query = "SELECT p.payment_id, c.name AS client_name, p.amount, p.payment_date, p.method 
          FROM payments p
          JOIN appointments a ON p.appointment_id = a.appointment_id
          JOIN clients c ON a.client_id = c.client_id
          ORDER BY p.payment_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments Management | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000;
            --light-gray: #E0E0E0;
        }
        
        body {
            background-color: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', sans-serif;
        }
        
        .header-section {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .page-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
            border: none;
            color: var(--black);
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
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
        }
        
        .table-dark {
            background: rgba(212, 175, 55, 0.1) !important;
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            border-color: rgba(212, 175, 55, 0.3);
            background: var(--black) !important;
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
        }
        
        .action-buttons .btn {
            margin-right: 0.5rem;
        }
        
        .btn-warning {
            background: rgba(212, 175, 55, 0.8);
            border: none;
            color: var(--black);
        }
        
        .btn-warning:hover {
            background: var(--gold);
        }
        
        .btn-danger {
            background: rgba(220, 53, 69, 0.8);
            border: none;
        }
        
        .btn-danger:hover {
            background: #dc3545;
        }
        
        .rupee-symbol {
            color: var(--gold);
            font-weight: 500;
        }
    </style>
</head>
<body style="background: var(--black);">
    
    
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center header-section">
            <h1 class="page-title"><i class="fas fa-credit-card me-2"></i>Payments Management</h1>
            <a href="add_payment.php" class="btn btn-gold">
                <i class="fas fa-plus me-2"></i>Add Payment
            </a>
        </div>

        <div class="table-container">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Method</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?= $row['payment_id'] ?></td>
                            <td><?= htmlspecialchars($row['client_name']) ?></td>
                            <td><span class="rupee-symbol">Rs.</span> <?= number_format($row['amount'], 2) ?></td>
                            <td><?= date('M j, Y', strtotime($row['payment_date'])) ?></td>
                            <td><?= ucfirst($row['method']) ?></td>
                            <td class="action-buttons">
                                <a href="edit_payment.php?id=<?= $row['payment_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="delete_payment.php?id=<?= $row['payment_id'] ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this payment?')">
                                    <i class="fas fa-trash-alt me-1"></i>Delete
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/receptionfooter.php'; ?>
</body>
</html>