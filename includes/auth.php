<?php
// includes/auth.php

require_once __DIR__ . '/db.php'; // ✅ This brings in BASE_URL

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If user not logged in, redirect to login
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "login.php");
    exit;
}
