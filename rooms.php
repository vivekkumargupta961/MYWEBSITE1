<?php
include "config.php";

$stmt = $pdo->query("SELECT * FROM rooms ORDER BY id DESC");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Rooms</title>
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

<div class="container">
    <h2>Available Rooms</h2>
    <br>

    <div class="room-grid">
        <?php foreach($rooms as $room): ?>
            <div class="room-card">
                <img src="<?php echo htmlspecialchars($room['image']); ?>" alt="Room Image">
                <div class="room-content">
                    <h3><?php echo htmlspecialchars($room['room_name']); ?></h3>
                    <p><?php echo htmlspecialchars($room['description']); ?></p>
                    <p class="price">₹<?php echo htmlspecialchars($room['price']); ?> / night</p>
                    <a class="btn" href="book.php?room_id=<?php echo $room['id']; ?>">Book Now</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</body>
</html>