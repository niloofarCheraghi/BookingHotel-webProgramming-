<?php
session_start();
include 'config/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 'admin') {
    header("Location: login.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
    $room_number = $_POST['room_number'];
    $room_type = $_POST['room_type'];
    $price_per_night = $_POST['price_per_night'];
    $availability = $_POST['availability'];

    $sql = "INSERT INTO rooms (room_number, room_type, price_per_night, availability) 
            VALUES ('$room_number', '$room_type', '$price_per_night', '$availability')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Room added successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error adding room: " . $conn->error . "</p>";
    }
}


$sql = "SELECT * FROM rooms";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles_admin.css">
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>

        <div class="admin-buttons">
            <a href="index.php" class="btn">Back to Home</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <h3>Add New Room</h3>
        <form method="POST">
            <input type="number" name="room_number" placeholder="Room Number" required>
            <input type="text" name="room_type" placeholder="Room Type" required>
            <input type="number" step="0.01" name="price_per_night" placeholder="Price per Night" required>
            <select name="availability">
                <option value="1">Available</option>
                <option value="0">Not Available</option>
            </select>
            <button type="submit" name="add_room" class="btn">Add Room</button>
        </form>

        <h3>Manage Rooms</h3>
        <table class="room-list">
            <tr>
                <th>Room Number</th>
                <th>Room Type</th>
                <th>Price per Night</th>
                <th>Availability</th>
                <th>Actions</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['room_number'] ?></td>
                    <td><?= $row['room_type'] ?></td>
                    <td><?= $row['price_per_night'] ?>€</td>
                    <td><?= $row['availability'] ? 'Available' : 'Not Available' ?></td>
                    <td>
                        <a href="edit_room.php?room_number=<?= $row['room_number'] ?>" class="btn">Edit</a>
                        <a href="delete_room.php?room_number=<?= $row['room_number'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
</body>
</html>
