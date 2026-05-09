<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $message = "Please enter email and password.";
    } else {
        $stmt = $pdo->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user["password"])) {
            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];
            $_SESSION["user_email"] = $user["email"];

            header("Location: rooms.php");
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - My Hotel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="navbar">
    <div class="logo">My Hotel</div>
    <div>
        <a href="index.php">Home</a>
        <a href="rooms.php">Rooms</a>
        <a href="register.php">Register</a>
    </div>
</div>

<div class="form-box">
    <h2>Login</h2>

    <?php if ($message !== ""): ?>
        <div class="message error">
            <?php echo htmlspecialchars($message); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <input type="email" name="email" placeholder="Email Address" required>

        <input type="password" name="password" placeholder="Password" required>

        <button class="btn" type="submit">Login</button>
    </form>

    <p style="margin-top: 15px;">
        No account?
        <a href="register.php">Register here</a>
    </p>
</div>

</body>
</html>