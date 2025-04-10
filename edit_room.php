<?php
session_start();
include 'config/db.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['room_number'])) {
    $room_number = $_GET['room_number'];
    $sql = "SELECT * FROM rooms WHERE room_number = '$room_number'";
    $result = $conn->query($sql);
    $room = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_type = $_POST['room_type'];
    $price_per_night = $_POST['price_per_night'];
    $availability = $_POST['availability'];

    $sql = "UPDATE rooms SET room_type='$room_type', price_per_night='$price_per_night', availability='$availability' WHERE room_number='$room_number'";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "Error updating room: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link rel="stylesheet" href="styles_admin.css">
</head>
<body>
    <div class="container">
        <h2>Edit Room</h2>
        <form method="POST">
            <input type="text" name="room_type" value="<?= $room['room_type'] ?>" required>
            <input type="number" step="0.01" name="price_per_night" value="<?= $room['price_per_night'] ?>" required>
            <select name="availability">
                <option value="1" <?= $room['availability'] ? 'selected' : '' ?>>Available</option>
                <option value="0" <?= !$room['availability'] ? 'selected' : '' ?>>Not Available</option>
            </select>
            <button type="submit" class="btn">Save Changes</button>
        </form>
        <a href="admin_dashboard.php" class="btn">Back</a>
    </div>
</body>
</html>