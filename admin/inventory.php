<?php
// admin/inventory.php

require_once '../includes/auth.php';
require_once '../includes/db.php';
include '../includes/header.php';

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

<div class="container mt-4">
    <h2>Inventory Management</h2>

    <!-- Add/Edit Form -->
    <form method="POST" class="row g-3 border p-3 mb-4">
        <input type="hidden" name="item_id" value="">

        <div class="col-md-4">
            <label>Item Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label>Quantity</label>
            <input type="number" name="quantity" class="form-control" required>
        </div>
        <div class="col-md-2">
            <label>Cost</label>
            <input type="number" name="cost" step="0.01" class="form-control" required>
        </div>
        <div class="col-md-3">
            <label>Supplier</label>
            <select name="supplier_id" class="form-select" required>
                <option value="">Select Supplier</option>
                <?php while ($sup = mysqli_fetch_assoc($suppliers)): ?>
                    <option value="<?= $sup['supplier_id'] ?>"><?= htmlspecialchars($sup['name']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="col-md-1 d-flex align-items-end">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="low_stock_alert">
                <label class="form-check-label">Low?</label>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Item</button>
        </div>
    </form>

    <!-- Inventory Table -->
    <table class="table table-bordered">
        <thead class="table-dark">
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
            <?php while ($item = mysqli_fetch_assoc($inventory)): ?>
                <tr class="<?= $item['low_stock_alert'] ? 'table-warning' : '' ?>">
                    <td><?= $item['item_id'] ?></td>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>Rs. <?= number_format($item['cost'], 2) ?></td>
                    <td><?= htmlspecialchars($item['supplier_name']) ?></td>
                    <td><?= $item['low_stock_alert'] ? 'Yes' : 'No' ?></td>
                    <td>
                        <!-- You can later add edit functionality -->
                        <a href="?delete=<?= $item['item_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this item?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
