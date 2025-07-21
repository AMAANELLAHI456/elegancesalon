<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// ✅ Fix: Use 'role' not 'role_id'
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
      --gold: #FFD700;
      --black: #000;
      --light: #eeeeee;
    }

    body {
      background-color: var(--black);
      color: var(--light);
      padding: 20px;
    }

    .dashboard-container {
      max-width: 1200px;
      margin: auto;
    }

    .logo {
      height: 80px;
      display: block;
      margin: 0 auto 20px;
    }

    .dashboard-title {
      text-align: center;
      color: var(--gold);
      margin-bottom: 30px;
    }

    .stat-card, .nav-card {
      background: rgba(30, 30, 30, 0.8);
      border: 1px solid rgba(255, 215, 0, 0.3);
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      text-align: center;
    }

    .stat-icon, .nav-icon {
      font-size: 24px;
      color: var(--gold);
      margin-bottom: 10px;
    }

    .stat-title {
      font-size: 16px;
      color: var(--light);
    }

    a.nav-card {
      display: block;
      text-decoration: none;
      color: inherit;
    }
  </style>
</head>
<body>
  <div class="dashboard-container">
    <img src="../assets/images/salonlogo.jpg" alt="Elegance Salon" class="logo">
    <h2 class="dashboard-title">Welcome, <?= htmlspecialchars($stylist_name) ?> ✂️</h2>

    <div class="row">
      <!-- Today's Appointments -->
      <div class="col-md-6">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-calendar-check"></i></div>
          <h5 class="text-warning mb-3">Today's Appointments</h5>
          <?php if (mysqli_num_rows($result_today) > 0): ?>
            <ul class="list-group list-group-flush bg-transparent text-white">
              <?php while ($row = mysqli_fetch_assoc($result_today)): ?>
                <li class="list-group-item bg-transparent border-light text-light">
                  <strong><?= date("h:i A", strtotime($row['appointment_time'])) ?></strong> –
                  <?= htmlspecialchars($row['client_name']) ?> 
                  (<?= htmlspecialchars($row['service_name']) ?>)
                </li>
              <?php endwhile; ?>
            </ul>
          <?php else: ?>
            <p class="text-muted">No appointments today.</p>
          <?php endif; ?>
        </div>
      </div>

      <!-- Weekly Schedule -->
      <div class="col-md-6">
        <div class="stat-card">
          <div class="stat-icon"><i class="fas fa-calendar-week"></i></div>
          <h5 class="text-warning mb-3">This Week's Schedule</h5>
          <?php if (mysqli_num_rows($result_schedule) > 0): ?>
            <table class="table table-sm table-bordered text-white">
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
          <?php else: ?>
            <p class="text-muted">No shifts scheduled this week.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>

    <!-- Quick Navigation -->
    <div class="row">
      <div class="col-md-6">
        <a href="my_appointments.php" class="nav-card stat-card">
          <div class="nav-icon"><i class="fas fa-calendar-alt"></i></div>
          <div class="stat-title">My Appointments</div>
        </a>
      </div>
      <div class="col-md-6">
        <a href="my_schedule.php" class="nav-card stat-card">
          <div class="nav-icon"><i class="fas fa-clipboard-list"></i></div>
          <div class="stat-title">My Schedule</div>
        </a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
