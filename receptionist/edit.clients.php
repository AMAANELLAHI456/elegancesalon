<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

if ($_SESSION['role_id'] != 2) {
    header("Location: ../login.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name && $email && $phone) {
        $stmt = mysqli_prepare($conn, "INSERT INTO clients (name, email, phone) VALUES (?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $phone);
        mysqli_stmt_execute($stmt);

        $_SESSION['message'] = "Client added successfully!";
        header("Location: clients.php");
        exit;
    } else {
        $error = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Client | Elegance Salon</title>
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
    </style>
</head>
<body style="background: var(--black);">
    
    
    <div class="container py-5">
        <div class="form-container">
            <h2 class="form-title"><i class="fas fa-user-plus me-2"></i>Add New Client</h2>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-4">
                    <label for="name" class="form-label">Client Name</label>
                    <input type="text" class="form-control" name="name" id="name" required>
                </div>
                
                <div class="mb-4">
                    <label for="email" class="form-label">Client Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                
                <div class="mb-4">
                    <label for="phone" class="form-label">Client Phone</label>
                    <input type="text" class="form-control" name="phone" id="phone" required>
                </div>
                
                <div class="d-flex justify-content-end mt-4">
                    <a href="clients.php" class="btn btn-outline-gold me-3">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Add Client
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/receptionfooter.php'; ?>
</body>
</html>