<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Fetch all appointments
$sql = "SELECT a.appointment_id, c.name AS client_name, s.service_name AS service_name, a.appointment_time
        FROM appointments a
        JOIN clients c ON a.client_id = c.client_id
        JOIN services s ON a.service_id = s.service_id
        ORDER BY a.appointment_time DESC";

$result = mysqli_query($conn, $sql);
?>

<?php include '../includes/header.php'; ?>

<h2>Manage Appointments</h2>
<table class="table table-bordered mt-4">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Client</th>
            <th>Service</th>
            <th>Time</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['appointment_id']) ?></td>
                <td><?= htmlspecialchars($row['client_name']) ?></td>
                <td><?= htmlspecialchars($row['service_name']) ?></td>
                <td><?= htmlspecialchars($row['appointment_time']) ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php include '../includes/footer.php'; ?>
