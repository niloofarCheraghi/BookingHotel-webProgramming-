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

// Get user's bookings
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE user_id = '$userId'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="styles_dashboard.css">
</head>
<body>
    <header>
        <div class="header-left">
            <h1 class="welcome-text">User Dashboard</h1>
        </div>
        <div class="header-right">
            <span class="auth-links">Hello, <?php echo $_SESSION['username']; ?>!</span>
            <a href="logout.php" class="auth-links">Logout</a>
        </div>
    </header>

    <section class="bookings">
        <h2>Your Bookings</h2>

        <?php
        if ($result->num_rows > 0) {
            echo "<table class='bookings-table'>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Check-in Date</th>
                        <th>Check-out Date</th>
                        <th>Action</th>
                    </tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row["room_number"] . "</td>
                        <td>" . $row["room_type"] . "</td>
                        <td>" . date("d-m-Y", strtotime($row["check_in_date"])) . "</td>
                        <td>" . date("d-m-Y", strtotime($row["check_out_date"])) . "</td>
                        <td>
                            <form method='POST' action='cancel_booking.php'>
                                <input type='hidden' name='booking_id' value='" . $row["id"] . "'>
                                <button type='submit' class='cancel-btn'>Cancel Booking</button>
                            </form>
                        </td>
                    </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>You have no bookings yet.</p>";
        }
        ?>
    </section>
    <div class="back-to-home">
        <a href="index.php" class="button back-btn">back to home</a>
    </div>
    <footer>
        <p>&copy; 2025 Lotus Hotel</p>
    </footer>
</body>
</html>
