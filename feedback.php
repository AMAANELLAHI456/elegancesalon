<?php
// admin/feedback.php

require_once 'includes/auth.php';
require_once 'includes/db.php';
include 'includes/header.php';
include 'includes/footer.php';

$name = $email = $message = '';
$success = $error = '';

// Handle feedback submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if ($name && $email && $message) {
        $query = "INSERT INTO feedback (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $query)) {
            $success = "Feedback submitted successfully.";
            $name = $email = $message = '';
        } else {
            $error = "Error saving feedback.";
        }
    } else {
        $error = "All fields are required.";
    }
}

// Fetch all feedback
$feedbacks = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");
?>

<div class="container mt-4">
    <h2>Submit Feedback</h2>

    <!-- Feedback Form -->
    <form method="POST" class="row g-3 border p-3 mb-4 bg-light rounded-3 shadow-sm">
        <div class="col-md-4">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($name) ?>" required>
        </div>
        <div class="col-md-4">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="col-md-12">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="3" required><?= htmlspecialchars($message) ?></textarea>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit Feedback</button>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success mt-3"><?= $success ?></div>
        <?php elseif ($error): ?>
            <div class="alert alert-danger mt-3"><?= $error ?></div>
        <?php endif; ?>
    </form>

    <!-- Feedback Table -->
    <h4>All Feedback</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($fb = mysqli_fetch_assoc($feedbacks)): ?>
                <tr>
                    <td><?= $fb['id'] ?></td>
                    <td><?= htmlspecialchars($fb['name']) ?></td>
                    <td><?= htmlspecialchars($fb['email']) ?></td>
                    <td><?= nl2br(htmlspecialchars($fb['message'])) ?></td>
                    <td><?= $fb['created_at'] ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
