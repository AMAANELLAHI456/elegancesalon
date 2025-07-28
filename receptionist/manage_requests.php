<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

$query = "SELECT a.appointment_id, c.name AS client_name, s.service_name, a.appointment_time, a.status 
          FROM appointments a
          JOIN clients c ON a.client_id = c.client_id
          JOIN services s ON a.service_id = s.service_id
          WHERE a.status = 'pending'";

$result = mysqli_query($conn, $query);
?>

<?php include '../includes/header.php'; ?>

<h2>Pending Appointment Requests</h2>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Service</th>
            <th>Time</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $row['appointment_id'] ?></td>
            <td><?= htmlspecialchars($row['client_name']) ?></td>
            <td><?= htmlspecialchars($row['service_name']) ?></td>
            <td><?= htmlspecialchars($row['appointment_time']) ?></td>
            <td>
                <a href="approve_appointment.php?id=<?= $row['appointment_id'] ?>" class="btn btn-success btn-sm">Approve</a>
                <a href="reject_appointment.php?id=<?= $row['appointment_id'] ?>" class="btn btn-danger btn-sm">Reject</a>
            </td>
        </tr>
    <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
