<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/adminheader.php';
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

// Update existing shift
if (isset($_POST['update_shift'])) {
    $schedule_id = $_POST['schedule_id'];
    $stylist_id = $_POST['stylist_id'];
    $shift_date = $_POST['shift_date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    
    // Combine date and time into datetime format
    $shift_start = $shift_date . ' ' . $start_time;
    $shift_end = $shift_date . ' ' . $end_time;

    $stmt = mysqli_prepare($conn, "UPDATE staff_schedule SET stylist_id=?, shift_start=?, shift_end=? WHERE schedule_id=?");
    mysqli_stmt_bind_param($stmt, "issi", $stylist_id, $shift_start, $shift_end, $schedule_id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Delete shift
if (isset($_GET['delete'])) {
    $schedule_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM staff_schedule WHERE schedule_id = $schedule_id");
    echo "<script>window.location.href = 'staff_schedule.php';</script>";
    exit;
}

// Get all schedules with stylist names
$sql = "SELECT ss.schedule_id, ss.stylist_id, u.name AS stylist_name, 
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
            --black: #0F0F0F;
            --darker-gray: #1A1A1A;
            --dark-gray: #252525;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7)), 
                              radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
        }
        
        .schedule-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .schedule-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -10%;
            width: 120%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.05), transparent);
            z-index: -1;
        }
        
        .schedule-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }
        
        .schedule-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--gold);
        }
        
        .form-container {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .form-container:hover {
            box-shadow: 0 15px 35px rgba(212, 175, 55, 0.15);
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .form-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .form-label {
            color: var(--gold);
            font-weight: 400;
            margin-bottom: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .form-control, .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
            border-radius: 6px;
        }
        
        .form-control:focus, .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
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
            padding: 0.7rem 1.8rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border-radius: 6px;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.3);
            color: var(--black);
        }
        
        .btn-gold::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }
        
        .btn-gold:hover::after {
            left: 100%;
        }
        
        .btn-outline-gold {
            background: transparent;
            border: 1px solid var(--gold);
            color: var(--gold);
            transition: all 0.3s ease;
            padding: 0.7rem 1.8rem;
            border-radius: 6px;
        }
        
        .btn-outline-gold:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold);
            transform: translateY(-2px);
        }
        
        .table-container {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }
        
        .table {
            color: var(--light-gray);
            margin-bottom: 0;
        }
        
        .table-dark {
            background: transparent !important;
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(30, 30, 30, 0.9) !important;
            padding: 1.2rem 1rem;
        }
        
        .table th:first-child {
            border-radius: 10px 0 0 0;
        }
        
        .table th:last-child {
            border-radius: 0 10px 0 0;
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(212, 175, 55, 0.05) !important;
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
            min-width: 80px;
        }
        
        .action-buttons .btn:last-child {
            margin-right: 0;
        }
        
        .btn-warning {
            background: rgba(212, 175, 55, 0.8);
            border: none;
            color: var(--black);
            transition: all 0.3s ease;
        }
        
        .btn-warning:hover {
            background: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(212, 175, 55, 0.3);
        }
        
        .btn-danger {
            background: rgba(220, 53, 69, 0.8);
            border: none;
            transition: all 0.3s ease;
        }
        
        .btn-danger:hover {
            background: #dc3545;
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(220, 53, 69, 0.3);
        }
        
        .no-shifts {
            color: var(--gold);
            font-style: italic;
            text-align: center;
            padding: 2rem;
            background: rgba(30, 30, 30, 0.8);
        }
        
        .schedule-stats {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }
        
        .stat-value {
            font-size: 2.2rem;
            font-weight: 300;
            color: var(--gold);
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .table thead {
                display: none;
            }
            
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            
            .table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(212, 175, 55, 0.2);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            .table td:last-child {
                border-bottom: none;
            }
            
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: calc(50% - 1rem);
                padding-right: 10px;
                text-align: left;
                font-weight: 500;
                color: var(--gold);
            }
            
            .action-buttons {
                display: flex;
                justify-content: flex-end;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="schedule-header">
            <h1 class="schedule-title"><i class="fas fa-calendar-alt me-2"></i>Staff Schedule</h1>
            <p class="text-muted mt-2">Manage your stylists' work schedules efficiently</p>
        </div>

        <!-- Schedule Stats -->
        <div class="schedule-stats">
            <div class="row">
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <div class="stat-value">24</div>
                    <div class="stat-label">Shifts This Week</div>
                </div>
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <div class="stat-value">8</div>
                    <div class="stat-label">Stylists</div>
                </div>
                <div class="col-md-3 text-center mb-4 mb-md-0">
                    <div class="stat-value">42</div>
                    <div class="stat-label">Hours Scheduled</div>
                </div>
                <div class="col-md-3 text-center">
                    <div class="stat-value">3</div>
                    <div class="stat-label">Open Shifts</div>
                </div>
            </div>
        </div>

        <!-- Add/Edit Shift Form -->
        <div class="form-container">
            <h3 class="form-title" id="formTitle"><i class="fas fa-plus-circle me-2"></i>Add New Shift</h3>
            <form method="POST" class="row g-3">
                <input type="hidden" name="schedule_id" id="schedule_id" value="">
                
                <div class="col-md-4">
                    <label class="form-label">Stylist</label>
                    <select name="stylist_id" class="form-select" id="stylistSelect" required>
                        <option value="">Select Stylist</option>
                        <?php 
                        mysqli_data_seek($stylists, 0); // Reset pointer
                        while ($s = mysqli_fetch_assoc($stylists)): ?>
                            <option value="<?= $s['user_id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="shift_date" class="form-control" id="shiftDate" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="start_time" class="form-control" id="startTime" required>
                </div>
                <div class="col-md-2">
                    <label class="form-label">End Time</label>
                    <input type="time" name="end_time" class="form-control" id="endTime" required>
                </div>
                <div class="col-md-3 mt-4 pt-2">
                    <button type="submit" name="add_shift" class="btn btn-gold me-2" id="submitButton">
                        <i class="fas fa-plus-circle me-2"></i>Add Shift
                    </button>
                    <button type="button" class="btn btn-outline-gold" id="cancelButton" style="display:none;">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                </div>
            </form>
        </div>

        <!-- Schedule Table -->
        <div class="table-container">
            <div class="table-responsive">
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
                                <tr>
                                    <td data-label="Stylist"><?= htmlspecialchars($row['stylist_name']) ?></td>
                                    <td data-label="Date"><?= date('M j, Y', strtotime($row['shift_date'])) ?></td>
                                    <td data-label="Start Time">
                                        <span class="time-badge"><?= date('g:i A', strtotime($row['start_time'])) ?></span>
                                    </td>
                                    <td data-label="End Time">
                                        <span class="time-badge"><?= date('g:i A', strtotime($row['end_time'])) ?></span>
                                    </td>
                                    <td data-label="Actions" class="action-buttons">
                                        <button class="btn btn-sm btn-warning edit-btn" 
                                                data-id="<?= $row['schedule_id'] ?>"
                                                data-stylist="<?= $row['stylist_id'] ?>"
                                                data-date="<?= $row['shift_date'] ?>"
                                                data-start="<?= $row['start_time'] ?>"
                                                data-end="<?= $row['end_time'] ?>">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </button>
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
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Edit button functionality
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const stylistId = this.getAttribute('data-stylist');
                const date = this.getAttribute('data-date');
                const startTime = this.getAttribute('data-start');
                const endTime = this.getAttribute('data-end');
                
                // Fill form with data
                document.getElementById('schedule_id').value = id;
                document.getElementById('stylistSelect').value = stylistId;
                document.getElementById('shiftDate').value = date;
                document.getElementById('startTime').value = startTime;
                document.getElementById('endTime').value = endTime;
                
                // Change form to edit mode
                document.getElementById('formTitle').innerHTML = '<i class="fas fa-edit me-2"></i>Edit Shift';
                document.getElementById('submitButton').innerHTML = '<i class="fas fa-save me-2"></i>Update Shift';
                document.getElementById('submitButton').name = 'update_shift';
                document.getElementById('cancelButton').style.display = 'inline-block';
                
                // Scroll to form
                document.querySelector('.form-container').scrollIntoView({ 
                    behavior: 'smooth',
                    block: 'center'
                });
                
                // Highlight the row being edited
                document.querySelectorAll('tr').forEach(row => row.classList.remove('table-active'));
                this.closest('tr').classList.add('table-active');
            });
        });
        
        // Cancel button functionality
        document.getElementById('cancelButton').addEventListener('click', function() {
            // Reset form
            document.getElementById('schedule_id').value = '';
            document.getElementById('stylistSelect').value = '';
            document.getElementById('shiftDate').value = '';
            document.getElementById('startTime').value = '';
            document.getElementById('endTime').value = '';
            
            // Reset form to add mode
            document.getElementById('formTitle').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add New Shift';
            document.getElementById('submitButton').innerHTML = '<i class="fas fa-plus-circle me-2"></i>Add Shift';
            document.getElementById('submitButton').name = 'add_shift';
            this.style.display = 'none';
            
            // Remove row highlight
            document.querySelectorAll('tr').forEach(row => row.classList.remove('table-active'));
        });
        
        // Set minimum date to today
        document.getElementById('shiftDate').min = new Date().toISOString().split('T')[0];
    </script>
    <?php include '../includes/adminfooter.php'; ?>
</body>
</html>