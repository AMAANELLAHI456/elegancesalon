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
    <title>Staff Schedule - Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <div class="container py-5">
        <h2 class="mb-4">Staff Schedule</h2>

        <!-- Add Shift Form -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Add New Shift</h5>
            </div>
            <div class="card-body">
                <form method="POST" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Stylist:</label>
                        <select name="stylist_id" class="form-select" required>
                            <option value="">Select Stylist</option>
                            <?php while ($s = mysqli_fetch_assoc($stylists)): ?>
                                <option value="<?= $s['user_id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Date:</label>
                        <input type="date" name="shift_date" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Start Time:</label>
                        <input type="time" name="start_time" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">End Time:</label>
                        <input type="time" name="end_time" class="form-control" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" name="add_shift" class="btn btn-primary w-100">Add Shift</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Schedule Table -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Current Schedule</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Stylist</th>
                                <th>Date</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($result) > 0): ?>
                                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['stylist_name']) ?></td>
                                        <td><?= date('M j, Y', strtotime($row['shift_date'])) ?></td>
                                        <td><?= date('g:i A', strtotime($row['start_time'])) ?></td>
                                        <td><?= date('g:i A', strtotime($row['end_time'])) ?></td>
                                        <td>
                                            <a href="?delete=<?= $row['schedule_id'] ?>" onclick="return confirm('Are you sure you want to delete this shift?')" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i> Delete
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No shifts scheduled yet.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include '../includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php if (isset($_GET['delete'])): ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Shift Deleted',
                text: 'The shift has been successfully deleted.',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    <?php endif; ?>
</body>
</html>