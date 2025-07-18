<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Validate client ID from URL
$client_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($client_id <= 0) {
    die("Invalid client ID.");
}

// Optional: You may want to check if client exists before deletion

// Delete client from database
$stmt = mysqli_prepare($conn, "DELETE FROM clients WHERE client_id = ?");
mysqli_stmt_bind_param($stmt, "i", $client_id);
mysqli_stmt_execute($stmt);

// Redirect back to client list with success message
header("Location: clients.php");
exit;
