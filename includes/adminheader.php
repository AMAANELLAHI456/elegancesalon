<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Elegance Salon - Off Canvas Menu</title>
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
    .sidebar-menu li:nth-child(5) { animation-delay: 0.3s; }
    .sidebar-menu li:nth-child(6) { animation-delay: 0.35s; }
    .sidebar-menu li:nth-child(7) { animation-delay: 0.4s; }
    .sidebar-menu li:nth-child(8) { animation-delay: 0.45s; }
    .sidebar-menu li:nth-child(9) { animation-delay: 0.5s; }
    .sidebar-menu li:nth-child(10) { animation-delay: 0.55s; }
  </style>
</head>
<body>
  <!-- Menu Toggle Button -->
  <button class="menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
    <i class="fas fa-bars"></i>
  </button>
  
  <!-- Off-canvas Menu -->
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
        <li><a href="#" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
        <li><a href="clients.php"><i class="fas fa-users"></i> Clients</a></li>
        <li><a href="app"><i class="fas fa-calendar-alt"></i> Appointments</a></li>
        <li><a href="#"><i class="fas fa-spa"></i> Services</a></li>
        <li><a href="#"><i class="fas fa-boxes"></i> Inventory</a></li>
        <li><a href="#"><i class="fas fa-clipboard-list"></i> Staff Schedule</a></li>
        <li><a href="#"><i class="fas fa-chart-bar"></i> Reports</a></li>
        <li><a href="#"><i class="fas fa-user-cog"></i> Manage Users</a></li>
        <li><a href="#"><i class="fas fa-comment-dots"></i> View Feedback</a></li>
        <li><a href="#"><i class="fas fa-cog"></i> Settings</a></li>
      </ul>
      
      <div class="user-info">
        <img src="https://ui-avatars.com/api/?name=Admin&background=000000&color=FFD700" alt="Admin">
        <div class="user-details">
          <div class="user-name">Admin User</div>
          <div class="user-role">Administrator</div>
        </div>
        <button class="logout-btn" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </button>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Add active class to the current menu item
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
        alert('You have been logged out successfully');
        // In a real implementation, this would redirect to logout page
      });
    });
  </script>
</body>
</html>