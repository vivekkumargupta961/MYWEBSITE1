<?php
include "config.php";

if(!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if(!isset($_GET["room_id"])) {
    header("Location: rooms.php");
    exit;
}

$room_id = $_GET["room_id"];
$user_id = $_SESSION["user_id"];
$message = "";

$stmt = $pdo->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$room) {
    die("Room not found.");
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];

    if(empty($check_in) || empty($check_out)) {
        $message = "Please select check-in and check-out dates.";
    } elseif($check_out <= $check_in) {
        $message = "Check-out date must be after check-in date.";
    } else {
        $stmt = $pdo->prepare("
            SELECT COUNT(*) FROM bookings
            WHERE room_id = ?
            AND status IN ('pending', 'confirmed')
            AND (
                check_in < ?
                AND check_out > ?
            )
        ");

        $stmt->execute([$room_id, $check_out, $check_in]);
        $alreadyBooked = $stmt->fetchColumn();

        if($alreadyBooked > 0) {
            $message = "Sorry, this room is not available for selected dates.";
        } else {
            $stmt = $pdo->prepare("
                INSERT INTO bookings (user_id, room_id, check_in, check_out, status)
                VALUES (?, ?, ?, ?, 'pending')
            ");

            $stmt->execute([$user_id, $room_id, $check_in, $check_out]);

            header("Location: my-bookings.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Room</title>
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

<div class="form-box">
    <h2>Book <?php echo htmlspecialchars($room["room_name"]); ?></h2>

    <img src="<?php echo htmlspecialchars($room["image"]); ?>" style="width:100%; height:220px; object-fit:cover; border-radius:8px; margin-bottom:15px;">

    <p><?php echo htmlspecialchars($room["description"]); ?></p>
    <p class="price">₹<?php echo htmlspecialchars($room["price"]); ?> / night</p>

    <?php if($message): ?>
        <div class="message error"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label>Check-in Date</label>
        <input type="date" name="check_in" required>

        <label>Check-out Date</label>
        <input type="date" name="check_out" required>

        <button class="btn" type="submit">Confirm Booking</button>
    </form>
</div>

</body>
</html>