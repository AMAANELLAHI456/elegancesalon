<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Validate ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: payments.php?error=Invalid ID");
    exit;
}

$payment_id = (int)$_GET['id'];

// Perform deletion
$query = "DELETE FROM payments WHERE payment_id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $payment_id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: payments.php?success=Payment deleted successfully");
} else {
    header("Location: payments.php?error=Failed to delete payment");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
exit;
?>
