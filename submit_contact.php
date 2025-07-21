<?php
require_once 'includes/db.php';
 // Fixed path

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    $query = "INSERT INTO contactmessages (name, email, message, submitted_at) 
              VALUES ('$name', '$email', '$message', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contactus.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }
} else {
    header("Location: contactus.php");
    exit;
}
?>
