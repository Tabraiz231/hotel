<?php
session_start();
include '../Guest/Connect.php'; // یقینی بنائیں کہ راستہ درست ہے

// کنکشن چیک کریں
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// چیک کریں کہ درخواست POST ہے
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // چیک کریں کہ منیجر لاگ ان ہے
    if (!isset($_SESSION['user_id'])) {
        echo "Please login to add a room. <a href='index.html'>Login here</a>.";
        exit();
    }

    // فارم ڈیٹا کو محفوظ طریقے سے حاصل کریں
    $room_number = trim($_POST['room-number']);
    $room_type   = trim($_POST['room-type']);
    $price       = trim($_POST['price']);
    $status      = trim($_POST['status']);

    // چیک کریں کہ تمام فیلڈز بھرے گئے ہیں
    if (empty($room_number) || empty($room_type) || empty($price) || empty($status)) {
        echo "All fields are required. Please <a href='Manager.html'>go back</a> and complete the form.";
        exit();
    }

    // SQL انجیکشن سے بچنے کے لیے Prepared Statement استعمال کریں
    $stmt = $conn->prepare("INSERT INTO rooms (room_number, room_type, price, status) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $room_number, $room_type, $price, $status);
    
    if ($stmt->execute()) {
        echo "Room added successfully! <a href='Manager.html'>Go back</a>.";
    } else {
        echo "Error adding room: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
 } 

?>
