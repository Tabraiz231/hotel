<?php
session_start();
include '../Guest/Connect.php'; // ڈیٹا بیس کنکشن

// چیک کریں کہ فارم سبمٹ ہوا ہے یا نہیں
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['user_id'])) {
        echo "Please login to generate a bill. <a href='index.html'>Login here</a>.";
        exit();
    }

    // فارم کے ڈیٹا کو حاصل کریں
    $booking_id = trim($_POST['bookingId']);
    $guest_id = trim($_POST['guestId']);
    $guest_name = trim($_POST['guestName']);
    $room_type = trim($_POST['roomType']);
    $room_price = trim($_POST['roomPrice']);
    $nights = trim($_POST['nights']);
    $extra_charges = trim($_POST['extraCharges']);
    $total_amount = trim($_POST['totalAmount']);
    $billing_date = trim($_POST['billingDate']);

    // چیک کریں کہ ضروری فیلڈز خالی نہ ہوں
    if (empty($booking_id) || empty($guest_id) || empty($guest_name) || empty($room_type) || empty($room_price) || empty($nights) || empty($total_amount) || empty($billing_date)) {
        echo "All fields are required!";
        exit();
    }

    // 🔹 Booking ID کو چیک کریں
    $checkBooking = $conn->prepare("SELECT id FROM bookings WHERE id = ?");
    $checkBooking->bind_param("i", $booking_id);
    $checkBooking->execute();
    $checkBooking->store_result();

    if ($checkBooking->num_rows == 0) {
        die("Error: Booking ID does not exist in bookings table.");
    }
    $checkBooking->close();

    // 🔹 Guest ID کو چیک کریں
    $checkGuest = $conn->prepare("SELECT guest_id FROM guests WHERE guest_id = ?");
    $checkGuest->bind_param("i", $guest_id);
    $checkGuest->execute();
    $checkGuest->store_result();

    if ($checkGuest->num_rows == 0) {
        die("Error: Guest ID does not exist in guests table.");
    }
    $checkGuest->close();

    // SQL کو تیار کریں
    $stmt = $conn->prepare("INSERT INTO billing (booking_id, guest_id, guest_name, room_type, room_price, nights, extra_charges, total_amount, billing_date) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("iissdidds", $booking_id, $guest_id, $guest_name, $room_type, $room_price, $nights, $extra_charges, $total_amount, $billing_date);

    // SQL کو ایکزیکیوٹ کریں اور چیک کریں کہ کامیاب ہوا یا نہیں
    if ($stmt->execute()) {
        echo "Bill generated successfully!";
    } else {
        echo "Error generating bill: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
