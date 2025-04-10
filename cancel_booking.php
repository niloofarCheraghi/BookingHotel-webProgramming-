<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Connect to the database
$conn = new mysqli("localhost", "root", "", "hotel_booking_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Make sure the booking_id is set and is valid
if (isset($_POST['booking_id'])) {
    $bookingId = $_POST['booking_id'];
    
    // Get the user ID from session
    $userId = $_SESSION['user_id'];

    // Check if the booking belongs to the user
    $sql = "SELECT * FROM bookings WHERE id = '$bookingId' AND user_id = '$userId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Delete the booking from the database
        $sql = "DELETE FROM bookings WHERE id = '$bookingId'";
        if ($conn->query($sql) === TRUE) {
            $_SESSION['message'] = "Booking cancelled successfully.";
        } else {
            $_SESSION['message'] = "Error: " . $conn->error;
        }
    } else {
        // If the booking does not belong to the user
        $_SESSION['message'] = "You don't have permission to cancel this booking.";
    }

    // Redirect to the dashboard after cancellation
    header("Location: user_dashboard.php");
    exit();
} else {
    // If no booking_id is set
    $_SESSION['message'] = "Booking ID is missing.";
    header("Location: user_dashboard.php");
    exit();
}
?>
