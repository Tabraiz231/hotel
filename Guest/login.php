<?php
session_start();
include 'Connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);  
    $password = trim($_POST['password']);


    $user_tables = [
        'guests'   => ['id_field' => 'guest_id',   'type' => 'guest'],
        'managers' => ['id_field' => 'manager_id', 'type' => 'manager'],
        'staff'    => ['id_field' => 'staff_id',   'type' => 'staff']
    ];

    $found = false;
    foreach ($user_tables as $table => $info) {
        $id_field = $info['id_field'];
        $type     = $info['type'];

        $sql = "SELECT * FROM $table WHERE email = '$username' AND password = '$password' LIMIT 1";
        $result = $conn->query($sql);

        if ($result && $result->num_rows == 1) {
            $user = $result->fetch_assoc();
            $_SESSION['user_id']   = $user[$id_field];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['user_type'] = $type;
            $found = true;
            break;
        }
    }

    if ($found) {
        // Redirect based on user type (adjust the target page as needed)
        if ($_SESSION['user_type'] == 'guest') {
            header("Location: Guest.html");
        } else if ($_SESSION['user_type'] == 'manager') {
            header("Location: Manager.html");
        } else if ($_SESSION['user_type'] == 'staff') {
            header("Location: Staff.html");
        }
        exit();
    } else {
        echo "Invalid credentials. Please <a href='index.html'>try again</a>.";
    }
} else {
    header("Location: index.html");
    exit();
}
?>
