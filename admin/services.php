<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/adminheader.php';
if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Handle Add Service
if (isset($_POST['add_service'])) {
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    $insert = "INSERT INTO Services (service_name, description, price) VALUES ('$name', '$desc', $price)";
    mysqli_query($conn, $insert);
    header("Location: services.php");
    exit;
}

// Handle Delete Service
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM Services WHERE service_id = $id");
    header("Location: services.php");
    exit;
}

// Handle Edit
$edit_mode = false;
if (isset($_GET['edit'])) {
    $edit_mode = true;
    $id = intval($_GET['edit']);
    $edit_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM Services WHERE service_id = $id"));
}

// Handle Update Service
if (isset($_POST['update_service'])) {
    $id = intval($_POST['service_id']);
    $name = mysqli_real_escape_string($conn, $_POST['service_name']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    $update = "UPDATE Services SET service_name='$name', description='$desc', price=$price WHERE service_id=$id";
    mysqli_query($conn, $update);
    header("Location: services.php");
    exit;
}

// Fetch all services
$services = mysqli_query($conn, "SELECT * FROM Services ORDER BY service_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services Management | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000;  /* Changed to pure black */
            --darker-gray: #121212; /* Darker shade for contrast */
            --dark-gray: #1E1E1E;  /* Slightly lighter than black */
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
        
        /* Ensure header and footer also use black background */
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body style="background: var(--black);">
    
    
    <div class="container py-4" style="background: var(--black);">
        <div class="services-header">
            <h1 class="services-title"><i class="fas fa-spa me-2"></i>Services Management</h1>
        </div>

        <!-- Service Form -->
        <div class="form-container" style="background: var(--black);">
            <form method="POST" action="">
                <input type="hidden" name="service_id" value="<?= $edit_mode ? $edit_data['service_id'] : '' ?>">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Service Name</label>
                        <input type="text" name="service_name" class="form-control" required 
                            value="<?= $edit_mode ? htmlspecialchars($edit_data['service_name']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Description</label>
                        <input type="text" name="description" class="form-control"
                            value="<?= $edit_mode ? htmlspecialchars($edit_data['description']) : '' ?>">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Price</label>
                        <div class="input-group">
                            <span class="input-group-text rupee-symbol">Rs.</span>
                            <input type="number" step="0.01" name="price" class="form-control" required
                                value="<?= $edit_mode ? htmlspecialchars($edit_data['price']) : '' ?>">
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <?php if ($edit_mode): ?>
                            <button class="btn btn-gold w-100" type="submit" name="update_service">
                                <i class="fas fa-save me-2"></i>Update
                            </button>
                        <?php else: ?>
                            <button class="btn btn-gold w-100" type="submit" name="add_service">
                                <i class="fas fa-plus me-2"></i>Add
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>

        <!-- Services Table -->
        <div class="table-container" style="background: var(--black);">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($services, 0); // Reset pointer
                    while ($row = mysqli_fetch_assoc($services)) : ?>
                        <tr style="background: var(--black);">
                            <td><?= $row['service_id'] ?></td>
                            <td><?= htmlspecialchars($row['service_name']) ?></td>
                            <td><?= htmlspecialchars($row['description']) ?></td>
                            <td><span class="rupee-symbol">Rs.</span> <?= number_format($row['price'], 2) ?></td>
                            <td class="action-buttons">
                                <a href="?edit=<?= $row['service_id'] ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit me-1"></i>Edit
                                </a>
                                <a href="?delete=<?= $row['service_id'] ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Are you sure you want to delete this service?')">
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