<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

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

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <h2>Payments</h2>
    <a href="add_payment.php" class="btn btn-success mb-3">Add Payment</a>

    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
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
                    <td>Rs. <?= number_format($row['amount'], 2) ?></td>
                    <td><?= $row['payment_date'] ?></td>
                    <td><?= ucfirst($row['method']) ?></td>
                    <td>
                        <a href="edit_payment.php?id=<?= $row['payment_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="delete_payment.php?id=<?= $row['payment_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this payment?')">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
