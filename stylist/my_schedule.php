<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/stylistheader.php';

// Get all schedules with stylist names
$sql = "SELECT ss.schedule_id, ss.stylist_id, u.name AS stylist_name, 
               DATE(ss.shift_start) AS shift_date, 
               TIME(ss.shift_start) AS start_time, 
               TIME(ss.shift_end) AS end_time
        FROM staff_schedule ss
        JOIN users u ON ss.stylist_id = u.user_id
        WHERE u.role_id = 3
        ORDER BY ss.shift_start DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Schedule | Elegance Salon</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --gold: #D4AF37;
            --dark-gold: #B7950B;
            --black: #0F0F0F;
            --darker-gray: #1A1A1A;
            --dark-gray: #252525;
            --light-gray: #E0E0E0;
        }
        
        body {
            background: var(--black);
            color: var(--light-gray);
            font-family: 'Montserrat', 'Segoe UI', sans-serif;
            background-image: linear-gradient(rgba(0, 0, 0, 0.9), rgba(0, 0, 0, 0.7)), 
                              radial-gradient(circle at 10% 20%, rgba(212, 175, 55, 0.1) 0%, transparent 20%),
                              radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 20%);
        }
        
        .schedule-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
            position: relative;
        }
        
        .schedule-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -10%;
            width: 120%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 175, 55, 0.05), transparent);
            z-index: -1;
        }
        
        .schedule-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
            position: relative;
            display: inline-block;
        }
        
        .schedule-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 60px;
            height: 2px;
            background: var(--gold);
        }
        
        .table-container {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }
        
        .table {
            color: var(--light-gray);
            margin-bottom: 0;
        }
        
        .table-dark {
            background: transparent !important;
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-color: rgba(212, 175, 55, 0.3);
            background: rgba(30, 30, 30, 0.9) !important;
            padding: 1.2rem 1rem;
        }
        
        .table th:first-child {
            border-radius: 10px 0 0 0;
        }
        
        .table th:last-child {
            border-radius: 0 10px 0 0;
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1rem;
            vertical-align: middle;
        }
        
        .table tbody tr {
            transition: all 0.3s ease;
        }
        
        .table tbody tr:hover {
            background: rgba(212, 175, 55, 0.05) !important;
        }
        
        .time-badge {
            background: rgba(212, 175, 55, 0.2);
            color: var(--gold);
            padding: 0.35rem 0.75rem;
            border-radius: 50px;
            font-weight: 500;
            border: 1px solid rgba(212, 175, 55, 0.3);
        }
        
        .no-shifts {
            color: var(--gold);
            font-style: italic;
            text-align: center;
            padding: 2rem;
            background: rgba(30, 30, 30, 0.8);
        }
        
        .schedule-stats {
            background: rgba(30, 30, 30, 0.8);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            backdrop-filter: blur(5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
        }
        
        .stat-value {
            font-size: 2.2rem;
            font-weight: 300;
            color: var(--gold);
            margin: 0.5rem 0;
        }
        
        .stat-label {
            color: rgba(255, 255, 255, 0.7);
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 1px;
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 10px;
                overflow: hidden;
            }
            
            .table thead {
                display: none;
            }
            
            .table, .table tbody, .table tr, .table td {
                display: block;
                width: 100%;
            }
            
            .table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(212, 175, 55, 0.2);
                border-radius: 8px;
                overflow: hidden;
            }
            
            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            }
            
            .table td:last-child {
                border-bottom: none;
            }
            
            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 1rem;
                width: calc(50% - 1rem);
                padding-right: 10px;
                text-align: left;
                font-weight: 500;
                color: var(--gold);
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="schedule-header">
            <h1 class="schedule-title"><i class="fas fa-calendar-alt me-2"></i>Staff Schedule</h1>
            <p class="text-muted mt-2">View your stylists' work schedules</p>
        </div>

       
        <!-- Schedule Table -->
        <div class="table-container">
            <div class="table-responsive">
                <table class="table table-dark table-hover">
                    <thead>
                        <tr>
                            <th>Stylist</th>
                            <th>Date</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        mysqli_data_seek($result, 0); // Reset pointer
                        if (mysqli_num_rows($result) > 0): ?>
                            <?php while ($row = mysqli_fetch_assoc($result)): 
                                $start = strtotime($row['start_time']);
                                $end = strtotime($row['end_time']);
                                $duration = ($end - $start) / 3600; // Hours
                                $duration_formatted = ($duration >= 1) ? 
                                    floor($duration) . 'h ' . round(($duration - floor($duration)) * 60) . 'm' : 
                                    round($duration * 60) . 'm';
                            ?>
                                <tr>
                                    <td data-label="Stylist"><?= htmlspecialchars($row['stylist_name']) ?></td>
                                    <td data-label="Date"><?= date('M j, Y', strtotime($row['shift_date'])) ?></td>
                                    <td data-label="Start Time">
                                        <span class="time-badge"><?= date('g:i A', $start) ?></span>
                                    </td>
                                    <td data-label="End Time">
                                        <span class="time-badge"><?= date('g:i A', $end) ?></span>
                                    </td>
                                    <td data-label="Duration">
                                        <span class="time-badge"><?= $duration_formatted ?></span>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="no-shifts">
                                    <i class="fas fa-calendar-times me-2"></i>No shifts scheduled yet
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php include '../includes/stylistfooter.php'; ?>
</body>
</html>