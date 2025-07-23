<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us | Elegance Salon</title>
  <style>
    body {
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #000;
      color: #FFD700;
    }

    .container {
      max-width: 700px;
      margin: 50px auto;
      padding: 30px;
      border: 1px solid #FFD700;
      border-radius: 10px;
      background-color: #111;
      box-shadow: 0 0 20px rgba(255, 215, 0, 0.1);
    }

    h1 {
      text-align: center;
      font-family: 'Playfair Display', serif;
      margin-bottom: 30px;
      color: #FFD700;
    }

    label {
      display: block;
      margin: 15px 0 5px;
      font-weight: bold;
    }

    input, textarea {
      width: 100%;
      padding: 10px;
      background: #000;
      border: 1px solid #FFD700;
      color: #FFD700;
      border-radius: 5px;
    }

    input::placeholder, textarea::placeholder {
      color: #aaa;
    }

    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #FFD700;
      color: #000;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: 0.3s;
      font-weight: bold;
    }

    button:hover {
      background: #000;
      color: #FFD700;
      border: 1px solid #FFD700;
    }

    .info {
      text-align: center;
      margin-top: 40px;
      font-size: 14px;
      color: #ccc;
    }

    .info a {
      color: #FFD700;
      text-decoration: none;
    }

    .info a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>Contact Elegance Salon</h1>
    
    <form action="submit_contact.php" method="post">
      <label for="name">Full Name</label>
      <input type="text" id="name" name="name" placeholder="Enter your name" required>

      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" placeholder="Enter your email" required>

      <label for="message">Message</label>
      <textarea id="message" name="message" placeholder="Write your message..." rows="5" required></textarea>

      <button type="submit">Send Message</button>
    </form>

    <div class="info">
      <p>Or reach us directly:</p>
      <p>📞 <a href="tel:+3308682472">+</a></p>
      <p>📧 <a href="mailto:contact@elegancesalon.com">contact@elegancesalon.com</a></p>
      <p>📍  City</p>
    </div>
  </div>

</body>
</html>
