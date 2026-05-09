<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

$message = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($name === "" || $email === "" || $password === "") {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Please enter a valid email address.";
    } elseif (strlen($password) < 5) {
        $message = "Password must be at least 5 characters.";
    } else {
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {
            $message = "Email already exists. Please login.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("
                INSERT INTO users (name, email, password)
                VALUES (?, ?, ?)
            ");

            if ($stmt->execute([$name, $email, $hashedPassword])) {
                $success = "Registration successful. Please login now.";
            } else {
                $message = "Registration failed. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register - My Hotel</title>
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

    <?php if ($message !== ""): ?>
        <div class="message error">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <?php if ($success !== ""): ?>
        <div class="message">
            <?php echo htmlspecialchars($success); ?>
            <br><br>
            <a class="btn" href="login.php">Go to Login</a>
        </div>
    <?php endif; ?>

    <?php if ($success === ""): ?>
        <form method="POST" action="register.php">
            <input type="text" name="name" placeholder="Full Name" required>

            <input type="email" name="email" placeholder="Email Address" required>

            <input type="password" name="password" placeholder="Password" required>

            <button class="btn" type="submit">Register</button>
        </form>
    <?php endif; ?>

    <p style="margin-top: 15px;">
        Already have account?
        <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>