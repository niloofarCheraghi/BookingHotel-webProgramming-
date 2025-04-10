<?php
include 'config/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $login_input = $_POST['login_input']; // Email or username
    $password = $_POST['password'];

    // Admin check
    if ($login_input == 'admin' && $password == 'admin') {
        $_SESSION['user_id'] = 'admin';  
        $_SESSION['username'] = 'admin'; 
        $_SESSION['is_admin'] = true;   
        header("Location: admin_dashboard.php");  // Redirect to admin dashboard
        exit();
    }

    // Query to check if the input is an email or username
    $sql = "SELECT * FROM users WHERE email = '$login_input' OR username = '$login_input'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Check if the entered password matches the stored password
        if ($password == $user['password']) {
            $_SESSION['user_id'] = $user['id'];  // Store user ID in session
            $_SESSION['username'] = $user['username']; // Store username in session
            $_SESSION['is_admin'] = false; 
            header("Location: index.php");  // Redirect to the main page
            exit();
        } else {
            $message = "❌ Incorrect password!";
        }
    } else {
        $message = "❌ User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles_login.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="text" name="login_input" placeholder="Email or Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button class="btn" type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Sign up here</a></p>
        <p>Go to home page: <a href="index.php">HOME</a></p>
        <?php if (isset($message)) { echo "<p>$message</p>"; } ?>
    </div>
</body>
</html>
