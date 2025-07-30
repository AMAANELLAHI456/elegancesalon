<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

include '../includes/adminheader.php';

// Check if client ID is provided
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $client_id = intval($_GET['id']);
    
    // Check if client exists
    $check_client = mysqli_query($conn, "SELECT * FROM clients WHERE client_id = $client_id");
    if (mysqli_num_rows($check_client) === 0) {
        $_SESSION['error'] = "Client not found.";
        echo "<script>window.location.href = 'clients.php';</script>";
        exit();
    }
    
    // Check if client has any appointments
    $check_appointments = mysqli_query($conn, "SELECT * FROM appointments WHERE client_id = $client_id");
    if (mysqli_num_rows($check_appointments) > 0) {
        $_SESSION['error'] = "Cannot delete client - they have existing appointments. Please cancel appointments first.";
        echo "<script>window.location.href = 'clients.php';</script>";
        exit();
    }
    
    // Delete the client
    $delete_query = "DELETE FROM clients WHERE client_id = $client_id";
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['success'] = "Client deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting client: " . mysqli_error($conn);
    }
    
   echo "<script>window.location.href = 'clients.php';</script>";
    exit();
} else {
    $_SESSION['error'] = "No client ID specified.";
    echo "<script>window.location.href = 'clients.php';</script>";
    exit();
}
?>
<?php include '../includes/adminfooter.php'; ?>