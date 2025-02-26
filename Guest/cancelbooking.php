<?php
session_start();
include 'Connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {


    $booking_id = $_REQUEST['booking-id'];
    $email      = $_REQUEST['email'];
    $reason     = $_REQUEST['reason']; // Optional reason


    if (empty($booking_id) || empty($email)) {
        echo "Booking ID and Email are required. Please <a href='cancelbooking.html'>go back</a>.";
        exit();
    }
    

    $sql_check = "SELECT * FROM bookings WHERE id = '$booking_id' AND email = '$email'";
    $result_check = $conn->query($sql_check);
    
    if ($result_check && $result_check->num_rows == 1) {
        $sql_delete = "DELETE FROM bookings WHERE id = '$booking_id' AND email = '$email'";
        if ($conn->query($sql_delete) === TRUE) {
            echo "Booking cancelled successfully.";
        } else {
            echo "Error cancelling booking: " . $conn->error;
        }
    } else {
        echo "No booking found with the provided details. Please check your Booking ID and Email.";
    }
} else {
    header("Location: cancelbooking.html");
    exit();
}
?>
