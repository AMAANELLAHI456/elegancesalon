<?php
// includes/db.php


// ✅ Define BASE_URL — adjust the path if needed
define('BASE_URL', '/elegancesalon/');

// Database connection
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'elegancesalondb';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (mysqli_connect_errno()) {
    die("❌ Database connection failed: " . mysqli_connect_error());
}
