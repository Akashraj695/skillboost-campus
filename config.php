<?php
session_start();

$host = "localhost";
$db   = "skillboost_campus";
$user = "root";
$pass = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("Database connection failed. Make sure MySQL is running and database.sql was imported.");
}

function require_login() {
    if (!isset($_SESSION['user'])) {
        header("Location: index.php");
        exit;
    }
}

function current_user() {
    return $_SESSION['user'] ?? null;
}
?>
