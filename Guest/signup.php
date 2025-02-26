<?php
session_start();
include 'Connect.php';  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Fetch and trim form inputs
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $password  = trim($_POST['password']);
    $user_type = trim($_POST['user_type']);  

    if (empty($full_name) || empty($email) || empty($password) || empty($user_type)) {
        echo "All fields are required. Please <a href='index.html'>go back</a>.";
        exit();
    }
    
    // Determine the target table and primary key based on user type
    if ($user_type === 'guest') {
        $table = 'guests';
    } elseif ($user_type === 'manager') {
        $table = 'managers';
    } elseif ($user_type === 'staff') {
        $table = 'staff';
    } else {
        echo "Invalid user type.";
        exit();
    }
    
    // Check if email is already registered in the selected table
    $checkQuery = "SELECT * FROM $table WHERE email = '$email' LIMIT 1";
    $checkResult = $conn->query($checkQuery);
    if ($checkResult && $checkResult->num_rows > 0) {
        echo "Email already registered. Please <a href='index.html'>login</a>.";
        exit();
    }
    
    // In production, use password_hash() instead of storing plain text passwords.
    $hashed_password = $password; 
    
    $sql = "INSERT INTO $table (full_name, email, password) 
            VALUES ('$full_name', '$email', '$hashed_password')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.html");
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    header("Location: index.html");
    exit();
}
?>