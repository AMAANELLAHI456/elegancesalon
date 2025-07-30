<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Handle deletion request
if (isset($_GET['delete_id'])) {
    $client_id = intval($_GET['delete_id']);
    
    // Validate client ID
    if ($client_id <= 0) {
        $_SESSION['error'] = "Invalid client ID.";
        header("Location: clients.php");
        exit;
    }

    // Check if client exists
    $client_check = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = '$client_id'");
    if (mysqli_num_rows($client_check) == 0) {
        $_SESSION['error'] = "Client not found.";
        header("Location: clients.php");
        exit;
    }

    // Check for appointment dependencies
    $appointment_check = mysqli_query($conn, "SELECT * FROM appointments WHERE client_id = '$client_id'");
    if (mysqli_num_rows($appointment_check) > 0) {
        $_SESSION['error'] = "Cannot delete client - appointment records exist. Delete appointments first.";
        header("Location: clients.php");
        exit;
    }

    // Check for payment dependencies (through appointments)
    $payment_check = mysqli_query($conn, 
        "SELECT p.* FROM payments p
         JOIN appointments a ON p.appointment_id = a.appointment_id
         WHERE a.client_id = '$client_id'");
         
    if (mysqli_num_rows($payment_check) > 0) {
        $_SESSION['error'] = "Cannot delete client - payment records exist. Delete payments first.";
        header("Location: clients.php");
        exit;
    }

    // Proceed with deletion
    $stmt = mysqli_prepare($conn, "DELETE FROM clients WHERE client_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $client_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Client deleted successfully.";
    } else {
        $_SESSION['error'] = "Deletion failed: " . mysqli_error($conn);
    }
    
    mysqli_stmt_close($stmt);
    header("Location: clients.php");
    exit;
}
?>