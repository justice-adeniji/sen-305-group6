<?php
// Start session for login management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database credentials
$host = "127.0.0.1";
$port = 3307;
$dbname = "sen305-group6";
$username = "root";
$password = "";

// Database connection using try-catch
try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
