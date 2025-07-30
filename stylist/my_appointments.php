<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/stylistheader.php';
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
  <title>My Appointments | Elegance Salon</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #D4AF37;
      --dark-gold: #B7950B;
      --black: #000000;
      --darker-gray: #121212;
      --light-gray: #E0E0E0;
    }

    body {
      background-color: var(--black);
      color: var(--light-gray);
      font-family: 'Montserrat', sans-serif;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .page-header {
      border-bottom: 1px solid rgba(212, 175, 55, 0.3);
      padding-bottom: 1rem;
      margin-bottom: 2rem;
    }

    .page-title {
      color: var(--gold);
      font-weight: 300;
      letter-spacing: 1px;
    }

    .table-container {
      background: var(--black);
      border: 1px solid rgba(212, 175, 55, 0.2);
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .table {
      color: var(--light-gray);
      margin-bottom: 0;
    }

    .table-dark {
      background: rgba(212, 175, 55, 0.1) !important;
    }

    .table-dark th {
      color: var(--gold);
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.8px;
      border-color: rgba(212, 175, 55, 0.3);
      background: var(--black) !important;
    }

    .table td, .table th {
      border-color: rgba(255, 255, 255, 0.05);
      padding: 1rem;
      vertical-align: middle;
    }

    .badge {
      padding: 0.5em 0.75em;
      font-weight: 500;
    }

    .badge.booked {
      background-color: rgba(23, 162, 184, 0.2);
      color: #17a2b8;
    }

    .badge.completed {
      background-color: rgba(40, 167, 69, 0.2);
      color: #28a745;
    }

    .badge.cancelled {
      background-color: rgba(220, 53, 69, 0.2);
      color: #dc3545;
    }

    .no-appointments {
      text-align: center;
      padding: 2rem;
      color: var(--light-gray);
      opacity: 0.7;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="page-header">
      <h1 class="page-title"><i class="fas fa-calendar-alt me-2"></i>My Appointments</h1>
    </div>

    <div class="table-container">
      <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-dark table-hover">
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
                <td><?= date('M j, Y', strtotime($row['appointment_time'])) ?></td>
                <td><?= date('h:i A', strtotime($row['appointment_time'])) ?></td>
                <td><?= htmlspecialchars($row['client_name']) ?></td>
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
          <p>You don't have any appointments yet</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <?php include '../includes/stylistfooter.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>