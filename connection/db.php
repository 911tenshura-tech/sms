<?php
$host = 'localhost';
$dbname = 'sms_db';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    // If the database does not exist, we will try to create it below (used during setup)
    // Normally you would just fail here if it's purely a connection script
}
?>
