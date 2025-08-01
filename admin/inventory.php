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
    echo "<script>window.location.href = 'inventory.php';</script>";
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
    echo "<script>window.location.href = 'inventory.php';</script>";
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
            background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7)), 
                              radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
        }
        
        .inventory-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .inventory-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -10%;
            width: 120%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.05), transparent);
            z-index: -1;
        }
        
        .inventory-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }
        
        .inventory-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--gold);
        }
        
        .form-container {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .form-container:hover {
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.15);
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .form-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .form-label {
            color: var(--gold);
            font-weight: 400;
            margin-bottom: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
            border-radius: 6px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
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
            padding: 0.7rem 1.8rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border-radius: 6px;
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
            padding: 0.7rem 1.8rem;
            border-radius: 6px;
        }
        
        .btn-outline-gold:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            transform: translateY(-2px);
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
        
        .rupee-symbol {
            color: var(--gold);
            font-weight: 500;
        }
        
        .action-buttons .btn {
            margin-right: 0.5rem;
            min-width: 80px;
        }
        
        .action-buttons .btn:last-child {
            margin-right: 0;
        }
        
        .btn-warning {
            background: rgba(212, 175, 55, 0.8);
            border: none;
            color: var(--black);
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(212, 175, 55, 0.3);
        }
        
        .btn-danger {
            background: rgba(220, 53, 69, 0.8);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: #dc3545;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        }
        
        .low-stock {
            color: #ffc107;
            font-weight: 500;
            animation: pulse 1.5s infinite;
        }
        
        @keyframes pulse {
            0% { opacity: 1; }
            50% { opacity: 0.6; }
            100% { opacity: 1; }
        }
        
        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }
        
        .form-check-label {
            color: var(--light-gray);
        }
        
        .inventory-stats {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }
        
        .stat-value {
            font-size: 2.2rem;
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
    <div class="container py-4">
        <div class="inventory-header">
            <h1 class="inventory-title"><i class="fas fa-boxes me-2"></i>Inventory Management</h1>
            <p class="text-muted mt-2">Manage salon inventory and track stock levels</p>
        </div>

        

        <!-- Add/Edit Form -->
        <div class="form-container">
            <h3 class="form-title"><i class="fas fa-edit me-2"></i>Manage Inventory Item</h3>
            <form method="POST" class="row g-3">
                <input type="hidden" name="item_id" id="item_id" value="">
                
                <div class="col-md-5">
                    <label class="form-label">Item Name</label>
                    <input type="text" name="name" class="form-control" id="item_name" required>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" class="form-control" id="item_quantity" required min="0">
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Cost per Item</label>
                    <div class="input-group">
                        <span class="input-group-text rupee-symbol">₹</span>
                        <input type="number" name="cost" step="0.01" class="form-control" id="item_cost" required min="0">
                    </div>
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">Supplier</label>
                    <select name="supplier_id" class="form-select" id="item_supplier" required>
                        <option value="">Select Supplier</option>
                        <?php 
                        mysqli_data_seek($suppliers, 0); // Reset pointer
                        while ($sup = mysqli_fetch_assoc($suppliers)): ?>
                            <option value="<?= $sup['supplier_id'] ?>"><?= htmlspecialchars($sup['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <div class="col-md-3 d-flex align-items-center">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="low_stock_alert" id="lowStockAlert" style="width: 3em; height: 1.5em;">
                        <label class="form-check-label ms-2" for="lowStockAlert">Low Stock Alert</label>
                    </div>
                </div>

                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-gold me-3" id="saveButton">
                        <i class="fas fa-plus-circle me-2"></i>Add New Item
                    </button>
                    <button type="button" class="btn btn-outline-gold" id="cancelButton" style="display:none;">
                        <i class="fas fa-times me-2"></i>Cancel Edit
                    </button>
                </div>
            </form>
        </div>

        <!-- Inventory Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Quantity</th>
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
                            <tr id="row_<?= $item['item_id'] ?>">
                                <td data-label="ID"><?= $item['item_id'] ?></td>
                                <td data-label="Name"><?= htmlspecialchars($item['name']) ?></td>
                                <td data-label="Quantity">
                                    <?php if($item['quantity'] < 10): ?>
                                        <span class="low-stock"><?= $item['quantity'] ?></span>
                                    <?php else: ?>
                                        <?= $item['quantity'] ?>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Cost"><span class="rupee-symbol">₹</span> <?= number_format($item['cost'], 2) ?></td>
                                <td data-label="Supplier"><?= htmlspecialchars($item['supplier_name']) ?></td>
                                <td data-label="Low Stock">
                                    <?php if($item['low_stock_alert']): ?>
                                        <span class="badge bg-warning text-dark">Yes</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">No</span>
                                    <?php endif; ?>
                                </td>
                                <td data-label="Actions" class="action-buttons">
                                    <button class="btn btn-sm btn-warning edit-btn" 
                                            data-id="<?= $item['item_id'] ?>"
                                            data-name="<?= htmlspecialchars($item['name']) ?>"
                                            data-quantity="<?= $item['quantity'] ?>"
                                            data-cost="<?= $item['cost'] ?>"
                                            data-supplier="<?= $item['supplier_id'] ?>"
                                            data-lowstock="<?= $item['low_stock_alert'] ?>">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </button>
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit button functionality
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const quantity = this.getAttribute('data-quantity');
                const cost = this.getAttribute('data-cost');
                const supplier = this.getAttribute('data-supplier');
                const lowstock = this.getAttribute('data-lowstock');
                
                // Fill form with data
                document.getElementById('item_id').value = id;
                document.getElementById('item_name').value = name;
                document.getElementById('item_quantity').value = quantity;
                document.getElementById('item_cost').value = cost;
                document.getElementById('item_supplier').value = supplier;
                document.getElementById('lowStockAlert').checked = (lowstock == '1');
                
                // Change button text and show cancel button
                document.getElementById('saveButton').innerHTML = '<i class="fas fa-save me-2"></i>Update Item';
                document.getElementById('cancelButton').style.display = 'block';
                
                // Scroll to form
                document.querySelector('.form-container').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Highlight the row being edited
                document.querySelectorAll('tr').forEach(row => row.classList.remove('table-active'));
                document.getElementById('row_' + id).classList.add('table-active');
            });
        });
        
        // Cancel button functionality
        document.getElementById('cancelButton').addEventListener('click', function() {
            // Reset form
            document.getElementById('item_id').value = '';
            document.getElementById('item_name').value = '';
            document.getElementById('item_quantity').value = '';
            document.getElementById('item_cost').value = '';
            document.getElementById('item_supplier').value = '';
            document.getElementById('lowStockAlert').checked = false;
            
            // Reset button
            document.getElementById('saveButton').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Item';
            this.style.display = 'none';
            
            // Remove row highlight
            document.querySelectorAll('tr').forEach(row => row.classList.remove('table-active'));
        });
        
        // Show animation for low stock items
        document.addEventListener('DOMContentLoaded', function() {
            const lowStockItems = document.querySelectorAll('.low-stock');
            lowStockItems.forEach(item => {
                item.style.animationDelay = Math.random() + 's';
            });
        });
    </script>
    <?php include '../includes/adminfooter.php'; ?>
</body>
</html>