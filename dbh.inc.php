<?php
$host = 'localhost'; 
$dbname = 'anime'; 
$username = 'bit_academy'; 
$password = 'bit_academy';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>