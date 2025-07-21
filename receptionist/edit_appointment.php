<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Initialize variables
$errors = [];
$success = false;

// Get appointment ID from URL
$appointment_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch appointment details
$appointment_query = mysqli_query($conn, "SELECT * FROM appointments WHERE appointment_id = '$appointment_id'");
$appointment = mysqli_fetch_assoc($appointment_query);

if (!$appointment) {
    $_SESSION['error'] = "Appointment not found";
    header("Location: appointments.php");
    exit;
}

// Fetch dropdown data
$clients = mysqli_query($conn, "SELECT client_id, name, phone FROM clients ORDER BY name");
$services = mysqli_query($conn, "SELECT service_id, service_name, price FROM services ORDER BY service_name");
$stylists = mysqli_query($conn, "SELECT user_id, name FROM users WHERE role_id = 3 ORDER BY name"); // role_id 3 = stylist

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $client_id = mysqli_real_escape_string($conn, $_POST['client_id']);
    $service_id = mysqli_real_escape_string($conn, $_POST['service_id']);
    $stylist_id = mysqli_real_escape_string($conn, $_POST['stylist_id']);
    $appointment_time = mysqli_real_escape_string($conn, $_POST['appointment_time']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Get service price
    $service_query = mysqli_query($conn, "SELECT price FROM services WHERE service_id = '$service_id'");
    $service = mysqli_fetch_assoc($service_query);
    $appointment_cost = $service['price'];

    // Validation
    if (empty($client_id)) $errors[] = "Client is required";
    if (empty($service_id)) $errors[] = "Service is required";
    if (empty($appointment_time)) $errors[] = "Appointment time is required";
    if (empty($status)) $errors[] = "Status is required";

    // If no errors, update database
    if (empty($errors)) {
        $sql = "UPDATE appointments SET
                client_id = '$client_id',
                service_id = '$service_id',
                stylist_id = " . ($stylist_id ? "'$stylist_id'" : "NULL") . ",
                appointment_time = '$appointment_time',
                appointment_cost = '$appointment_cost',
                status = '$status'
                WHERE appointment_id = '$appointment_id'";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Appointment updated successfully!";
            header("Location: appointments.php");
            exit;
        } else {
            $errors[] = "Error updating appointment: " . mysqli_error($conn);
        }
    }
} else {
    // Pre-fill form with existing data
    $client_id = $appointment['client_id'];
    $service_id = $appointment['service_id'];
    $stylist_id = $appointment['stylist_id'];
    $appointment_time = date('Y-m-d\TH:i', strtotime($appointment['appointment_time']));
    $status = $appointment['status'];
}
?>

<?php include '../includes/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Edit Appointment #<?= $appointment_id ?></h4>
                </div>
                <div class="card-body">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach ($errors as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="edit_appointment.php?id=<?= $appointment_id ?>">
                        <div class="row g-3">
                            <!-- Client Selection -->
                            <div class="col-md-6">
                                <label for="client_id" class="form-label">Client *</label>
                                <select class="form-select" id="client_id" name="client_id" required>
                                    <option value="">Select a client</option>
                                    <?php while ($client = mysqli_fetch_assoc($clients)): ?>
                                        <option value="<?= $client['client_id'] ?>" <?= ($client_id == $client['client_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($client['name']) ?> (<?= htmlspecialchars($client['phone']) ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Service Selection -->
                            <div class="col-md-6">
                                <label for="service_id" class="form-label">Service *</label>
                                <select class="form-select" id="service_id" name="service_id" required>
                                    <option value="">Select a service</option>
                                    <?php while ($service = mysqli_fetch_assoc($services)): ?>
                                        <option value="<?= $service['service_id'] ?>" <?= ($service_id == $service['service_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($service['service_name']) ?> ($<?= number_format($service['price'], 2) ?>)
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Stylist Selection -->
                            <div class="col-md-6">
                                <label for="stylist_id" class="form-label">Stylist</label>
                                <select class="form-select" id="stylist_id" name="stylist_id">
                                    <option value="">No stylist assigned</option>
                                    <?php while ($stylist = mysqli_fetch_assoc($stylists)): ?>
                                        <option value="<?= $stylist['user_id'] ?>" <?= ($stylist_id == $stylist['user_id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($stylist['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <!-- Appointment Time -->
                            <div class="col-md-6">
                                <label for="appointment_time" class="form-label">Appointment Time *</label>
                                <input type="datetime-local" class="form-control" id="appointment_time" 
                                       name="appointment_time" value="<?= htmlspecialchars($appointment_time) ?>" required>
                            </div>

                            <!-- Status Selection -->
                            <div class="col-md-6">
                                <label for="status" class="form-label">Status *</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="booked" <?= ($status == 'booked') ? 'selected' : '' ?>>Booked</option>
                                    <option value="completed" <?= ($status == 'completed') ? 'selected' : '' ?>>Completed</option>
                                    <option value="cancelled" <?= ($status == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                                </select>
                            </div>

                            <!-- Buttons -->
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-primary me-2">
                                    <i class="fas fa-save"></i> Update Appointment
                                </button>
                                <a href="appointments.php" class="btn btn-outline-secondary">
                                    <i class="fas fa-times"></i> Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>