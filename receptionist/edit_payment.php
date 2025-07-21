<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Check if user is receptionist
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Get payment ID from query string
if (!isset($_GET['id'])) {
    echo "Payment ID not provided.";
    exit;
}
$payment_id = intval($_GET['id']);

// Fetch existing payment details
$result = mysqli_query($conn, "SELECT * FROM payments WHERE payment_id = $payment_id");
if (mysqli_num_rows($result) != 1) {
    echo "Payment not found.";
    exit;
}
$payment = mysqli_fetch_assoc($result);

// Fetch appointment list for dropdown
$appointments = mysqli_query($conn, "SELECT a.appointment_id, c.name AS client_name FROM appointments a JOIN clients c ON a.client_id = c.client_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = intval($_POST['appointment_id']);
    $amount = floatval($_POST['amount']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);

    $update = "UPDATE payments SET appointment_id = $appointment_id, amount = $amount,
               payment_date = '$payment_date', method = '$method' WHERE payment_id = $payment_id";

    if (mysqli_query($conn, $update)) {
        header("Location: payments.php");
        exit;
    } else {
        echo "Error updating payment: " . mysqli_error($conn);
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Edit Payment</h2>
<form method="POST" action="">
    <div class="mb-3">
        <label>Appointment</label>
        <select name="appointment_id" class="form-control" required>
            <?php while ($row = mysqli_fetch_assoc($appointments)) : ?>
                <option value="<?= $row['appointment_id'] ?>" <?= $payment['appointment_id'] == $row['appointment_id'] ? 'selected' : '' ?> >
                    <?= $row['client_name'] ?> (ID: <?= $row['appointment_id'] ?>)
                </option>
            <?php endwhile; ?>
        </select>
    </div>
    <div class="mb-3">
        <label>Amount</label>
        <input type="number" step="0.01" name="amount" class="form-control" value="<?= $payment['amount'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Payment Date</label>
        <input type="date" name="payment_date" class="form-control" value="<?= $payment['payment_date'] ?>" required>
    </div>
    <div class="mb-3">
        <label>Method</label>
        <input type="text" name="method" class="form-control" value="<?= htmlspecialchars($payment['method']) ?>" required>
    </div>
    <button type="submit" class="btn btn-success">Update Payment</button>
</form>

<?php include '../includes/footer.php'; ?>
