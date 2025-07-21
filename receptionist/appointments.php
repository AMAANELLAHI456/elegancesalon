<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = mysqli_real_escape_string($conn, $_GET['delete_id']);
    $delete_sql = "DELETE FROM appointments WHERE appointment_id = '$delete_id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        $_SESSION['message'] = "Appointment deleted successfully";
        header("Location: appointments.php");
        exit;
    } else {
        $_SESSION['error'] = "Error deleting appointment: " . mysqli_error($conn);
    }
}

// Fetch all appointments with related data
$sql = "SELECT a.appointment_id, a.appointment_time, a.status, a.appointment_cost,
               c.name AS client_name, c.phone AS client_phone,
               s.service_name, s.price AS service_price,
               u.name AS stylist_name
        FROM appointments a
        JOIN clients c ON a.client_id = c.client_id
        JOIN services s ON a.service_id = s.service_id
        LEFT JOIN users u ON a.stylist_id = u.user_id
        ORDER BY a.appointment_time DESC";

$result = mysqli_query($conn, $sql);
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Manage Appointments</h2>
        <a href="add_appointment.php" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Appointment
        </a>
    </div>

    <!-- Display messages -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?php unset($_SESSION['message']); ?>
        </div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?= $_SESSION['error']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Client</th>
                            <th>Service</th>
                            <th>Stylist</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Cost</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['appointment_id']) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($row['client_name']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($row['client_phone']) ?></small>
                                </td>
                                <td>
                                    <?= htmlspecialchars($row['service_name']) ?><br>
                                    <small class="text-muted">$<?= number_format($row['service_price'], 2) ?></small>
                                </td>
                                <td><?= htmlspecialchars($row['stylist_name'] ?? 'Not assigned') ?></td>
                                <td><?= date('M j, Y g:i A', strtotime($row['appointment_time'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= 
                                        $row['status'] == 'completed' ? 'success' : 
                                        ($row['status'] == 'cancelled' ? 'danger' : 'primary') 
                                    ?>">
                                        <?= ucfirst($row['status']) ?>
                                    </span>
                                </td>
                                <td>$<?= number_format($row['appointment_cost'], 2) ?></td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <!-- View Button with Modal Trigger -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" 
                                                data-bs-target="#viewModal<?= $row['appointment_id'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        
                                        <!-- Edit Button -->
                                        <a href="edit_appointment.php?id=<?= $row['appointment_id'] ?>" 
                                           class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Delete Button -->
                                        <a href="appointments.php?delete_id=<?= $row['appointment_id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Are you sure you want to delete this appointment?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                    
                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal<?= $row['appointment_id'] ?>" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Appointment #<?= $row['appointment_id'] ?> Details</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <h6>Client Information</h6>
                                                        <p><strong>Name:</strong> <?= htmlspecialchars($row['client_name']) ?></p>
                                                        <p><strong>Phone:</strong> <?= htmlspecialchars($row['client_phone']) ?></p>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <h6>Service Details</h6>
                                                        <p><strong>Service:</strong> <?= htmlspecialchars($row['service_name']) ?></p>
                                                        <p><strong>Service Price:</strong> $<?= number_format($row['service_price'], 2) ?></p>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <h6>Appointment Information</h6>
                                                        <p><strong>Date & Time:</strong> <?= date('F j, Y, g:i a', strtotime($row['appointment_time'])) ?></p>
                                                        <p><strong>Assigned Stylist:</strong> <?= htmlspecialchars($row['stylist_name'] ?? 'Not assigned') ?></p>
                                                        <p><strong>Status:</strong> <span class="badge bg-<?= 
                                                            $row['status'] == 'completed' ? 'success' : 
                                                            ($row['status'] == 'cancelled' ? 'danger' : 'primary') 
                                                        ?>"><?= ucfirst($row['status']) ?></span></p>
                                                        <p><strong>Total Cost:</strong> $<?= number_format($row['appointment_cost'], 2) ?></p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>