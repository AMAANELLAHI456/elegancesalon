<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';



// Validate client ID from URL
$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

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

// Check if client has any appointments
$appointment_check = mysqli_query($conn, "SELECT * FROM appointments WHERE client_id = '$client_id'");
if (mysqli_num_rows($appointment_check) > 0) {
    $_SESSION['error'] = "Cannot delete client - appointment records exist. Please delete appointments first.";
    header("Location: clients.php");
    exit;
}

// Check if client has any payments (through appointments)
$payment_check = mysqli_query($conn, 
    "SELECT p.* FROM payments p
     JOIN appointments a ON p.appointment_id = a.appointment_id
     WHERE a.client_id = '$client_id'");
     
if (mysqli_num_rows($payment_check) > 0) {
    $_SESSION['error'] = "Cannot delete client - payment records exist. Please delete payments first.";
    header("Location: clients.php");
    exit;
}

// Proceed with deletion if no dependencies
$stmt = mysqli_prepare($conn, "DELETE FROM clients WHERE client_id = ?");
mysqli_stmt_bind_param($stmt, "i", $client_id);

if (mysqli_stmt_execute($stmt)) {
    $_SESSION['message'] = "Client deleted successfully.";
} else {
    $_SESSION['error'] = "Error deleting client: " . mysqli_error($conn);
}

header("Location: clients.php");
exit;
?>