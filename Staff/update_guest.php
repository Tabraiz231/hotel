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
$guest_id = $_POST['guest_id'];
$guest_name = $_POST['guest_name'];
$contact = $_POST['contact'];
$email = $_POST['email'];
$room_number = $_POST['room_number'];

// Insert data into the database
$sql = "INSERT INTO guest_details (guest_id, guest_name, contact, email, room_number) VALUES ('$guest_id', '$guest_name', '$contact', '$email', '$room_number')";

if ($conn->query($sql) === TRUE) {
    echo "Guest details updated successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>