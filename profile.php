<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Profile - My Hotel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">My Hotel</div>
    <div>
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>
        <a href="my-bookings.php">My Bookings</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <div class="form-box">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?></h2>

        <p><strong>Email:</strong> <?php echo htmlspecialchars($_SESSION["user_email"]); ?></p>

        <br>

        <a class="btn" href="rooms.php">View Available Rooms</a>
        <br><br>
        <a class="btn" href="my-bookings.php">My Bookings</a>
        <br><br>
        <a class="btn" href="logout.php">Logout</a>
    </div>
</div>

</body>
</html>