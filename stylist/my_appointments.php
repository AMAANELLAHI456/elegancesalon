<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/stylistheader.php';
;

$stylist_id = $_SESSION['user_id'];
// Fetch all appointments
// $sql = "
//     SELECT a.appointment_time, a.status, c.name AS client_name, 
//            s.service_name, u.name AS stylist_name
//     FROM appointments a
//     JOIN clients c ON a.client_id = c.client_id
//     JOIN services s ON a.service_id = s.service_id
//     JOIN users u ON a.stylist_id = u.user_id
//     WHERE a.stylist_id = $stylist_id
//     ORDER BY a.appointment_time DESC
    
// ";
$sql = "
    SELECT a.appointment_time, a.status, c.name AS client_name, 
           s.service_name, u.name AS stylist_name
    FROM appointments a
    JOIN clients c ON a.client_id = c.client_id
    JOIN services s ON a.service_id = s.service_id
    JOIN users u ON a.stylist_id = u.user_id
    ORDER BY a.appointment_time DESC
    
";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Appointments | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* ... (keep existing styles) ... */
  </style>
</head>
<body>
  <div class="container">
    <div class="page-header">
      <h1 class="page-title"><i class="fas fa-calendar-alt me-2"></i>All Appointments</h1>
    </div>

    <div class="table-container">
      <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-dark table-hover">
          <thead>
            <tr>
              <th>Date</th>
              <th>Time</th>
              <th>Client</th>
              <th>Stylist</th>
              <th>Service</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= date('M j, Y', strtotime($row['appointment_time'])) ?></td>
                <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
                <td><?= htmlspecialchars($row['client_name']) ?></td>
                <td><?= htmlspecialchars($row['stylist_name']) ?></td>
                <td><?= htmlspecialchars($row['service_name']) ?></td>
                <td>
                  <span class="badge <?= $row['status'] ?>">
                    <?= ucfirst($row['status']) ?>
                  </span>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      <?php else: ?>
        <div class="no-appointments">
          <i class="fas fa-calendar-times fa-3x mb-3"></i>
          <h4>No appointments found</h4>
          <p>There are no appointments in the system yet</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include '../includes/stylistfooter.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>