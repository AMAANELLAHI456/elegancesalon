<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

include '../includes/adminheader.php';

// Fetch all clients
$clients_result = mysqli_query($conn, "SELECT * FROM clients");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Management | Elegance Salon</title>
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
            padding: 2rem;
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
        
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body style="background: var(--black);">
    
    
    <div class="container py-4" style="background: var(--black);">
        <div class="d-flex justify-content-between align-items-center services-header">
            <h1 class="services-title"><i class="fas fa-users me-2"></i>Client Management</h1>
            <a href="add.clients.php" class="btn btn-gold">
                <i class="fas fa-plus me-2"></i>Add New Client
            </a>
        </div>

        <!-- Clients Table -->
        <div class="table-container">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($clients_result)) : ?>
                    <tr>
                        <td><?= $row['client_id'] ?></td>
                        <td><?= htmlspecialchars($row['name']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td class="action-buttons">
                            <a href="edit.clients.php?id=<?= $row['client_id'] ?>" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                            <a href="delete_clients.php?id=<?= $row['client_id'] ?>" class="btn btn-sm btn-danger" 
                               onclick="return confirm('Are you sure you want to delete this client?')">
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
     <?php include '../includes/adminfooter.php'; ?>
</body>
</html>