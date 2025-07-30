<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/stylistheader.php';
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Schedule | Stylist</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #FFD700;
      --dark-gold: #D4AF37;
      --black: #121212;
      --light-black: #1E1E1E;
    }
    
    body {
      background-color: var(--black);
      color: #eee;
      padding-top: 20px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    .container {
      max-width: 1000px;
      margin: auto;
      padding: 0 15px;
    }
    
    .schedule-header {
      border-bottom: 2px solid var(--gold);
      padding-bottom: 15px;
      margin-bottom: 30px;
    }
    
    .table {
      background-color: var(--light-black);
      border-radius: 8px;
      overflow: hidden;
    }
    
    .table thead {
      background-color: var(--gold);
      color: #000;
      font-weight: 600;
    }
    
    .table th {
      padding: 15px;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-size: 0.85rem;
    }
    
    .table td {
      padding: 12px 15px;
      vertical-align: middle;
      border-color: #333;
    }
    
    .table tbody tr {
      transition: all 0.2s ease;
    }
    
    .table tbody tr:hover {
      background-color: rgba(255, 215, 0, 0.1);
      transform: translateX(2px);
    }
    
    .shift-day {
      font-weight: 600;
      color: var(--gold);
    }
    
    .shift-time {
      font-family: 'Courier New', monospace;
      background-color: rgba(255, 255, 255, 0.1);
      padding: 3px 8px;
      border-radius: 4px;
      display: inline-block;
    }
    
    .no-shifts {
      background-color: var(--light-black);
      padding: 30px;
      border-radius: 8px;
      text-align: center;
      border: 1px dashed #333;
    }
    
    .no-shifts-icon {
      font-size: 3rem;
      color: #333;
      margin-bottom: 15px;
    }
    
    .week-nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .week-title {
      font-size: 1.2rem;
      font-weight: 600;
      color: var(--gold);
    }
    
    .btn-gold {
      background-color: var(--gold);
      color: #000;
      font-weight: 600;
      border: none;
    }
    
    .btn-gold:hover {
      background-color: var(--dark-gold);
      color: #000;
    }
    
    @media (max-width: 768px) {
      .table-responsive {
        border-radius: 0;
      }
      
      .table thead {
        display: none;
      }
      
      .table tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #333;
        border-radius: 8px;
      }
      
      .table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none;
      }
      
      .table td:before {
        content: attr(data-label);
        font-weight: bold;
        color: var(--gold);
        margin-right: 15px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="schedule-header">
      <h2 class="text-warning mb-0"><i class="fas fa-calendar-alt me-2"></i>My Weekly Schedule</h2>
    </div>
    
    <div class="week-nav">
      <span class="week-title">
        Week of <?= date('F j, Y', strtotime('this week')) ?>
      </span>
      <div>
        <button class="btn btn-sm btn-gold me-2">
          <i class="fas fa-chevron-left me-1"></i> Previous
        </button>
        <button class="btn btn-sm btn-outline-warning">
          Today
        </button>
        <button class="btn btn-sm btn-gold ms-2">
          Next <i class="fas fa-chevron-right ms-1"></i>
        </button>
      </div>
    </div>

    <?php if (mysqli_num_rows($result) > 0): ?>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th><i class="far fa-calendar me-2"></i>Date</th>
              <th><i class="far fa-clock me-2"></i>Shift Start</th>
              <th><i class="far fa-clock me-2"></i>Shift End</th>
              <th><i class="fas fa-info-circle me-2"></i>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): 
              $current_shift = (strtotime($row['shift_start']) <= time() && time() <= strtotime($row['shift_end']));
            ?>
              <tr>
                <td data-label="Date">
                  <span class="shift-day"><?= date('l', strtotime($row['shift_start'])) ?></span><br>
                  <?= date('M j, Y', strtotime($row['shift_start'])) ?>
                </td>
                <td data-label="Shift Start">
                  <span class="shift-time"><?= date('h:i A', strtotime($row['shift_start'])) ?></span>
                </td>
                <td data-label="Shift End">
                  <span class="shift-time"><?= date('h:i A', strtotime($row['shift_end'])) ?></span>
                </td>
                <td data-label="Status">
                  <?php if ($current_shift): ?>
                    <span class="badge bg-success"><i class="fas fa-circle-notch fa-spin me-1"></i> In Progress</span>
                  <?php elseif (strtotime($row['shift_start']) > time()): ?>
                    <span class="badge bg-primary"><i class="fas fa-clock me-1"></i> Upcoming</span>
                  <?php else: ?>
                    <span class="badge bg-secondary"><i class="fas fa-check me-1"></i> Completed</span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <div class="no-shifts">
        <div class="no-shifts-icon">
          <i class="far fa-calendar-times"></i>
        </div>
        <h4 class="text-warning">No Scheduled Shifts</h4>
        <p class="">You don't have any shifts scheduled for this week.</p>
        <button class="btn btn-gold mt-2">
          <i class="fas fa-plus me-1"></i> Request Shifts
        </button>
      </div>
    <?php endif; ?>
  </div>
  <?php include '../includes/stylistfooter.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>