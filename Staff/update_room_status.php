<?php
// Database connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "hotel_management"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$room_id = $_POST['room_id'];
$room_status = $_POST['room_status'];
$assigned_staff = $_POST['assigned_staff'];

// Insert data into the database
$sql = "INSERT INTO room_status (room_id, room_status, assigned_staff) VALUES ('$room_id', '$room_status', '$assigned_staff')";

if ($conn->query($sql) === TRUE) {
    echo "Room status updated successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>