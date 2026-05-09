<?php include "config.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Hotel Booking Website</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">My Hotel</div>
    <div>
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>

        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="my-bookings.php">My Bookings</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<div class="hero">
    <div>
        <h1>Book Your Perfect Stay</h1>
        <p>Comfortable rooms, beautiful views, and easy booking.</p>
        <a class="btn" href="rooms.php">View Rooms</a>
    </div>
</div>

<div class="container">
    <h2>Welcome to My Hotel</h2>
    <p style="margin-top: 15px;">
        Choose your room, check availability, and book your stay online.
    </p>
</div>

</body>
</html>