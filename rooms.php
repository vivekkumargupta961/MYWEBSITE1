<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

$stmt = $pdo->query("SELECT * FROM rooms ORDER BY id ASC");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rooms - My Hotel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">My Hotel</div>
    <div>
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>

        <?php if (isset($_SESSION["user_id"])): ?>
            <a href="my-bookings.php">My Bookings</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <h2>Available Rooms</h2>

    <?php if (isset($_SESSION["user_name"])): ?>
        <p style="margin-top:10px;">Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?>.</p>
    <?php endif; ?>

    <br>

    <?php if (count($rooms) === 0): ?>
        <div class="message error">
            No rooms found. Please add room records in the database.
        </div>
    <?php else: ?>
        <div class="room-grid">
            <?php foreach ($rooms as $room): ?>
                <div class="room-card">
                    <img src="<?php echo htmlspecialchars($room["image"]); ?>" alt="Room Image">

                    <div class="room-content">
                        <h3><?php echo htmlspecialchars($room["room_name"]); ?></h3>
                        <p><?php echo htmlspecialchars($room["description"]); ?></p>
                        <p class="price">₹<?php echo htmlspecialchars($room["price"]); ?> / night</p>

                        <?php if (isset($_SESSION["user_id"])): ?>
                            <a class="btn" href="book.php?room_id=<?php echo $room["id"]; ?>">Book Now</a>
                        <?php else: ?>
                            <a class="btn" href="login.php">Login to Book</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>