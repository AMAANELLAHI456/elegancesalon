<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 3) {
    header("Location: ../login.php");
    exit;
}

$stylist_id = $_SESSION['user_id'];

// Fetch stylist weekly schedule
$sql = "
    SELECT shift_start, shift_end 
    FROM staff_schedule 
    WHERE stylist_id = ? AND WEEK(shift_start) = WEEK(CURDATE())
    ORDER BY shift_start ASC
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
  <title>My Schedule | Stylist</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #000;
      color: #eee;
      padding: 20px;
    }
    .container {
      max-width: 900px;
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
    <h2 class="text-center text-warning mb-4">My Weekly Schedule</h2>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <table class="table table-dark table-bordered table-striped">
        <thead>
          <tr>
            <th>Date</th>
            <th>Shift Start</th>
            <th>Shift End</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= date('D, M d', strtotime($row['shift_start'])) ?></td>
              <td><?= date('h:i A', strtotime($row['shift_start'])) ?></td>
              <td><?= date('h:i A', strtotime($row['shift_end'])) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-muted">You have no scheduled shifts this week.</p>
    <?php endif; ?>
  </div>
</body>
</html>
