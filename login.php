<?php
// login.php
session_start();
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $sql  = "SELECT user_id, name, password, role_id FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if (mysqli_stmt_num_rows($stmt) === 1) {
            mysqli_stmt_bind_result($stmt, $user_id, $name, $hashed_password, $role_id);
            mysqli_stmt_fetch($stmt);

            if (password_verify($password, $hashed_password)) {
                // Login success
                $_SESSION['user_id']  = $user_id;
                $_SESSION['name']     = $name;
                $_SESSION['role_id']  = $role_id;

                // Redirect based on role
                if ($role_id == 1) {
                    header('Location: ' . BASE_URL . 'admin/dashboard.php');
                } elseif ($role_id == 2) {
                    header('Location: ' . BASE_URL . 'receptionist/dashboard.php');
                } elseif ($role_id == 3) {
                    header('Location: ' . BASE_URL . 'stylist/dashboard.php');
                } else {
                    header('Location: ' . BASE_URL . 'index.php');
                }
                exit;
            } else {
                $error = "Incorrect password. Try again.";
            }
        } else {
            $error = "No account found with that email.";
        }
        mysqli_stmt_close($stmt);
    } else {
        $error = "Something went wrong. Please try again later.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #121212;
            --dark-gray: #1E1E1E;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            height: 100vh;
            overflow: hidden;
        }
        
        .login-container {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
            background: radial-gradient(circle at center, var(--dark-gray) 0%, var(--black) 100%);
        }
        
        .login-card {
            background: var(--dark-gray);
            border: 1px solid var(--gold);
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.2);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: -20px;
            right: -20px;
            width: 100px;
            height: 100px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            z-index: 0;
        }
        
        .login-card::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 150px;
            height: 150px;
            background: rgba(212, 175, 55, 0.05);
            border-radius: 50%;
            z-index: 0;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        
        .logo-container img {
            max-width: 180px;
            height: auto;
            margin-bottom: 1.5rem;
        }
        
        .login-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            margin-bottom: 0.5rem;
            font-size: 1.8rem;
            position: relative;
            z-index: 1;
        }
        
        .login-subtitle {
            color: #aaa;
            font-size: 0.9rem;
            margin-bottom: 2rem;
            position: relative;
            z-index: 1;
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid #333;
            color: var(--light-gray);
            padding: 14px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.1);
            border-color: var(--gold);
            color: white;
            box-shadow: 0 0 0 0.25rem rgba(212, 175, 55, 0.15);
        }
        
        .input-group-text {
            background-color: rgba(212, 175, 55, 0.1);
            border: 1px solid #333;
            color: var(--gold);
        }
        
        .btn-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--dark-gold) 100%);
            border: none;
            color: #000;
            font-weight: 600;
            padding: 14px;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            position: relative;
            z-index: 1;
            margin-top: 1rem;
        }
        
        .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(212, 175, 55, 0.4);
        }
        
        .btn-gold:active {
            transform: translateY(0);
        }
        
        label {
            color: var(--gold);
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            position: relative;
            z-index: 1;
        }
        
        .alert-danger {
            background-color: rgba(212, 50, 55, 0.1);
            border: 1px solid #D43237;
            color: #ff6b6b;
            border-radius: 8px;
            padding: 12px 15px;
            position: relative;
            z-index: 1;
        }
        
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
            }
            
            .logo-container img {
                max-width: 140px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Logo Space -->
            <div class="logo-container">
                <!-- Replace with your actual logo -->
                <img src="assets/images/salonlogo.jpg" alt="Elegance Salon Logo" width="80px" height="80px">
                <h1 class="login-title">Elegance Salon</h1>
                <p class="login-subtitle">Professional Beauty Management System</p>
            </div>
            
            <?php if ($error): ?>
                <div class="alert alert-danger mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="mb-4">
                    <label for="email">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input id="email" type="email" name="email" class="form-control" required autofocus>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                        <input id="password" type="password" name="password" class="form-control" required>
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-gold" type="submit">
                        <i class="fas fa-sign-in-alt me-2"></i> Login
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>