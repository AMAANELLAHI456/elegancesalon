<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';






// Check if client_id is provided and valid
if (isset($_GET['client_id']) && is_numeric($_GET['client_id'])) {
    $client_id = intval($_GET['client_id']);
    
    // Check if client exists
    $check_query = "SELECT * FROM clients WHERE client_id = $client_id";
    $check_result = mysqli_query($conn, $check_query);
    
    if (mysqli_num_rows($check_result) == 0) {
        $_SESSION['message'] = [
            'type' => 'warning',
            'text' => 'Client not found!'
        ];
        header("Location: clients.php");
        exit();
    }
    
    // Delete related appointments first (due to foreign key constraint)
    $delete_appointments = "DELETE FROM appointments WHERE client_id = $client_id";
    mysqli_query($conn, $delete_appointments);
    
    // Delete the client
    $delete_client = "DELETE FROM clients WHERE client_id = $client_id";
    
    if (mysqli_query($conn, $delete_client)) {
        $_SESSION['message'] = [
            'type' => 'success',
            'text' => 'Client and related appointments deleted successfully!'
        ];
    } else {
        $_SESSION['message'] = [
            'type' => 'danger',
            'text' => 'Error deleting client: ' . mysqli_error($conn)
        ];
    }
} else {
    $_SESSION['message'] = [
        'type' => 'danger',
        'text' => 'Invalid client ID!'
    ];
}

// Redirect back to client management
header("Location: clients.php");
exit();
include '../includes/receptionfooter.php';
?>