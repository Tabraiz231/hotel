<?php
session_start();
include '../Guest/Connect.php'; // ڈیٹا بیس کنکشن

// چیک کریں کہ فارم سبمٹ ہوا ہے یا نہیں
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['user_id'])) {
        echo "Please login to assign cleaning requests. <a href='index.html'>Login here</a>.";
        exit();
    }

    // فارم کے ڈیٹا کو حاصل کریں
    $room_number = trim($_POST['roomNumber']);
    $staff_name  = trim($_POST['staffName']);
    $priority    = trim($_POST['priority']);
    $remarks     = trim($_POST['remarks']);

    // چیک کریں کہ ضروری فیلڈز خالی نہ ہوں
    if (empty($room_number) || empty($staff_name) || empty($priority)) {
        echo "Room Number, Staff Name, and Priority are required.";
        exit();
    }

    // ڈیٹا بیس میں انٹری ڈالنے کے لیے SQL کو تیار کریں
    $stmt = $conn->prepare("INSERT INTO cleaning_requests (room_number, staff_name, priority, remarks, request_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $room_number, $staff_name, $priority, $remarks);

    // SQL کو ایکزیکیوٹ کریں اور چیک کریں کہ کامیاب ہوا یا نہیں
    if ($stmt->execute()) {
        echo "Cleaning request assigned successfully!";
    } else {
        echo "Error assigning request: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
