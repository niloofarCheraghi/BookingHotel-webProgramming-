<?php
session_start(); // Start the session to access session variables

// Connect to the database
$conn = new mysqli("localhost", "root", "", "hotel_booking_db");

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// If the user is not logged in and tries to book, redirect to login page
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['book_room'])) {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }

    // Get room number and check-in/check-out dates from the form
    $roomNumber = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $check_in_date = isset($_POST['check_in_date']) ? $_POST['check_in_date'] : null;
    $check_out_date = isset($_POST['check_out_date']) ? $_POST['check_out_date'] : null;

    // Check if dates are selected
    if ($check_in_date && $check_out_date) {
        // Prepare and format the date to YYYY-MM-DD format
        $check_in_date = date("Y-m-d", strtotime($check_in_date));
        $check_out_date = date("Y-m-d", strtotime($check_out_date));
    } else {
        // Handle error: dates are required
        echo "Please select both check-in and check-out dates.";
        exit();
    }

    $userId = $_SESSION['user_id']; // Get user ID from session

    // SQL query to insert the booking into the database
    $sql = "INSERT INTO bookings (user_id, room_number, room_type, check_in_date, check_out_date)
        VALUES ('$userId', '$roomNumber', '$room_type', '$check_in_date', '$check_out_date')";

    // Check if the query was successful
    if ($conn->query($sql) === TRUE) {
        // Store booking details in session for confirmation
        $_SESSION['booking_details'] = [
            'username' => $_SESSION['username'],
            'room_number' => $roomNumber,
            'room_type' => $room_type,  // Store room_type in session
            'check_in_date' => $check_in_date,
            'check_out_date' => $check_out_date
        ];
        header("Location: booking_confirmation.php"); // Redirect to confirmation page
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lotus Hotel</title>
    <link rel="stylesheet" href="styles_index.css">
</head>
<body>
<header>
    <div class="header-left">
        <h1 class="welcome-text">Welcome to Lotus Hotel</h1>
    </div>
    <div class="header-right">
        <?php if (!isset($_SESSION['username'])): ?>
            <!-- If user is not logged in, show login and register links -->
            <a href="login.php" class="auth-links">Login</a>
            <a href="register.php" class="auth-links">Register</a>
        <?php else: ?>
            <!-- If user is logged in, show welcome message, dashboard, and logout link -->
            <span class="auth-links">Hello, <?php echo $_SESSION['username']; ?>!</span>
            <a href="user_dashboard.php" class="auth-links">Dashboard</a> <!-- User dashboard link -->

            <!-- Show Admin Dashboard link if the user is an admin -->
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                <a href="admin_dashboard.php" class="auth-links">Admin Dashboard</a> <!-- Admin Dashboard link -->
            <?php endif; ?>

            <a href="logout.php" class="auth-links">Logout</a>
        <?php endif; ?>
    </div>
</header>


    <section class="room-table">
        <div class="container">
            <h2 class="section-title">Available rooms</h2>
            <table class="room-list">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Type</th>
                        <th>Price per Night</th>
                        <th>Availability</th>
                        <th>Select</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // SQL query to fetch room data from the database
                    $sql = "SELECT room_number, room_type, price_per_night, availability FROM rooms";
                    $result = $conn->query($sql);

                    // Check if any rooms are available
                    if ($result->num_rows > 0) {
                        // Loop through the results and display each room
                        while ($row = $result->fetch_assoc()) {
                            $availability = ($row["availability"] == 1) ? "Available" : "Occupied";
                            $buttonClass = ($row["availability"] == 1) ? "book-btn" : "book-btn occupied";
                            $buttonDisabled = ($row["availability"] == 1) ? "" : "disabled";

                            // Output the room details in table rows
                            echo "<tr>
                                    <td>" . $row["room_number"] . "</td>
                                    <td>" . $row["room_type"] . "</td>
                                    <td>" . $row["price_per_night"] . " €</td>
                                    <td>" . $availability . "</td>
                                    <td>
                                        <input type='radio' name='room_selection' value='" . $row["room_number"] . "' $buttonDisabled />
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No rooms available</td></tr>";
                    }
                    ?>
                </tbody>
            </table>

            <!-- Check-in and check-out date fields -->
            <form method="POST" action="">
                <input type="hidden" name="room_number" id="selected_room" value="">
                <input type="hidden" name="room_type" id="selected_room_type" value=""> <!-- Hidden room type field -->

                <div class="check-dates">
                    <label for="check_in_date">Check-in Date:</label>
                    <input type="date" id="check_in_date" name="check_in_date" required>

                    <label for="check_out_date">Check-out Date:</label>
                    <input type="date" id="check_out_date" name="check_out_date" required>
                </div>

                <input type="submit" name="book_room" id="bookNowButton" value="Book Now" disabled>
            </form>
        </div>
    </section>

    <script src="script.js"></script>
</body>
</html>