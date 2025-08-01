<?php
require_once 'includes/db.php';

// Sanitize inputs
$client_name = mysqli_real_escape_string($conn, $_POST['client_name']);
$client_phone = mysqli_real_escape_string($conn, $_POST['client_phone']);
$service_id = $_POST['service_id'];

$appointment_time = $_POST['appointment_time'];

// Add new client
mysqli_query($conn, "INSERT INTO clients (name, phone) VALUES ('$client_name', '$client_phone')");
$client_id = mysqli_insert_id($conn);

// Insert pending appointment
mysqli_query($conn, "INSERT INTO appointments (client_id, service_id, appointment_time, status) VALUES ('$client_id', '$service_id', '$appointment_time', 'pending')");

$client_name_encoded = urlencode($client_name);
$appointment_time_encoded = urlencode($appointment_time);
header("Location: request_success.php?client_name=$client_name_encoded&appointment_time=$appointment_time_encoded&client_phone=$client_phone");
exit();
