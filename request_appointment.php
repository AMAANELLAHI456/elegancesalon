<?php
require_once 'includes/db.php';
// Use the existing connection from db.php instead of creating a new one
$services = mysqli_query($conn, "SELECT service_id, service_name FROM services");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Elegance Salon - Appointment Request</title>
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

        .header p {
            font-size: 1.15rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
            font-weight: 300;
        }

        .header::after {
            content: '';
            position: absolute;
            bottom: -12px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: #d7ccc8;
            border-radius: 2px;
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

        .form-container {
            padding: 40px;
        }

        .form-group {
            margin-bottom: 28px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-weight: 600;
            color: #4e342e;
            font-size: 1.1rem;
        }

        .form-control {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #d7ccc8;
            border-radius: 12px;
            font-size: 1.05rem;
            transition: all 0.3s ease;
            background: #faf6f3;
            color: #5d4037;
        }

        .form-control:focus {
            border-color: #8d6e63;
            box-shadow: 0 0 0 4px rgba(141, 110, 99, 0.2);
            outline: none;
            background: white;
        }

        .icon-input {
            position: relative;
        }

        .icon-input i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #8d6e63;
            font-size: 1.1rem;
        }

        .icon-input input {
            padding-left: 50px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: 25px;
            margin-bottom: 25px;
        }

        .form-col {
            flex: 1;
            min-width: 250px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' fill='%238d6e63' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 20px center;
            background-size: 14px;
            padding-right: 45px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 18px;
            background: linear-gradient(to right, #8d6e63, #5d4037);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.15rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            letter-spacing: 0.8px;
            box-shadow: 0 6px 15px rgba(141, 110, 99, 0.3);
            text-transform: uppercase;
            margin-top: 15px;
        }

        .btn:hover {
            background: linear-gradient(to right, #7a5b51, #4a332c);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(141, 110, 99, 0.4);
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

        .notification {
            padding: 20px;
            margin: 25px 0;
            border-radius: 12px;
            text-align: center;
            font-weight: 500;
            font-size: 1.1rem;
        }

        .success {
            background-color: #e8f5e9;
            color: #2e7d32;
            border: 1px solid #c8e6c9;
        }

        .error {
            background-color: #ffebee;
            color: #c62828;
            border: 1px solid #ffcdd2;
        }

        .error i {
            font-size: 2rem;
            margin-bottom: 15px;
            display: block;
        }

        @media (max-width: 650px) {
            .form-container {
                padding: 30px 25px;
            }
            
            .header {
                padding: 30px 20px;
            }
            
            .header h2 {
                font-size: 2rem;
            }
            
            .form-row {
                flex-direction: column;
                gap: 0;
            }
            
            .logo {
                position: relative;
                top: 0;
                left: 0;
                margin-bottom: 15px;
                justify-content: center;
            }
        }

        .salon-image {
            width: 100%;
            height: 200px;
            background: linear-gradient(rgba(93, 64, 55, 0.6), rgba(93, 64, 55, 0.6)), 
                         url('https://images.unsplash.com/photo-1560066984-138dadb4c035?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1200&q=80');
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            text-align: center;
            padding: 20px;
            font-weight: 300;
            letter-spacing: 1px;
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
            <h2>Request an Appointment</h2>
            <p>Experience our premium services with our expert stylists</p>
        </div>
        
        <div class="salon-image">
            Your Beauty Journey Starts Here
        </div>
        
        <div class="form-container">
            <?php if(!$services): ?>
                <div class="notification error">
                    <i class="fas fa-exclamation-triangle"></i>
                    <h3>Database Connection Issue</h3>
                    <p>We're unable to load our services at this time. Please contact our salon directly to book your appointment.</p>
                    <p><strong>Phone:</strong> (123) 456-7890</p>
                </div>
            <?php endif; ?>
            
            <form action="request_appointment_submit.php" method="POST">
                <div class="form-row">
                    <div class="form-col">
                        <div class="form-group icon-input">
                            <label for="client_name">Client Name</label>
                            <i class="fas fa-user"></i>
                            <input type="text" name="client_name" id="client_name" class="form-control" placeholder="Enter your full name" required>
                        </div>
                    </div>
                    
                    <div class="form-col">
                        <div class="form-group icon-input">
                            <label for="client_phone">Phone Number</label>
                            <i class="fas fa-phone"></i>
                            <input type="text" name="client_phone" id="client_phone" class="form-control" placeholder="Enter your phone number" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="service_id">Select Service</label>
                    <select name="service_id" id="service_id" class="form-control" required>
                        <option value="">-- Select Service --</option>
                        <?php if($services): ?>
                            <?php while ($row = mysqli_fetch_assoc($services)): ?>
                                <option value="<?= $row['service_id'] ?>"><?= htmlspecialchars($row['service_name']) ?></option>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <option value="">Services currently unavailable</option>
                        <?php endif; ?>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="appointment_time">Preferred Appointment Time</label>
                    <input type="datetime-local" name="appointment_time" id="appointment_time" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="special_requests">Special Requests</label>
                    <textarea name="special_requests" id="special_requests" class="form-control" rows="3" placeholder="Any special requirements or notes..."></textarea>
                </div>
                
                <button type="submit" class="btn">
                    <i class="fas fa-calendar-check"></i> Request Appointment
                </button>
            </form>
        </div>
        
        <div class="footer">
            <p><i class="fas fa-clock"></i> Open Mon-Sat: 9:00 AM - 8:00 PM</p>
            <p><i class="fas fa-map-marker-alt"></i> 123 Beauty Street, Elegance City</p>
        </div>
    </div>
    
    <script>
        // Set minimum datetime to today
        document.addEventListener('DOMContentLoaded', function() {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById('appointment_time').min = minDateTime;
            
            // Set initial value to next hour
            const appointmentTime = document.getElementById('appointment_time');
            const future = new Date(now.getTime() + 60 * 60 * 1000); // 1 hour from now
            const futureHours = String(future.getHours()).padStart(2, '0');
            const futureMinutes = String(future.getMinutes()).padStart(2, '0');
            appointmentTime.value = `${year}-${month}-${day}T${futureHours}:${futureMinutes}`;
        });
    </script>
</body>
</html>