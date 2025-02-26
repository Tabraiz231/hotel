<?php
session_start();
include 'Connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo "Please log in to make a booking.";
        exit();
    }
    $guest_name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $checkin = $_REQUEST['checkin'];
    $checkout = $_REQUEST['checkout'];
    $room_type = $_REQUEST['room-type'];
    $number_of_guests = intval($_REQUEST['guests']);
    $user_id = $_SESSION['user_id'];

    if (empty($guest_name) || empty($email) || empty($checkin) || empty($checkout) || empty($room_type) || empty($number_of_guests)) {
        echo "All fields are required. Please <a href='bookingroom.html'>go back</a>.";
        exit();
    }

    $room_prices = ['single' => 100, 'double' => 150, 'suite' => 250];
    $room_price = isset($room_prices[$room_type]) ? $room_prices[$room_type] : 0;
    $nights = (new DateTime($checkin))->diff(new DateTime($checkout))->days;
    $extra_charges = 0;
    $total_amount = ($room_price * $nights) + $extra_charges;

    $sql = "INSERT INTO bookings (guest_id, guest_name, email, check_in_date, check_out_date, room_number, room_type, number_of_guests)
            VALUES ('$user_id', '$guest_name', '$email', '$checkin', '$checkout', 0, '$room_type', $number_of_guests)";
    if (!$conn->query($sql)) {
        echo "Error in booking: " . $conn->error;
        exit();
    }
    $booking_id = $conn->insert_id;
    $billing_sql = "INSERT INTO billing (booking_id, guest_id, guest_name, room_type, room_price, nights, extra_charges, total_amount)
                    VALUES ('$booking_id', '$user_id', '$guest_name', '$room_type', '$room_price', '$nights', '$extra_charges', '$total_amount')";
    if (!$conn->query($billing_sql)) {
        echo "Error storing billing details: " . $conn->error;
        exit();
    }
    $_SESSION['billing_details'] = [
        'user_id'      => $user_id,
        'guest_name'   => $guest_name,
        'room_type'    => $room_type,
        'checkin'      => $checkin,
        'checkout'     => $checkout,
        'room_price'   => $room_price,
        'nights'       => $nights,
        'extra_charges'=> $extra_charges,
        'total_amount' => $total_amount
    ];
    header("Location: billing.php");
    exit();
}

if (!isset($_SESSION['billing_details'])) {
    header("Location: bookingroom.html");
    exit();
}

$billing = $_SESSION['billing_details'];
$user_id = $billing['user_id'];
$guest_name = $billing['guest_name'];
$room_type = $billing['room_type'];
$checkin = $billing['checkin'];
$checkout = $billing['checkout'];
$room_price = $billing['room_price'];
$nights = $billing['nights'];
$extra_charges = $billing['extra_charges'];
$total_amount = $billing['total_amount'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing</title>
    <style>
        body { font-family: 'Poppins', sans-serif; margin: 0; padding: 0; background: #f9f9f9; color: #333; }
        header { background: linear-gradient(135deg, #1a237e, #283593); padding: 0.5rem 2rem; position: fixed; width: 100%; top: 0; z-index: 1000; }
        nav { display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; }
        .logo { font-size: 1.5rem; font-weight: bold; color: white; }
        .auth-buttons { list-style: none; display: flex; gap: 2.5rem; padding: 0; }
        .auth-buttons li a { color: white; text-decoration: none; font-weight: 500; transition: color 0.3s; }
        .auth-buttons li a:hover { color: #ff4081; }
        .hero { height: 80vh; background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1556742111-a301076d9d18?q=80&w=1470&auto=format&fit=crop') no-repeat center center/cover; display: flex; flex-direction: column; justify-content: center; align-items: center; color: white; }
        .hero h1 { font-size: 4rem; margin-bottom: 1rem; }
        .hero p { font-size: 1.6rem; font-weight: 300; }
        .container { max-width: 600px; background: white; padding: 2rem; margin: 4rem auto; border-radius: 15px; box-shadow: 0 8px 15px rgba(0,0,0,0.1); }
        h2 { color: #1a237e; text-align: center; }
        .bill-details { margin-bottom: 1rem; }
        .bill-details label { font-weight: bold; display: inline-block; width: 200px; }
        .total { font-size: 1.2rem; font-weight: bold; text-align: right; margin-top: 1rem; }
        button { width: 100%; padding: 0.8rem; background: #c2185b; color: white; border: none; border-radius: 25px; cursor: pointer; transition: background 0.3s; }
        button:hover { background: #a3104b; }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo"><i class="fas fa-hotel"></i><span>Grand Palace</span></div>
            <ul class="auth-buttons">
                <li><a href="Guest.html">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="#contact">Contact Us</a></li>
                <li><a href="index.html">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section class="hero" id="home">
        <h1>Secure with Easy Payments</h1>
        <p>Fast, safe, and hassle-free payments!</p>
    </section>
    <div class="container">
        <h2>Billing Details</h2>
        <div class="bill-details">
            <label>Guest ID:</label>
            <span><?php echo htmlspecialchars($user_id); ?></span>
        </div>
        <div class="bill-details">
            <label>Guest Name:</label>
            <span><?php echo htmlspecialchars($guest_name); ?></span>
        </div>
        <div class="bill-details">
            <label>Room Type:</label>
            <span><?php echo htmlspecialchars(ucfirst($room_type)); ?></span>
        </div>
        <div class="bill-details">
            <label>Check-In Date:</label>
            <span><?php echo htmlspecialchars($checkin); ?></span>
        </div>
        <div class="bill-details">
            <label>Check-Out Date:</label>
            <span><?php echo htmlspecialchars($checkout); ?></span>
        </div>
        <div class="bill-details">
            <label>Room Price Per Night:</label>
            <span>$<?php echo number_format($room_price, 2); ?></span>
        </div>
        <div class="bill-details">
            <label>Number of Nights:</label>
            <span><?php echo $nights; ?></span>
        </div>
        <div class="bill-details">
            <label>Extra Charges:</label>
            <span>$<?php echo number_format($extra_charges, 2); ?></span>
        </div>
        <div class="total">
            Total Amount: $<?php echo number_format($total_amount, 2); ?>
        </div>
        <button type="button" onclick="window.location.href='Guest.html';">OK</button>
    </div>
    <footer>
        <!-- Footer content as before -->
    </footer>
</body>
</html>
