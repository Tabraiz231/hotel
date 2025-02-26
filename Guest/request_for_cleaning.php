<?php
session_start();
include 'Connect.php';

if (isset($_POST['submit_cleaning_request'])) {

    $guest_id        = $_SESSION['user_id'];
    $room_number     = $_REQUEST['room-number'];
    $cleaning_date   = $_REQUEST['cleaning-date'];
    $cleaning_time   = $_REQUEST['cleaning-time'];
    $special_requests = $_REQUEST['special-requests'];

    $sql = "INSERT INTO cleaning_requests (guest_id, room_number, cleaning_date, cleaning_time, special_requests)
            VALUES ('$guest_id', '$room_number', '$cleaning_date', '$cleaning_time', '$special_requests')";

    if ($conn->query($sql) === TRUE) {
        echo "Your cleaning request has been submitted successfully.";
    } else {
        echo "Error: " . $conn->error;
    }
    $conn->close();
} else {
    header("Location: request for cleaning.html");
    exit();
}
?>
