<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

// Check if user is receptionist
if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Get payment ID from query string
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Payment ID not provided.";
    header("Location: payments.php");
    exit;
}
$payment_id = intval($_GET['id']);

// Fetch existing payment details
$result = mysqli_query($conn, "SELECT * FROM payments WHERE payment_id = $payment_id");
if (mysqli_num_rows($result) != 1) {
    $_SESSION['error'] = "Payment not found.";
    header("Location: payments.php");
    exit;
}
$payment = mysqli_fetch_assoc($result);

// Fetch appointment list for dropdown
$appointments = mysqli_query($conn, "SELECT a.appointment_id, c.name AS client_name FROM appointments a JOIN clients c ON a.client_id = c.client_id");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appointment_id = intval($_POST['appointment_id']);
    $amount = floatval($_POST['amount']);
    $payment_date = mysqli_real_escape_string($conn, $_POST['payment_date']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);

    $update = "UPDATE payments SET appointment_id = $appointment_id, amount = $amount,
               payment_date = '$payment_date', method = '$method' WHERE payment_id = $payment_id";

    if (mysqli_query($conn, $update)) {
        $_SESSION['message'] = "Payment updated successfully!";
        header("Location: payments.php");
        exit;
    } else {
        $error = "Error updating payment: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #000000;
            --light-gray: #E0E0E0;
        }
        
        body {
            background-color: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', sans-serif;
        }
        
        .form-container {
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            padding: 2rem;
            max-width: 700px;
            margin: 0 auto;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        
        .form-title {
            color: var(--gold);
            font-weight: 300;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .form-label {
            color: var(--gold);
            font-weight: 400;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            padding: 0.75rem 1rem;
        }
        
        .form-control:focus {
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
            padding: 0.75rem 1.5rem;
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
            padding: 0.75rem 1.5rem;
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
        
        .method-select {
            text-transform: capitalize;
        }
    </style>
</head>
<body style="background: var(--black);">
    <?php include '../includes/receptionheader.php'; ?>

    <div class="container py-5">
        <div class="form-container">
            <h2 class="form-title"><i class="fas fa-edit me-2"></i>Edit Payment #<?= $payment_id ?></h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label class="form-label">Appointment</label>
                    <select name="appointment_id" class="form-control" required>
                        <?php while ($row = mysqli_fetch_assoc($appointments)) : ?>
                            <option value="<?= $row['appointment_id'] ?>" <?= $payment['appointment_id'] == $row['appointment_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($row['client_name']) ?> (ID: <?= $row['appointment_id'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Amount</label>
                    <div class="input-group">
                        <span class="input-group-text rupee-symbol">Rs.</span>
                        <input type="number" step="0.01" name="amount" class="form-control" value="<?= htmlspecialchars($payment['amount']) ?>" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label">Payment Date</label>
                    <input type="date" name="payment_date" class="form-control" value="<?= htmlspecialchars($payment['payment_date']) ?>" required>
                </div>

                <div class="mb-4">
                    <label class="form-label">Method</label>
                    <select name="method" class="form-control method-select" required>
                        <option value="Cash" <?= $payment['method'] == 'Cash' ? 'selected' : '' ?>>Cash</option>
                        <option value="Card" <?= $payment['method'] == 'Card' ? 'selected' : '' ?>>Card</option>
                        <option value="Online" <?= $payment['method'] == 'Online' ? 'selected' : '' ?>>Online</option>
                    </select>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="payments.php" class="btn btn-outline-gold me-3">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Update Payment
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/receptionfooter.php'; ?>
</body>
</html>