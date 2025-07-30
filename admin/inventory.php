<?php
// admin/inventory.php
require_once '../includes/auth.php';
require_once '../includes/db.php';
include '../includes/adminheader.php';

// Handle item deletion
if (isset($_GET['delete'])) {
    $delete_id = intval($_GET['delete']);
    $query = "DELETE FROM Inventory WHERE item_id = $delete_id";
    mysqli_query($conn, $query);
    header("Location: inventory.php");
    exit;
}

// Handle form submission for add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $item_name = mysqli_real_escape_string($conn, $_POST['name']);
    $quantity = intval($_POST['quantity']);
    $cost = floatval($_POST['cost']);
    $supplier_id = intval($_POST['supplier_id']);
    $low_stock_alert = isset($_POST['low_stock_alert']) ? 1 : 0;

    if (isset($_POST['item_id']) && $_POST['item_id'] != '') {
        // Update existing item
        $item_id = intval($_POST['item_id']);
        $query = "UPDATE Inventory SET name='$item_name', quantity=$quantity, cost=$cost, supplier_id=$supplier_id, low_stock_alert=$low_stock_alert WHERE item_id=$item_id";
    } else {
        // Insert new item
        $query = "INSERT INTO Inventory (name, quantity, cost, supplier_id, low_stock_alert) VALUES ('$item_name', $quantity, $cost, $supplier_id, $low_stock_alert)";
    }

    mysqli_query($conn, $query);
    header("Location: inventory.php");
    exit;
}

// Get suppliers for dropdown
$suppliers = mysqli_query($conn, "SELECT supplier_id, name FROM Suppliers");

// Get inventory list
$inventory = mysqli_query($conn, "
    SELECT i.*, s.name AS supplier_name
    FROM Inventory i
    JOIN Suppliers s ON i.supplier_id = s.supplier_id
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #0F0F0F;
            --darker-gray: #1A1A1A;
            --dark-gray: #252525;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
        }
        
        .inventory-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .inventory-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .form-container {
            background: var(--dark-gray);
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
        
        .table-container {
            background: var(--dark-gray);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .table {
            color: var(--light-gray);
            margin-bottom: 0;
        }
        
        .table-dark {
            background: rgba(212, 175, 55, 0.2) !important;
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table-warning {
            background: rgba(212, 175, 55, 0.1) !important;
        }
        
        .table-warning td {
            color: var(--gold);
        }
        
        .btn-sm {
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            border-radius: 4px;
        }
        
        .btn-danger {
            background: #dc3545;
            border: none;
        }
        
        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }
        
        .form-check-label {
            color: var(--light-gray);
        }
        
        .rupee-symbol {
            color: var(--gold);
            font-weight: 500;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="inventory-header">
            <h1 class="inventory-title"><i class="fas fa-boxes me-2"></i>Inventory Management</h1>
        </div>

        <!-- Add/Edit Form -->
        <div class="form-container">
            <form method="POST" class="row g-3">
                <input type="hidden" name="item_id" value="">
                
                <div class="col-md-4">
                    <label class="form-label">Item Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" required>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Cost</label>
                    <div class="input-group">
                        <span class="input-group-text rupee-symbol">Rs.</span>
                        <input type="number" name="cost" step="0.01" class="form-control" required>
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select" required>
                        <option value="">Select Supplier</option>
                        <?php 
                        mysqli_data_seek($suppliers, 0); // Reset pointer
                        while ($sup = mysqli_fetch_assoc($suppliers)): ?>
                            <option value="<?= $sup['supplier_id'] ?>"><?= htmlspecialchars($sup['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="col-md-1 d-flex align-items-end">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="low_stock_alert" id="lowStockAlert">
                        <label class="form-check-label" for="lowStockAlert">Low Stock</label>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Save Item
                    </button>
                </div>
            </form>
        </div>

        <!-- Inventory Table -->
        <div class="table-container">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Cost</th>
                        <th>Supplier</th>
                        <th>Low Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($inventory, 0); // Reset pointer
                    while ($item = mysqli_fetch_assoc($inventory)): ?>
                        <tr class="<?= $item['low_stock_alert'] ? 'table-warning' : '' ?>">
                            <td><?= $item['item_id'] ?></td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td><span class="rupee-symbol">Rs.</span> <?= number_format($item['cost'], 2) ?></td>
                            <td><?= htmlspecialchars($item['supplier_name']) ?></td>
                            <td><?= $item['low_stock_alert'] ? '<i class="fas fa-exclamation-circle text-danger"></i> Yes' : '<i class="fas fa-check-circle text-success"></i> No' ?></td>
                            <td>
                                <a href="?delete=<?= $item['item_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this item?')">
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