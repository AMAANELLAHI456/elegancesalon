<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Fetch appointments for dropdown
$appointments_result = mysqli_query($conn, "
    SELECT a.appointment_id, c.name AS client_name 
    FROM appointments a
    JOIN clients c ON a.client_id = c.client_id
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = $_POST['appointment_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $method = $_POST['method'];

    $stmt = mysqli_prepare($conn, "INSERT INTO payments (appointment_id, amount, payment_date, method) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'idss', $appointment_id, $amount, $payment_date, $method);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: payments.php");
        exit;
    } else {
        $error = "Failed to add payment.";
    }
}

include '../includes/header.php';
?>

<div class="container">
    <h2>Add New Payment</h2>
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="form-group">
            <label for="appointment_id">Appointment (Client)</label>
            <select name="appointment_id" class="form-control" required>
                <option value="">Select Appointment</option>
                <?php while ($row = mysqli_fetch_assoc($appointments_result)) : ?>
                    <option value="<?= $row['appointment_id'] ?>">
                        <?= 'ID#' . $row['appointment_id'] . ' - ' . htmlspecialchars($row['client_name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="amount">Amount</label>
            <input type="number" name="amount" class="form-control" step="0.01" required>
        </div>

        <div class="form-group">
            <label for="payment_date">Payment Date</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="method">Payment Method</label>
            <select name="method" class="form-control" required>
                <option value="Cash">Cash</option>
                <option value="Card">Card</option>
                <option value="Online">Online</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Add Payment</button>
        <a href="payments.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include '../includes/footer.php'; ?>
