<?php
session_start();
include '../Guest/Connect.php';

// Connection Check
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (!isset($_SESSION['user_id'])) {
        echo "Please login to manage records. <a href='index.html'>Login here</a>.";
        exit();
    }

    // Get and sanitize input data
    $record_id    = trim($_POST['recordID']);
    $guest_name   = trim($_POST['guestName']);
    $room_number  = trim($_POST['roomNumber']);
    $check_in     = trim($_POST['checkInDate']);
    $check_out    = trim($_POST['checkOutDate']);
    $status       = trim($_POST['status']);

    // Check if fields are empty
    if (empty($record_id) || empty($guest_name) || empty($room_number) || empty($check_in) || empty($check_out) || empty($status)) {
        echo "All fields are required.";
        exit();
    }

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO records (record_id, guest_name, room_number, check_in_date, check_out_date, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $record_id, $guest_name, $room_number, $check_in, $check_out, $status);

    // Execute and check for errors
    if ($stmt->execute()) {
        echo "Record added successfully!";
    } else {
        echo "Error adding record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
