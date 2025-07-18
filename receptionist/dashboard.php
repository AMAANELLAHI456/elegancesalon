<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Only allow receptionists
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Count total appointments
$appt_result = mysqli_query($conn, "SELECT COUNT(*) AS total_appts FROM appointments");
$appt_data = mysqli_fetch_assoc($appt_result);

// Count total clients
$client_result = mysqli_query($conn, "SELECT COUNT(*) AS total_clients FROM clients");
$client_data = mysqli_fetch_assoc($client_result);

// Count pending payments
$pending_payments_result = mysqli_query($conn, "SELECT COUNT(*) AS total_pending FROM payments WHERE status = 'Pending'");
$pending_payments_data = mysqli_fetch_assoc($pending_payments_result);
?>

<?php include '../includes/header.php'; ?>

<h2>Receptionist Dashboard</h2>
<div class="row mt-4">
    <!-- Total Appointments -->
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Appointments</h5>
                <p class="card-text fs-4"><?= $appt_data['total_appts'] ?></p>
            </div>
        </div>
    </div>

    <!-- Total Clients -->
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Total Clients</h5>
                <p class="card-text fs-4"><?= $client_data['total_clients'] ?></p>
            </div>
        </div>
    </div>

    <!-- Pending Payments -->
    <div class="col-md-4">
        <div class="card text-white bg-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Pending Payments</h5>
                <p class="card-text fs-4"><?= $pending_payments_data['total_pending'] ?></p>
            </div>
        </div>
    </div>
</div>

<!-- Quick Access Buttons -->
<div class="row mt-4">
    <div class="col-md-4">
        <a href="appointments.php" class="btn btn-outline-dark w-100">Manage Appointments</a>
    </div>
    <div class="col-md-4">
        <a href="clients.php" class="btn btn-outline-dark w-100">Manage Clients</a>
    </div>
    <div class="col-md-4">
        <a href="payments.php" class="btn btn-outline-dark w-100">Manage Payments</a>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
