<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name && $email && $phone) {
        $stmt = mysqli_prepare($conn, "INSERT INTO clients (name, email, phone) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
        mysqli_stmt_execute($stmt);

        header("Location: clients.php?msg=added");
        exit;
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<?php include '../includes/header.php'; ?>

<h2>Add New Client</h2>

<?php if (isset($error)) : ?>
    <div class="alert alert-danger"><?= $error ?></div>
<?php endif; ?>

<form method="post" action="">
    <div class="mb-3">
        <label for="name" class="form-label">Client Name</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Client Email</label>
        <input type="email" class="form-control" name="email" id="email" required>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Client Phone</label>
        <input type="text" class="form-control" name="phone" id="phone" required>
    </div>
    <button type="submit" class="btn btn-success">Add Client</button>
    <a href="clients.php" class="btn btn-secondary">Cancel</a>
</form>

<?php include '../includes/footer.php'; ?>
