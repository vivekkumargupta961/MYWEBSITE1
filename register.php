<?php
include "config.php";

$message = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    if(empty($name) || empty($email) || empty($password)) {
        $message = "All fields are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $hashedPassword]);

            header("Location: login.php");
            exit;
        } catch(PDOException $e) {
            $message = "Email already exists.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">My Hotel</div>
    <div>
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>
        <a href="login.php">Login</a>
    </div>
</div>

<div class="form-box">
    <h2>Create Account</h2>

    <?php if($message): ?>
        <div class="message error"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <input type="text" name="name" placeholder="Full Name">
        <input type="email" name="email" placeholder="Email Address">
        <input type="password" name="password" placeholder="Password">
        <button class="btn" type="submit">Register</button>
    </form>

    <p style="margin-top: 15px;">
        Already have account? <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>