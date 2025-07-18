<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Fetch all clients
$clients_result = mysqli_query($conn, "SELECT * FROM clients");
?>

<?php include '../includes/header.php'; ?>

<h2>Client Management</h2>
<a href="add.clients.php" class="btn btn-primary mb-3">Add New Client</a>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($clients_result)) : ?>
        <tr>
            <td><?= $row['client_id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td>
                <a href="edit.clients.php?id=<?= $row['client_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                <a href="delete_clients.php?id=<?= $row['client_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this client?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
