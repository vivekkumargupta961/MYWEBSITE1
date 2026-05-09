<?php
include "config.php";

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("
    SELECT bookings.*, rooms.room_name, rooms.room_type, rooms.price
    FROM bookings
    JOIN rooms ON bookings.room_id = rooms.id
    WHERE bookings.user_id = ?
    ORDER BY bookings.id DESC
");

$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">My Hotel</div>
    <div>
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="container">
    <h2>My Bookings</h2>
    <br>

    <?php if(count($bookings) == 0): ?>
        <p>No bookings found.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Room</th>
                <th>Type</th>
                <th>Price</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
            </tr>

            <?php foreach($bookings as $booking): ?>
                <tr>
                    <td><?php echo htmlspecialchars($booking["room_name"]); ?></td>
                    <td><?php echo htmlspecialchars($booking["room_type"]); ?></td>
                    <td>₹<?php echo htmlspecialchars($booking["price"]); ?></td>
                    <td><?php echo htmlspecialchars($booking["check_in"]); ?></td>
                    <td><?php echo htmlspecialchars($booking["check_out"]); ?></td>
                    <td><?php echo htmlspecialchars($booking["status"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>

</body>
</html>