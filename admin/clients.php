<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/adminheader.php';

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // First delete related appointments
    $delete_appointments = "DELETE FROM appointments WHERE client_id = '$delete_id'";
    mysqli_query($conn, $delete_appointments);
    
    // Then delete the client
    $delete_sql = "DELETE FROM clients WHERE client_id = '$delete_id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Client and related appointments deleted successfully";
        echo "<script>window.location.href = 'clients.php';</script>";
        exit;
    } else {
        $_SESSION['error'] = "Error deleting client: " . mysqli_error($conn);
    }
}

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
        
        .preferences {
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .client-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--gold);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: var(--black);
            margin-right: 10px;
        }
        
        .client-info {
            display: flex;
            align-items: center;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem;
            color: rgba(255, 255, 255, 0.5);
        }
        
        .empty-state i {
            font-size: 4rem;
            margin-bottom: 1rem;
            color: rgba(212, 175, 55, 0.3);
        }
        
        .search-container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            padding: 0.5rem 1rem;
            max-width: 300px;
            display: flex;
            align-items: center;
        }
        
        .search-container input {
            background: transparent;
            border: none;
            color: var(--light-gray);
            width: 100%;
            outline: none;
        }
        
        .search-container input:focus {
            box-shadow: none;
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

        <!-- Search and Filter Section -->
        <div class="d-flex justify-content-between mb-4">
            <div class="search-container">
                <i class="fas fa-search me-2 text-muted"></i>
                <input type="text" placeholder="Search clients...">
            </div>
            
            <div>
                <select class="form-select" style="width: 200px;">
                    <option>All Clients</option>
                    <option>Active Clients</option>
                    <option>Inactive Clients</option>
                </select>
            </div>
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

        <!-- Clients Table -->
        <div class="table-container" style="background: var(--black);">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Contact</th>
                        <th>Preferences</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($clients_result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($clients_result)): ?>
                            <tr style="background: var(--black);">
                                <td><?= htmlspecialchars($row['client_id']) ?></td>
                                <td>
                                    <div class="client-info">
                                        <div class="client-avatar">
                                            <?= substr(htmlspecialchars($row['name']), 0, 1) ?>
                                        </div>
                                        <div>
                                            <strong><?= htmlspecialchars($row['name']) ?></strong><br>
                                            <small class="text-muted">ID: <?= htmlspecialchars($row['client_id']) ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <i class="fas fa-envelope me-2 text-muted"></i> <?= htmlspecialchars($row['email']) ?><br>
                                    <i class="fas fa-phone me-2 text-muted"></i> <?= htmlspecialchars($row['phone']) ?>
                                </td>
                                <td class="preferences">
                                    <?= $row['preferences'] ? htmlspecialchars($row['preferences']) : '<span class="text-muted">No preferences</span>' ?>
                                </td>
                                <td class="action-buttons">
                                    <a href="edit.clients.php?client_id=<?= $row['client_id'] ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="clients.php?delete_id=<?= $row['client_id'] ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('Are you sure you want to delete this client and all their appointments?')">
                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <i class="fas fa-user-slash"></i>
                                    <h4>No Clients Found</h4>
                                    <p>Add your first client to get started</p>
                                    <a href="add.clients.php" class="btn btn-gold mt-2">
                                        <i class="fas fa-plus me-2"></i>Add New Client
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/adminfooter.php'; ?>
</body>
</html>