<?php
session_start();

$host = "localhost";
$dbname = "u551535768_hotel_booking";
$username = "u551535768_Vivek961";
$password = "Kanpur@2026";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>