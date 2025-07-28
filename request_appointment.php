<?php
require_once 'includes/db.php';
$services = mysqli_query($conn, "SELECT service_id, service_name FROM services");
?>

<?php include 'includes/header.php'; ?>

<h2>Request an Appointment</h2>

<form action="request_appointment_submit.php" method="POST">
    <div class="form-group">
        <label>Client Name</label>
        <input type="text" name="client_name" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Phone</label>
        <input type="text" name="client_phone" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Select Service</label>
        <select name="service_id" class="form-control" required>
            <option value="">-- Select Service --</option>
            <?php while ($row = mysqli_fetch_assoc($services)): ?>
                <option value="<?= $row['service_id'] ?>"><?= htmlspecialchars($row['service_name']) ?></option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group">
        <label>Preferred Appointment Time</label>
        <input type="datetime-local" name="appointment_time" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Request Appointment</button>
</form>

<?php include 'includes/footer.php'; ?>
