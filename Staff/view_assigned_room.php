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
$staff_id = $_POST['staff_id'];

// Retrieve data from the database
$sql = "SELECT * FROM room_status WHERE room_id = '$room_id' AND assigned_staff = '$staff_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "Room ID: " . $row["room_id"]. " - Status: " . $row["room_status"]. " - Assigned Staff: " . $row["assigned_staff"]. "<br>";
    }
} else {
    echo "No assigned room found for the given details.";
}

$conn->close();
?>