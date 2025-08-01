<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f9f4f0 0%, #e8dfd5 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin: 20px;
            position: relative;
        }

        .header {
            background: linear-gradient(to right, #8a6d62, #5d4037);
            color: white;
            padding: 35px 30px;
            text-align: center;
            position: relative;
        }

        .header h2 {
            font-size: 2.4rem;
            margin-bottom: 10px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        .logo {
            position: absolute;
            top: 20px;
            left: 30px;
            font-size: 1.8rem;
            font-weight: bold;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .logo i {
            margin-right: 10px;
            color: #ffd54f;
        }

        .confirmation-container {
            padding: 50px 40px;
            text-align: center;
        }

        .alert-success {
            background: linear-gradient(135deg, #e8f5e9, #c8e6c9);
            border-radius: 16px;
            padding: 40px 30px;
            border-left: 6px solid #43a047;
            box-shadow: 0 6px 20px rgba(67, 160, 71, 0.2);
            position: relative;
            overflow: hidden;
            max-width: 600px;
            margin: 0 auto;
        }

        .alert-success::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 150px;
            height: 150px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            z-index: 0;
        }

        .alert-success::after {
            content: '';
            position: absolute;
            bottom: -30px;
            left: -30px;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            z-index: 0;
        }

        .check-circle {
            width: 100px;
            height: 100px;
            background: #4caf50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            position: relative;
            z-index: 2;
            box-shadow: 0 5px 15px rgba(76, 175, 80, 0.4);
            animation: pulse 2s infinite;
        }

        .check-circle i {
            font-size: 50px;
            color: white;
        }

        .alert-content {
            position: relative;
            z-index: 2;
        }

        .alert-content h4 {
            font-size: 2rem;
            color: #2e7d32;
            margin-bottom: 20px;
            font-weight: 700;
        }

        .alert-content p {
            font-size: 1.2rem;
            color: #388e3c;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .appointment-details {
            background: white;
            border-radius: 12px;
            padding: 25px;
            text-align: left;
            max-width: 400px;
            margin: 30px auto;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e8f5e9;
        }

        .detail-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px dashed #e0e0e0;
        }

        .detail-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            background: #e8f5e9;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .detail-icon i {
            color: #4caf50;
            font-size: 18px;
        }

        .detail-content h5 {
            font-size: 1rem;
            color: #616161;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .detail-content p {
            font-size: 1.1rem;
            color: #212121;
            font-weight: 600;
            margin: 0;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 14px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            border: none;
        }

        .btn-primary {
            background: linear-gradient(to right, #8d6e63, #5d4037);
            color: white;
            box-shadow: 0 4px 15px rgba(141, 110, 99, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #5d4037;
            border: 2px solid #8d6e63;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(141, 110, 99, 0.4);
        }

        .btn:active {
            transform: translateY(0);
        }

        .footer {
            text-align: center;
            padding: 25px;
            color: #8d6e63;
            font-size: 1rem;
            background: #f9f4f0;
            border-top: 1px solid #e9e0db;
        }

        .footer p {
            margin: 5px 0;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(76, 175, 80, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(76, 175, 80, 0);
            }
        }

        @media (max-width: 650px) {
            .confirmation-container {
                padding: 30px 20px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h2 {
                font-size: 1.8rem;
            }
            
            .check-circle {
                width: 80px;
                height: 80px;
            }
            
            .check-circle i {
                font-size: 40px;
            }
            
            .alert-content h4 {
                font-size: 1.6rem;
            }
            
            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <i class="fas fa-spa"></i>
                <span>Elegance Salon</span>
            </div>
            <h2>Appointment Confirmation</h2>
        </div>
        
        <div class="confirmation-container">
            <div class="alert-success">
                <div class="check-circle">
                    <i class="fas fa-check"></i>
                </div>
                
                <div class="alert-content">
                    <h4>Your appointment request has been submitted!</h4>
                    <p>The receptionist will contact you shortly to confirm your booking.</p>
                    <?php
                    $client_name = $_GET['client_name'];
$appointment_time = $_GET['appointment_time'];
                    $client_phone = $_GET['client_phone'] ?? 'Not provided';
                    ?>
                    
                    <div class="appointment-details">
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="detail-content">
                                <h5>Client Name</h5>
                                <p><?php echo $client_name; ?></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <div class="detail-content">
                                <h5>Contact Phone</h5>
                                <p><?php echo $client_phone; ?></p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-scissors"></i>
                            </div>
                            <div class="detail-content">
                                <h5>Service</h5>
                                <p>Premium Haircut & Styling</p>
                            </div>
                        </div>
                        
                        <div class="detail-item">
                            <div class="detail-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="detail-content">
                                <h5>Appointment Time</h5>
                                <p><?php echo $appointment_time; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="action-buttons">
                <button class="btn btn-primary">
                    <i class="fas fa-calendar-check"></i> View My Appointments
                </button>
                <button class="btn btn-secondary" href="homepage.php" onclick="window.location.href='homepage.php';">
                    <i class="fas fa-home"></i> Back to Home
                </button>
            </div>
        </div>
        
        <div class="footer">
            <p><i class="fas fa-clock"></i> Open Mon-Sat: 9:00 AM - 8:00 PM | Sun: 10:00 AM - 5:00 PM</p>
            <p><i class="fas fa-map-marker-alt"></i> 123 Beauty Street, Elegance City</p>
            
            <div class="contact-info">
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <span>(123) 456-7890</span>
                </div>
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <span>info@elegancesalon.com</span>
                </div>
                <div class="contact-item">
                    <i class="fab fa-instagram"></i>
                    <span>@elegancesalon</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>