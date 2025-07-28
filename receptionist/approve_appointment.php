<?php
require_once '../includes/db.php';

$id = $_GET['id'] ?? 0;
mysqli_query($conn, "UPDATE appointments SET status='booked' WHERE appointment_id=$id");

header("Location: manage_requests.php");
exit;
