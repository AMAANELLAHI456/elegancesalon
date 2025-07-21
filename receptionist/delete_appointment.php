<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    
    // First check if there are any payments for this appointment
    $payment_check = mysqli_query($conn, "SELECT * FROM payments WHERE appointment_id = '$delete_id'");
    
    if (mysqli_num_rows($payment_check) > 0) {
        $_SESSION['error'] = "Cannot delete appointment - payment records exist. Please cancel instead.";
        header("Location: appointments.php");
        exit;
    }
    
    // If no payments exist, proceed with deletion
    $delete_sql = "DELETE FROM appointments WHERE appointment_id = '$delete_id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Appointment deleted successfully";
    } else {
        $_SESSION['error'] = "Error deleting appointment: " . mysqli_error($conn);
    }
    
    header("Location: appointments.php");
    exit;
}

// Rest of your existing appointments.php code...
?>