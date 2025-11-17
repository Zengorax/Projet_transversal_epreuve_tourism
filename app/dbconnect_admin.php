<?php
$servername = "localhost:3306";
$username = "admin";
$password = "1234";

try {
    $conn = new PDO("mysql:host=$servername;dbname=application tourisme;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
