<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';

$client = null;
$error = '';

// Fetch client data for editing
if (isset($_GET['client_id']) && is_numeric($_GET['client_id'])) {
    $client_id = intval($_GET['client_id']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM clients WHERE client_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $client_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $client = mysqli_fetch_assoc($result);
    
    if (!$client) {
        $_SESSION['error'] = "Client not found";
        header("Location: clients.php");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid client ID";
    header("Location: clients.php");
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $client_id = intval($_POST['client_id']);

    if ($name && $email && $phone) {
        $stmt = mysqli_prepare($conn, "UPDATE clients SET name = ?, email = ?, phone = ? WHERE client_id = ?");
        mysqli_stmt_bind_param($stmt, "sssi", $name, $email, $phone, $client_id);
        mysqli_stmt_execute($stmt);

        $_SESSION['message'] = "Client updated successfully!";
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
    <title>Edit Client | Elegance Salon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7)), 
                              radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
        }
        
        .navbar {
            background: var(--black) !important;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.5);
        }
        
        .brand {
            color: var(--gold) !important;
            font-weight: 300;
            letter-spacing: 2px;
            font-size: 1.8rem;
        }
        
        .brand span {
            color: white;
            font-weight: 200;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.7) !important;
            transition: all 0.3s ease;
            position: relative;
            padding: 0.5rem 1rem;
            font-weight: 300;
            letter-spacing: 0.5px;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--gold) !important;
        }
        
        .form-container {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 2.5rem;
            margin: 2rem auto;
            max-width: 700px;
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
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            position: relative;
        }
        
        .form-title::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--gold);
        }
        
        .form-label {
            color: var(--gold);
            font-weight: 400;
            margin-bottom: 0.8rem;
            letter-spacing: 0.5px;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: var(--light-gray);
            padding: 0.8rem 1.2rem;
            transition: all 0.3s ease;
            border-radius: 6px;
        }
        
        .form-control:focus {
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
        
        .alert {
            border-radius: 6px;
            border-left: 4px solid;
        }
        
        .alert-danger {
            border-left-color: #dc3545;
        }
        
        .form-icon {
            position: absolute;
            right: 1.5rem;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(212, 175, 55, 0.7);
            font-size: 1.2rem;
        }
        
        .input-group {
            position: relative;
        }
        
        .client-details-preview {
            background: rgba(30, 30, 30, 0.6);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
        }
        
        .client-details-preview h5 {
            color: var(--gold);
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            padding-bottom: 0.8rem;
            margin-bottom: 1.5rem;
        }
        
        .detail-item {
            display: flex;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        
        .detail-label {
            width: 120px;
            color: var(--gold);
            font-weight: 500;
        }
        
        .detail-value {
            flex: 1;
        }
        
        .footer {
            background: var(--black) !important;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
            padding: 1.5rem 0;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .form-container {
                padding: 1.5rem;
            }
            
            .form-title {
                font-size: 1.5rem;
            }
            
            .detail-item {
                flex-direction: column;
            }
            
            .detail-label {
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>
<body style="background: var(--black);">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container">
            <a class="navbar-brand brand" href="#">
                <i class="fas fa-crown me-2"></i>ELEGANCE<span>SALON</span>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-home me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-calendar-alt me-1"></i> Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="fas fa-users me-1"></i> Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-scissors me-1"></i> Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user-tie me-1"></i> Stylists</a>
                    </li>
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-sm btn-gold" href="#"><i class="fas fa-plus me-1"></i> New Client</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container py-5">
        <div class="form-container">
            <h2 class="form-title"><i class="fas fa-user-edit me-2"></i>Edit Client</h2>

            <?php if ($error): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i><?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <!-- Client Preview -->
            <div class="client-details-preview">
                <h5><i class="fas fa-user me-2"></i>Client Information</h5>
                <div class="detail-item">
                    <div class="detail-label">Client ID:</div>
                    <div class="detail-value">#<?= htmlspecialchars($client['client_id']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Name:</div>
                    <div class="detail-value"><?= htmlspecialchars($client['name']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Email:</div>
                    <div class="detail-value"><?= htmlspecialchars($client['email']) ?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-label">Phone:</div>
                    <div class="detail-value"><?= htmlspecialchars($client['phone']) ?></div>
                </div>
            </div>

            <form method="post" action="">
                <input type="hidden" name="client_id" value="<?= $client['client_id'] ?>">
                
                <div class="mb-4 position-relative">
                    <label for="name" class="form-label">Client Name</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="name" id="name" 
                               value="<?= htmlspecialchars($client['name']) ?>" required>
                        <i class="fas fa-user form-icon"></i>
                    </div>
                </div>
                
                <div class="mb-4 position-relative">
                    <label for="email" class="form-label">Client Email</label>
                    <div class="input-group">
                        <input type="email" class="form-control" name="email" id="email" 
                               value="<?= htmlspecialchars($client['email']) ?>" required>
                        <i class="fas fa-envelope form-icon"></i>
                    </div>
                </div>
                
                <div class="mb-4 position-relative">
                    <label for="phone" class="form-label">Client Phone</label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="phone" id="phone" 
                               value="<?= htmlspecialchars($client['phone']) ?>" required>
                        <i class="fas fa-phone form-icon"></i>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-5 pt-3 border-top border-secondary">
                    <a href="clients.php" class="btn btn-outline-gold me-3">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                    <button type="submit" class="btn btn-gold">
                        <i class="fas fa-save me-2"></i>Update Client
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-md-0">&copy; 2023 Elegance Salon. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="social-icons">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-pinterest"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add subtle animation to form elements
        document.addEventListener('DOMContentLoaded', function() {
            const formElements = document.querySelectorAll('.form-control');
            
            formElements.forEach((element, index) => {
                setTimeout(() => {
                    element.style.opacity = '1';
                    element.style.transform = 'translateY(0)';
                }, 150 * index);
            });
            
            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>