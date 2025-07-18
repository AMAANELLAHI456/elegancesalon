<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Add new shift
if (isset($_POST['add_shift'])) {
    $stylist_id = $_POST['stylist_id'];
    $shift_date = $_POST['shift_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    // Combine date and time into datetime format
    $shift_start = $shift_date . ' ' . $start_time;
    $shift_end = $shift_date . ' ' . $end_time;

    $stmt = mysqli_prepare($conn, "INSERT INTO staff_schedule (stylist_id, shift_start, shift_end) VALUES (?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iss", $stylist_id, $shift_start, $shift_end);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Delete shift
if (isset($_GET['delete'])) {
    $schedule_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM staff_schedule WHERE schedule_id = $schedule_id");
    header("Location: staff_schedule.php");
    exit;
}

// Get all schedules with stylist names
$sql = "SELECT ss.schedule_id, u.name AS stylist_name, 
               DATE(ss.shift_start) AS shift_date, 
               TIME(ss.shift_start) AS start_time, 
               TIME(ss.shift_end) AS end_time
        FROM staff_schedule ss
        JOIN users u ON ss.stylist_id = u.user_id
        WHERE u.role_id = 3
        ORDER BY ss.shift_start DESC";
$result = mysqli_query($conn, $sql);

// Get all stylists for dropdown
$stylists = mysqli_query($conn, "SELECT user_id, name FROM users WHERE role_id = 3");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Schedule | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000; /* Pure black */
            --darker-gray: #121212;
            --dark-gray: #1E1E1E;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            min-height: 100vh;
        }
        
        .container {
            background: var(--black);
        }
        
        .schedule-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .schedule-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .form-container {
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .form-label {
            color: var(--gold);
            font-weight: 400;
            margin-bottom: 0.5rem;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            padding: 0.5rem 1rem;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--gold);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15);
        }
        
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
            border: none;
            color: var(--black);
            font-weight: 500;
            letter-spacing: 0.8px;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
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
            background: var(--black);
        }
        
        .table-dark {
            background: rgba(212, 175, 55, 0.1) !important;
            border-color: rgba(212, 175, 55, 0.3);
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
            background: var(--black);
        }
        
        .time-badge {
            background: rgba(212, 175, 55, 0.2);
            color: var(--gold);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 500;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .action-buttons .btn {
            margin-right: 0.5rem;
        }
        
        .action-buttons .btn:last-child {
            margin-right: 0;
        }
        
        .no-shifts {
            color: var(--gold);
            font-style: italic;
            text-align: center;
            padding: 2rem;
            background: var(--black);
        }
        
        /* Ensure header and footer also use black background */
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body style="background: var(--black);">
    <?php include '../includes/header.php'; ?>
    
    <div class="container py-4" style="background: var(--black);">
        <div class="schedule-header">
            <h1 class="schedule-title"><i class="fas fa-calendar-alt me-2"></i>Staff Schedule</h1>
        </div>

        <!-- Add Shift Form -->
        <div class="form-container" style="background: var(--black);">
            <form method="POST" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Stylist</label>
                    <select name="stylist_id" class="form-select" required>
                        <option value="">Select Stylist</option>
                        <?php 
                        mysqli_data_seek($stylists, 0); // Reset pointer
                        while ($s = mysqli_fetch_assoc($stylists)): ?>
                            <option value="<?= $s['user_id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date</label>
                    <input type="date" name="shift_date" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" name="add_shift" class="btn btn-gold w-100">
                        <i class="fas fa-plus-circle me-2"></i>Add Shift
                    </button>
                </div>
            </form>
        </div>

        <!-- Schedule Table -->
        <div class="table-container" style="background: var(--black);">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Stylist</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($result, 0); // Reset pointer
                    if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr style="background: var(--black);">
                                <td><?= htmlspecialchars($row['stylist_name']) ?></td>
                                <td><?= date('M j, Y', strtotime($row['shift_date'])) ?></td>
                                <td><span class="time-badge"><?= date('g:i A', strtotime($row['start_time'])) ?></span></td>
                                <td><span class="time-badge"><?= date('g:i A', strtotime($row['end_time'])) ?></span></td>
                                <td class="action-buttons">
                                    <a href="?delete=<?= $row['schedule_id'] ?>" 
                                       class="btn btn-sm btn-danger"
                                       onclick="return confirm('Are you sure you want to delete this shift?')">
                                        <i class="fas fa-trash-alt me-1"></i>Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="no-shifts">
                                <i class="fas fa-calendar-times me-2"></i>No shifts scheduled yet
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php if (isset($_GET['delete'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Shift Deleted',
                text: 'The shift has been successfully removed.',
                showConfirmButton: false,
                timer: 2000,
                background: '#000000',
                color: '#E0E0E0',
                iconColor: '#D4AF37'
            });
        </script>
    <?php endif; ?>
</body>
</html>