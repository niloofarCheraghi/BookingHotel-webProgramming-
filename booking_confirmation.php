<?php
session_start(); // Start the session to access session variables

// Check if the booking details are in the session
if (!isset($_SESSION['booking_details'])) {
    // If no booking details are available, redirect to the main page
    header("Location: index.php");
    exit();
}

// Get booking details from the session
$bookingDetails = $_SESSION['booking_details'];
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" href="styles_confirmation.css">
</head>
<body>
    <header>
        <h1>Booking Confirmation</h1>
    </header>

    <section class="confirmation-details">
        <h2>Thank you for your booking!</h2>
        <p>Your booking was successful. Below are your booking details:</p>

        <table class="confirmation-table">
            <tr>
                <td><strong>Name:</strong></td>
                <td><?php echo $bookingDetails['username']; ?></td>
            </tr>
            <tr>
                <td><strong>Room Number:</strong></td>
                <td><?php echo $bookingDetails['room_number']; ?></td>
            </tr>
            <tr>
                <td><strong>Check-in Date:</strong></td>
                <td><?php echo date("d-m-Y", strtotime($bookingDetails['check_in_date'])); ?></td>
            </tr>
            <tr>
                <td><strong>Check-out Date:</strong></td>
                <td><?php echo date("d-m-Y", strtotime($bookingDetails['check_out_date'])); ?></td>
            </tr>
            <tr>
                <td><strong>Room Type:</strong></td>
                <td><?php echo $bookingDetails['room_type'];?></td>
            </tr>
        </table>

        <div class="buttons">
            <a href="index.php" class="button">Go to Home</a>
            <a href="javascript:window.print();" class="button">Print</a>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Lotus Hotel</p>
    </footer>
</body>
</html>
