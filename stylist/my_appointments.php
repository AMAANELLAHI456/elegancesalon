<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 3) {
    header("Location: ../login.php");
    exit;
}

$stylist_id = $_SESSION['user_id'];

// Fetch stylist appointments
$sql = "
    SELECT a.appointment_time, a.status, c.name AS client_name, s.service_name
    FROM appointments a
    JOIN clients c ON a.client_id = c.client_id
    JOIN services s ON a.service_id = s.service_id
    WHERE a.stylist_id = ?
    ORDER BY a.appointment_time DESC
";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $stylist_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Appointments | Stylist</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #eee;
      padding: 20px;
    }
    .container {
      max-width: 1000px;
      margin: auto;
    }
    .table thead {
      background-color: #FFD700;
      color: #000;
    }
    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2 class="text-center text-warning mb-4">My Appointments</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <table class="table table-dark table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Client</th>
            <th>Service</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= date('Y-m-d', strtotime($row['appointment_time'])) ?></td>
              <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
              <td><?= htmlspecialchars($row['client_name']) ?></td>
              <td><?= htmlspecialchars($row['service_name']) ?></td>
              <td>
                <span class="badge 
                    <?= $row['status'] == 'booked' ? 'bg-info' : ($row['status'] == 'completed' ? 'bg-success' : 'bg-danger') ?>">
                  <?= ucfirst($row['status']) ?>
                </span>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">No appointments found.</p>
    <?php endif; ?>
  </div>
</body>
</html>
