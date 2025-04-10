<?php
include 'config/db.php';
session_start();

// Admin check
if ($_SESSION['user_id'] != 'admin') {
    header("Location: index.php"); 
    exit();
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price_per_night = $_POST['price_per_night'];
    $availability = $_POST['availability'];

    // Insert new room into the database
    $sql = "INSERT INTO rooms (room_number, room_type, price_per_night, availability) 
            VALUES ('$room_number', '$room_type', '$price_per_night', '$availability')";

    if ($conn->query($sql) === TRUE) {
        echo "New room added successfully";
        header("Location: admin_dashboard.php"); // Redirect to admin dashboard after success
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
