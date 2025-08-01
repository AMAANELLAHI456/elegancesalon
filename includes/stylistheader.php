<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elegance Salon - Receptionist Portal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --gold: #FFD700;
      --dark-gold: #D4AF37;
      --black: #0a0a0a;
      --darker: #050505;
      --dark-gray: #1a1a1a;
      --medium-gray: #2d2d2d;
      --light-gray: #3a3a3a;
      --light: #eeeeee;
      --transition: all 0.3s ease;
      --shadow: 0 4px 20px rgba(0, 0, 0, 0.4);
    }

    body {
      background-color: var(--darker);
      background-image: radial-gradient(circle at 15% 50%, var(--dark-gray) 0%, var(--darker) 100%);
      color: var(--light);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 0;
      margin: 0;
      min-height: 100vh;
      overflow-x: hidden;
    }

    /* Menu Toggle Button */
    .menu-toggle {
      position: fixed;
      top: 20px;
      left: 20px;
      z-index: 1000;
      background: rgba(20, 20, 20, 0.9);
      border: 1px solid rgba(255, 215, 0, 0.3);
      color: var(--gold);
      border-radius: 8px;
      padding: 10px 14px;
      cursor: pointer;
      transition: var(--transition);
      box-shadow: var(--shadow);
    }
    
    .menu-toggle:hover {
      background: rgba(255, 215, 0, 0.1);
      border-color: var(--gold);
      transform: translateY(-2px);
    }
    
    /* Off-canvas menu styles */
    .offcanvas {
      background-color: var(--black);
      background-image: linear-gradient(to bottom, var(--black), var(--dark-gray) 120%);
      color: var(--light);
      width: 280px;
      border-right: 1px solid rgba(255, 215, 0, 0.2);
      box-shadow: 5px 0 25px rgba(0, 0, 0, 0.5);
    }
    
    .offcanvas-header {
      border-bottom: 1px solid rgba(255, 215, 0, 0.2);
      padding: 20px;
      background: rgba(10, 10, 10, 0.8);
    }
    
    .offcanvas-title {
      color: var(--gold);
      font-weight: 600;
      font-size: 1.5rem;
      letter-spacing: 1px;
      display: flex;
      align-items: center;
    }
    
    .offcanvas-body {
      padding: 0;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }
    
    .sidebar-menu {
      list-style: none;
      padding: 0;
      margin: 0;
    }
    
    .sidebar-menu li {
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .sidebar-menu li:last-child {
      border-bottom: none;
    }
    
    .sidebar-menu a {
      display: flex;
      align-items: center;
      padding: 16px 25px;
      color: var(--light);
      text-decoration: none;
      transition: var(--transition);
      font-size: 16px;
      position: relative;
    }
    
    .sidebar-menu a:hover {
      background: linear-gradient(to right, rgba(255, 215, 0, 0.05), transparent);
      color: var(--gold);
      padding-left: 30px;
    }
    
    .sidebar-menu a:hover::before {
      content: '';
      position: absolute;
      left: 0;
      top: 0;
      height: 100%;
      width: 3px;
      background: var(--gold);
    }
    
    .sidebar-menu a.active {
      background: linear-gradient(to right, rgba(255, 215, 0, 0.1), transparent);
      color: var(--gold);
      border-left: 4px solid var(--gold);
      font-weight: 500;
    }
    
    .sidebar-menu i {
      width: 24px;
      margin-right: 15px;
      font-size: 18px;
      text-align: center;
      transition: var(--transition);
    }
    
    .sidebar-menu a:hover i {
      transform: scale(1.1);
    }
    
    .user-info {
      padding: 20px;
      border-top: 1px solid rgba(255, 215, 0, 0.2);
      display: flex;
      align-items: center;
      background: rgba(15, 15, 15, 0.7);
    }
    
    .user-info img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 12px;
      border: 1px solid var(--gold);
      box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
    }
    
    .user-details {
      flex: 1;
    }
    
    .user-name {
      color: var(--gold);
      font-weight: 500;
      margin-bottom: 3px;
    }
    
    .user-role {
      color: var(--light);
      opacity: 0.8;
      font-size: 13px;
    }
    
    .logout-btn {
      background: transparent;
      border: none;
      color: var(--gold);
      font-size: 18px;
      cursor: pointer;
      transition: var(--transition);
      padding: 8px;
      border-radius: 5px;
    }
    
    .logout-btn:hover {
      background: rgba(255, 215, 0, 0.1);
      transform: rotate(10deg);
    }
    
    .salon-logo {
      width: 40px;
      height: 40px;
      margin-right: 12px;
      border-radius: 8px;
      background: linear-gradient(45deg, var(--black), var(--dark-gold));
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
      color: var(--gold);
      border: 1px solid var(--gold);
      box-shadow: 0 0 12px rgba(212, 175, 55, 0.4);
    }

    /* Custom scrollbar */
    ::-webkit-scrollbar {
      width: 8px;
    }
    
    ::-webkit-scrollbar-track {
      background: var(--black);
    }
    
    ::-webkit-scrollbar-thumb {
      background: var(--dark-gold);
      border-radius: 4px;
    }
    
    ::-webkit-scrollbar-thumb:hover {
      background: var(--gold);
    }
    
    /* Animation for menu items */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(-10px); }
      to { opacity: 1; transform: translateX(0); }
    }
    
    .sidebar-menu li {
      animation: fadeIn 0.4s ease forwards;
      opacity: 0;
    }
    
    .sidebar-menu li:nth-child(1) { animation-delay: 0.1s; }
    .sidebar-menu li:nth-child(2) { animation-delay: 0.15s; }
    .sidebar-menu li:nth-child(3) { animation-delay: 0.2s; }
    .sidebar-menu li:nth-child(4) { animation-delay: 0.25s; }
    
    /* Dashboard content */
    .dashboard-container {
      margin-left: 300px;
      padding: 30px;
    }
    
    .dashboard-header {
      margin-bottom: 30px;
      padding-bottom: 15px;
      border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }
    
    .stat-card {
      background: rgba(20, 20, 20, 0.7);
      border-radius: 10px;
      padding: 20px;
      margin-bottom: 20px;
      border: 1px solid rgba(255, 215, 0, 0.1);
      transition: var(--transition);
      box-shadow: var(--shadow);
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
      border-color: var(--gold);
    }
    
    .stat-value {
      font-size: 2.5rem;
      color: var(--gold);
      font-weight: 600;
      margin: 10px 0;
    }
    
    .stat-label {
      color: var(--light);
      opacity: 0.8;
      font-size: 1rem;
    }
    
    .stat-icon {
      font-size: 2.5rem;
      color: var(--gold);
      opacity: 0.7;
      margin-bottom: 15px;
    }
    
    .recent-appointments {
      background: rgba(20, 20, 20, 0.7);
      border-radius: 10px;
      padding: 25px;
      margin-top: 30px;
      border: 1px solid rgba(255, 215, 0, 0.1);
      box-shadow: var(--shadow);
    }
    
    .section-title {
      color: var(--gold);
      margin-bottom: 20px;
      padding-bottom: 10px;
      border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }
    
    .appointment-item {
      display: flex;
      justify-content: space-between;
      padding: 15px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
    }
    
    .appointment-item:last-child {
      border-bottom: none;
    }
    
    .client-info {
      display: flex;
      align-items: center;
    }
    
    .client-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background: var(--dark-gray);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: var(--gold);
      font-weight: bold;
    }
    
    .client-name {
      font-weight: 500;
    }
    
    .appointment-time {
      color: var(--gold);
      font-weight: 500;
    }
    
    .appointment-service {
      color: var(--light);
      opacity: 0.8;
      font-size: 0.9rem;
    }
    
    .badge-status {
      padding: 5px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }
    
    .badge-confirmed {
      background: rgba(40, 167, 69, 0.2);
      color: #28a745;
      border: 1px solid #28a745;
    }
    
    .badge-pending {
      background: rgba(255, 193, 7, 0.2);
      color: #ffc107;
      border: 1px solid #ffc107;
    }
    
    .badge-completed {
      background: rgba(108, 117, 125, 0.2);
      color: #6c757d;
      border: 1px solid #6c757d;
    }
  </style>
