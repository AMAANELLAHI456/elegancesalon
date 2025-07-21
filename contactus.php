<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #FFD700;
      --black: #000;
      --light: #eeeeee;
    }

    body {
      background-color: var(--black);
      color: var(--light);
      font-family: Arial, sans-serif;
      padding: 40px 20px;
    }

    .contact-container {
      max-width: 700px;
      margin: 0 auto;
      background: rgba(30, 30, 30, 0.9);
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 0 15px rgba(255, 215, 0, 0.1);
    }

    .form-label, .form-control, .form-textarea {
      color: var(--light);
    }

    .form-control, textarea {
      background-color: #1e1e1e;
      border: 1px solid var(--gold);
      color: var(--light);
    }

    .btn-gold {
      background-color: var(--gold);
      color: var(--black);
      border: none;
    }

    .btn-gold:hover {
      background-color: #e6c200;
    }

    .contact-title {
      text-align: center;
      color: var(--gold);
      margin-bottom: 25px;
    }
  </style>
</head>
<body>
    <form action="submit_contact.php" method="POST">

  <div class="contact-container">
    <h2 class="contact-title"><i class="fas fa-envelope"></i> Contact Us</h2>
    <form action="submit_contact.php" method="POST">
      <div class="mb-3">
        <label for="name" class="form-label">Your Name</label>
        <input type="text" class="form-control" id="name" name="name" required>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">Your Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>

      <div class="mb-3">
        <label for="message" class="form-label">Your Message</label>
        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
      </div>

      <button type="submit" class="btn btn-gold w-100">Send Message</button>
    </form>
  </div>
</body>
</html>
<?php
require_once 'includes/db.php';
 // Ensure this has a valid DB connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $message = mysqli_real_escape_string($conn, trim($_POST['message']));

    $query = "INSERT INTO ContactMessages (name, email, message, submitted_at) 
              VALUES ('$name', '$email', '$message', NOW())";

    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Thank you! Your message has been sent.'); window.location.href='contact_us.php';</script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }
} else {
    header("Location: contact_us.php");
    exit;
}
?>
