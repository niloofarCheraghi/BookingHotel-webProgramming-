<?php
$host = "localhost";  // Server (bei XAMPP is localhost)
$user = "root";       // Standard username in XAMPP
$password = "";       
$database = "hotel_booking_db"; // datenbank name

// create connection
$conn = new mysqli($host, $user, $password, $database);

// connection test
if ($conn->connect_error) {
    die("connection failed: " . $conn->connect_error);
}
?>
