<?php
require_once '../includes/db.php';
require_once '../includes/auth.php';
include '../includes/adminheader.php';
if ($_SESSION['role_id'] != 1) {
    header("Location: ../login.php");
    exit;
}

// Fetch feedback entries
$sql = "SELECT f.feedback_id, c.name AS client_name, f.message, f.submitted_at
        FROM feedback f
        JOIN clients c ON client_id = c.client_id
        ORDER BY f.submitted_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Feedback | Elegance Salon</title>
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
        }
        
        .feedback-header {
            border-bottom: 1px solid rgba(212, 175, 55, 0.3);
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }
        
        .feedback-title {
            color: var(--gold);
            font-weight: 300;
            letter-spacing: 1px;
        }
        
        .table-container {
            background: var(--black);
            border: 1px solid rgba(212, 175, 55, 0.2);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }
        
        .table {
            color: var(--light-gray);
            margin-bottom: 0;
        }
        
        .table-dark {
            background: rgba(212, 175, 55, 0.1) !important;
            border-color: rgba(212, 175, 55, 0.3);
        }
        
        .table-dark th {
            color: var(--gold);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            border-color: rgba(212, 175, 55, 0.3);
            background: var(--black) !important;
        }
        
        .table td, .table th {
            border-color: rgba(255, 255, 255, 0.05);
            padding: 1.25rem;
            vertical-align: middle;
            background: var(--black);
        }
        
        .message-cell {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        
        .timestamp {
            color: var(--gold);
            font-size: 0.9rem;
        }
        
        /* Ensure header and footer also use black background */
        header, footer {
            background: var(--black) !important;
            border-color: rgba(212, 175, 55, 0.2) !important;
        }
    </style>
</head>
<body style="background: var(--black);">
    <?php include '../includes/header.php'; ?>
    
    <div class="container py-4" style="background: var(--black);">
        <div class="feedback-header">
            <h1 class="feedback-title"><i class="fas fa-comment-alt me-2"></i>Client Feedback</h1>
        </div>

        <div class="table-container" style="background: var(--black);">
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Client</th>
                        <th>Message</th>
                        <th>Submitted At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    mysqli_data_seek($result, 0); // Reset pointer
                    while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr style="background: var(--black);">
                            <td><?= htmlspecialchars($row['client_name']) ?></td>
                            <td class="message-cell"><?= nl2br(htmlspecialchars($row['message'])) ?></td>
                            <td class="timestamp"><?= date('M j, Y g:i A', strtotime($row['submitted_at'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>