</head>
<body>
  <!-- Receptionist Off-Canvas Menu -->
  <button class="menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
    <i class="fas fa-bars"></i>
  </button>
  
  <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
    <div class="offcanvas-header">
      <div class="d-flex align-items-center">
        <div class="salon-logo">ES</div>
        <h5 class="offcanvas-title">Elegance Salon</h5>
      </div>
      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="sidebar-menu">
        <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="my_appointments.php"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
        <li><a href="my_schedule.php"><i class="fas fa-users"></i> schedule</a></li>
      </ul>
      
      <div class="user-info">
        <img src="https://ui-avatars.com/api/?name=Elena+Rodriguez&background=000000&color=FFD700" alt="Elena Rodriguez">
        <div class="user-details">
          <div class="user-name">Elena Rodriguez</div>
          <div class="user-role">stylist</div>
        </div>
        <button class="logout-btn" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </div>
    </div>
  </div>



  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const menuItems = document.querySelectorAll('.sidebar-menu a');
      
      menuItems.forEach(item => {
        item.addEventListener('click', function() {
          menuItems.forEach(i => i.classList.remove('active'));
          this.classList.add('active');
        });
      });
      
      // Logout button functionality
      document.querySelector('.logout-btn').addEventListener('click', function() {
        if (confirm('Are you sure you want to logout?')) {
          alert('You have been logged out successfully');
          window.location.href = '../logout.php';
        }
      });
    });
  </script>
</body>
</html>