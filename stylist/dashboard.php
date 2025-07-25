<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 3) {
    header("Location: ../login.php");
    exit;
}

$stylist_id = $_SESSION['user_id'];

// Fetch stylist name
$stmt = mysqli_prepare($conn, "SELECT name FROM users WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $stylist_id);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $stylist_name);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Today's appointments
$today = date('Y-m-d');
$sql_today = "
    SELECT a.appointment_time, c.name AS client_name, s.service_name
    FROM appointments a
    JOIN clients c ON a.client_id = c.client_id
    JOIN services s ON a.service_id = s.service_id
    WHERE a.stylist_id = ? AND DATE(a.appointment_time) = ?
    ORDER BY a.appointment_time ASC
";
$stmt = mysqli_prepare($conn, $sql_today);
mysqli_stmt_bind_param($stmt, "is", $stylist_id, $today);
mysqli_stmt_execute($stmt);
$result_today = mysqli_stmt_get_result($stmt);

// Weekly shifts
$sql_schedule = "
    SELECT shift_start, shift_end 
    FROM staff_schedule 
    WHERE stylist_id = ? AND WEEK(shift_start) = WEEK(CURDATE())
    ORDER BY shift_start
";
$stmt2 = mysqli_prepare($conn, $sql_schedule);
mysqli_stmt_bind_param($stmt2, "i", $stylist_id);
mysqli_stmt_execute($stmt2);
$result_schedule = mysqli_stmt_get_result($stmt2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Stylist Dashboard | Elegance Salon</title>
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

    .dashboard-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem;
    }

    .header-section {
      border-bottom: 1px solid rgba(212, 175, 55, 0.3);
      padding-bottom: 1rem;
      margin-bottom: 2rem;
      text-align: center;
    }

    .dashboard-title {
      color: var(--gold);
      font-weight: 300;
      letter-spacing: 1px;
    }

    .card {
      background: var(--black);
      border: 1px solid rgba(212, 175, 55, 0.2);
      border-radius: 8px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
      height: 100%;
    }

    .card-title {
      color: var(--gold);
      font-weight: 500;
      margin-bottom: 1.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card-title i {
      margin-right: 0.75rem;
      font-size: 1.5rem;
    }

    .list-group-item {
      background: rgba(255, 255, 255, 0.05);
      border-color: rgba(255, 255, 255, 0.1);
      color: var(--light-gray);
    }

    .table {
      color: var(--light-gray);
    }

    .table th {
      color: var(--gold);
      border-color: rgba(212, 175, 55, 0.3);
    }

    .table td {
      border-color: rgba(255, 255, 255, 0.05);
    }

    .nav-card {
      transition: all 0.3s ease;
      text-decoration: none;
      color: inherit;
    }

    .nav-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
      border-color: var(--gold);
    }

    .text-muted {
      color: var(--light-gray) !important;
      opacity: 0.7;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <div class="header-section">
      <h1 class="dashboard-title"><i class="fas fa-cut"></i> Welcome, <?= htmlspecialchars($stylist_name) ?></h1>
    </div>

    <div class="row">
      <!-- Today's Appointments -->
      <div class="col-md-6">
        <div class="card">
          <h5 class="card-title"><i class="fas fa-calendar-check"></i> Today's Appointments</h5>
          <?php if (mysqli_num_rows($result_today) > 0): ?>
            <ul class="list-group">
              <?php while ($row = mysqli_fetch_assoc($result_today)): ?>
                <li class="list-group-item">
                  <div class="d-flex justify-content-between">
                    <span><strong><?= date("h:i A", strtotime($row['appointment_time'])) ?></strong></span>
                    <span><?= htmlspecialchars($row['client_name']) ?></span>
                  </div>
                  <div class="text-muted"><?= htmlspecialchars($row['service_name']) ?></div>
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p class="text-muted text-center">No appointments today</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Weekly Schedule -->
      <div class="col-md-6">
        <div class="card">
          <h5 class="card-title"><i class="fas fa-calendar-week"></i> This Week's Schedule</h5>
          <?php if (mysqli_num_rows($result_schedule) > 0): ?>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>Date</th>
                    <th>Start</th>
                    <th>End</th>
                  </tr>
                </thead>
                <tbody>
                  <?php while ($row = mysqli_fetch_assoc($result_schedule)): ?>
                    <tr>
                      <td><?= date("D, M d", strtotime($row['shift_start'])) ?></td>
                      <td><?= date("h:i A", strtotime($row['shift_start'])) ?></td>
                      <td><?= date("h:i A", strtotime($row['shift_end'])) ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
          <?php else: ?>
            <p class="text-muted text-center">No shifts scheduled this week</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Quick Navigation -->
    <div class="row">
      <div class="col-md-6">
        <a href="my_appointments.php" class="card nav-card">
          <h5 class="card-title"><i class="fas fa-calendar-alt"></i> My Appointments</h5>
          <p class="text-muted text-center">View and manage all your appointments</p>
        </a>
      </div>
      <div class="col-md-6">
        <a href="my_schedule.php" class="card nav-card">
          <h5 class="card-title"><i class="fas fa-clipboard-list"></i> My Schedule</h5>
          <p class="text-muted text-center">View and update your availability</p>
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>