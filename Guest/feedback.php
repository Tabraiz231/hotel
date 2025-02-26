<?php
session_start();
include 'Connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    
    if (!isset($_SESSION['user_id'])) {
        echo "Please login to submit your feedback. <a href='index.html'>Login here</a>.";
        exit();
    }
    
    // Retrieve guest ID from session
    $guest_id = $_SESSION['user_id'];

    // Use $_REQUEST instead of trim()
    $name     = $_REQUEST['name'];
    $email    = $_REQUEST['email'];
    $rating   = (int) $_REQUEST['rating'];
    $comments = $_REQUEST['comments'];
    
    // Basic validation
    if (empty($name) || empty($email) || empty($rating)) {
        echo "Name, Email, and Rating are required. Please <a href='feedback.html'>go back</a> and complete the form.";
        exit();
    }
    
    // Insert feedback into the feedback table (foreign key references guests(guest_id))
    $sql = "INSERT INTO feedback (guest_id, name, email, rating, comments)
            VALUES ('$guest_id', '$name', '$email', '$rating', '$comments')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Thank you for your feedback!";
    } else {
        echo "Error submitting feedback: " . $conn->error;
    }
} else {
    header("Location: feedback.html");
    exit();
}
?>
