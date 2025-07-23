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
$client_id = $service_id = $stylist_id = '';
$appointment_time = '';

// Fetch clients, services, and stylists for dropdowns
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

    // Get service price
    $service_query = mysqli_query($conn, "SELECT price FROM services WHERE service_id = '$service_id'");
    $service = mysqli_fetch_assoc($service_query);
    $appointment_cost = $service['price'];

    // Validation
    if (empty($client_id)) $errors[] = "Client is required";
    if (empty($service_id)) $errors[] = "Service is required";
    if (empty($appointment_time)) $errors[] = "Appointment time is required";

    // If no errors, insert into database
    if (empty($errors)) {
        $sql = "INSERT INTO appointments (client_id, service_id, stylist_id, appointment_time, appointment_cost, status)
                VALUES ('$client_id', '$service_id', " . ($stylist_id ? "'$stylist_id'" : "NULL") . ", 
                '$appointment_time', '$appointment_cost', 'booked')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['message'] = "Appointment added successfully!";
            header("Location: appointments.php");
            exit;
        } else {
            $errors[] = "Error adding appointment: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000;
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
        
        .services-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .services-title {
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
        
        .btn-outline-gold {
            border: 1px solid var(--gold);
            color: var(--gold);
            background: transparent;
        }
        
        .btn-outline-gold:hover {
            background: var(--gold);
            color: var(--black);
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-left: 4px solid #dc3545;
            color: var(--light-gray);
        }
        
        .rupee-symbol {
            color: var(--gold);
            font-weight: 500;
        }
        
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body style="background: var(--black);">
    <?php include '../includes/header.php'; ?>
    
    <div class="container py-4" style="background: var(--black);">
        <div class="services-header">
            <h1 class="services-title"><i class="fas fa-calendar-plus me-2"></i>Add New Appointment</h1>
        </div>

        <!-- Display errors -->
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger mb-4">
                <h5 class="alert-heading"><i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:</h5>
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Appointment Form -->
        <div class="form-container">
            <form method="POST" action="add_appointment.php">
                <div class="row g-3">
                    <!-- Client Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Client *</label>
                        <select class="form-select" name="client_id" required>
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
                        <label class="form-label">Service *</label>
                        <select class="form-select" name="service_id" required>
                            <option value="">Select a service</option>
                            <?php while ($service = mysqli_fetch_assoc($services)): ?>
                                <option value="<?= $service['service_id'] ?>" <?= ($service_id == $service['service_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($service['service_name']) ?> (<span class="rupee-symbol">Rs.</span> <?= number_format($service['price'], 2) ?>)
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Stylist Selection -->
                    <div class="col-md-6">
                        <label class="form-label">Stylist</label>
                        <select class="form-select" name="stylist_id">
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
                        <label class="form-label">Appointment Time *</label>
                        <input type="datetime-local" class="form-control" name="appointment_time" 
                               value="<?= htmlspecialchars($appointment_time) ?>" required>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-gold me-2">
                            <i class="fas fa-save me-2"></i>Save Appointment
                        </button>
                        <a href="appointments.php" class="btn btn-outline-gold">
                            <i class="fas fa-times me-2"></i>Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/footer.php'; ?>
</body>
</html>