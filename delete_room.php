<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['room_number'])) {
    $room_number = $_GET['room_number'];
    $sql = "DELETE FROM rooms WHERE room_number = '$room_number'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error deleting room: " . $conn->error;
    }
}
?>
