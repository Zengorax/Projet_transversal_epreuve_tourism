<?php
$dsn = 'mysql:host=localhost;http://localhost/phpmyadmin/index.php?route=/database/structure&db=agence+de+tourisme';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    // Set error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
