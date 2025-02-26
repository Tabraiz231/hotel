<?php
include 'Connect.php';

$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Room Availability</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
       body {
          font-family: 'Poppins', sans-serif;
          margin: 0;
          padding: 0;
          background-color: #f9f9f9;
          color: #333;
          line-height: 1.6;
      }
      /* Header */
      header {
          background: linear-gradient(135deg, #1a237e, #283593);
          padding: 0.5rem 2rem;
          position: fixed;
          width: 100%;
          top: 0;
          z-index: 1000;
          box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
      }
      nav {
          display: flex;
          justify-content: space-between;
          align-items: center;
          max-width: 1200px;
          margin: 0 auto;
      }
      .logo {
          font-size: 1.5rem;
          font-weight: bold;
          color: white;
      }
      .auth-buttons {
          display: flex;
          list-style: none;
          gap: 2.5rem;
          padding: 0;
      }
      .auth-buttons li a {
          color: white;
          text-decoration: none;
          font-weight: 500;
          padding-bottom: 5px;
          transition: color 0.3s ease;
      }
      .auth-buttons li a:hover {
          color: #ff4081;
      }
      .hero {
          height: 80vh;
          background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                      url('https://images.unsplash.com/photo-1618773928121-c32242e63f39?q=80&w=1470&auto=format&fit=crop') no-repeat center center/cover;
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
          text-align: center;
          color: white;
          padding-top: 100px;
      }
      .hero h1 {
          font-size: 4rem;
          margin-bottom: 1rem;
      }
      .hero p {
          font-size: 1.6rem;
          font-weight: 300;
      }
      .container {
          padding: 2rem;
          max-width: 1000px;
          margin: 0 auto;
      }
      .room {
          display: flex;
          justify-content: space-between;
          align-items: center;
          background: white;
          padding: 1rem;
          margin-bottom: 1rem;
          border-radius: 10px;
          box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      }
      .room h3 {
          margin: 0;
          color: #c2185b;
      }
      .room p {
          margin: 0.5rem 0;
      }
      .button {
          padding: 0.7rem 1.5rem;
          background: #c2185b;
          color: white;
          border-radius: 25px;
          text-decoration: none;
          font-size: 1rem;
          transition: background 0.3s;
      }
      .button:hover {
          background: #a3104b;
      }
      footer {
          background: linear-gradient(135deg, #1a237e, #283593);
          color: white;
          padding: 4rem 2rem 1.5rem;
          margin-top: 0rem;
      }
      :root {
          --primary-color: #1a237e;
          --secondary-color: #c2185b;
          --accent-color: #00bcd4;
          --gradient-start: #1a237e;
          --gradient-end: #283593;
          --text-color: #1a237e;
          --light-bg: #f5f5f5;
      }
      .footer-content {
          max-width: 1200px;
          margin: 0 auto;
          display: grid;
          grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
          gap: 3rem;
      }
      .footer-section h3 {
          color: white;
          margin-bottom: 1.5rem;
          font-size: 1.5rem;
          font-weight: 600;
      }
      .footer-section p {
          margin-bottom: 1rem;
          display: flex;
          align-items: center;
          gap: 10px;
          font-size: 1rem;
      }
      .footer-section i {
          color: white;
          font-size: 1.2rem;
      }
      .social-icons {
          display: flex;
          gap: 1.5rem;
          margin-top: -0.8rem;
      }
      .social-icons a {
          color: white;
          font-size: 1.8rem;
          transition: all 0.3s ease;
      }
      .social-icons a:hover {
          color: var(--accent-color);
          transform: translateY(-5px);
      }
      .footer-section ul {
          list-style: none;
      }
      .footer-section ul li {
          margin-bottom: 0.8rem;
      }
      .footer-section ul li a {
          color: white;
          text-decoration: none;
          transition: all 0.3s ease;
          display: inline-block;
          font-size: 1rem;
      }
      .footer-section ul li a:hover {
          color: var(--accent-color);
          transform: translateX(5px);
      }
      .footer-bottom {
          text-align: center;
          margin-top: 3rem;
          padding-top: 2rem;
          border-top: 1px solid rgba(255,255,255,0.1);
      }
      #fotr_quicktxt {
          position: relative;
          left: -38px;
      }
      /* Dropdown container */
      .dropdown {
          position: relative;
      }
      /* Dropdown menu (hidden by default) */
      .dropdown-menu {
          display: none;
          position: absolute;
          top: 100%;
          left: 0;
          background-color: white;
          box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
          padding: 0.5rem 0;
          list-style: none;
          z-index: 1000;
          min-width: 200px;
          border-radius: 4px;
      }
      /* Dropdown items */
      .dropdown-menu li {
          padding: 0.5rem 1rem;
      }
      .dropdown-menu li a {
          color: #283593;
          text-decoration: none;
          display: block;
          transition: background-color 0.3s ease;
      }
      /* Show dropdown on hover */
      .dropdown:hover .dropdown-menu {
          display: block;
      }
  </style>
</head>
<body>
  <header>
    <nav>
      <div class="logo">
        <i class="fas fa-hotel"></i>
        <span>Grand Palace</span>
      </div>
      <ul class="auth-buttons">
        <li><a href="Guest.html">Home</a></li>
        <li><a href="#about" class="sign-in-btn">About Us</a></li>
        <!-- Services Dropdown -->
        <li class="dropdown">
          <a href="#services" class="sign-in-btn">Services</a>
          <ul class="dropdown-menu">
            <li><a href="viewroom.php">View Room Availability</a></li>
            <li><a href="bookroom.html">Book a Room</a></li>
            <li><a href="feedback.html">Send Feedback</a></li>
            <li><a href="request for cleaning.html">Request Room Cleaning</a></li>
            <li><a href="cancelbooking.html">Cancel Booking</a></li>
          </ul>
        </li>
        <li><a href="#contact" class="sign-in-btn">Contact Us</a></li>
        <li><a href="index.html" class="sign-up-btn">Logout</a></li>
      </ul>
    </nav>
  </header>
  
  <!-- Hero Section -->
  <section class="hero" id="home">
    <h1>View Available Rooms</h1>
    <p>Find your perfect room and book your stay now.</p>
  </section>
  
  <div class="container">
    <?php
    if ($result && $result->num_rows > 0) {
        while ($room = $result->fetch_assoc()) {
            
            $roomType = $room['room_type'];
            $price = $room['price'];
            $available = $room['available']; // 1 = Yes, 0 = No
            echo '<div class="room">';
            echo '<div>';
            echo '<h3>' . htmlspecialchars($roomType) . '</h3>';
            echo '<p>Price: $' . number_format($price, 2) . '/night</p>';
            echo '<p>Available: ' . ($available ? 'Yes' : 'No') . '</p>';
            echo '</div>';
            if ($available) {
                echo '<a class="button" href="bookroom.html?room_id=' . $room['room_id'] . '">Book Now</a>';
            } else {
                echo '<a class="button" href="joinwaitlist.html?room_id=' . $room['room_id'] . '">Join Waitlist</a>';
            }
            echo '</div>';
        }
    } else {
        echo "<p>No rooms available at the moment.</p>";
    }
    $conn->close();
    ?>
  </div>
  
  <footer>
    <div class="footer-content">
      <div class="footer-section">
        <h3>Contact Us</h3>
        <p><i class="fas fa-phone"></i> +1 888 PALACE</p>
        <p><i class="fas fa-envelope"></i> info@grandpalace.com</p>
        <p><i class="fas fa-map-marker"></i> 1 Palace Avenue, Beverly Hills</p>
      </div>
      <div class="footer-section">
        <h3>Follow Us</h3>
        <div class="social-icons">
          <a href="#"><i class="fab fa-facebook"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>
      <div class="footer-section">
        <h3>Quick Links</h3>
        <ul id="fotr_quicktxt">
          <li><a href="Guest.html">Home</a></li>
          <li><a href="#about" class="sign-in-btn">About Us</a></li>
          <li><a href="#services" class="sign-in-btn">Services</a></li>
          <li><a href="#contact" class="sign-in-btn">Contact Us</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 Grand Palace Hotel. All rights reserved.</p>
    </div>
  </footer>
</body>
</html>
