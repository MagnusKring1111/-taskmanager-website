<?php
$host = 'localhost';
$db = 'u201474444_taskmanager';
$user = 'u201474444_proprint';
$pass = '&o0NCI9b';
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, $options);
} catch (PDOException $e) {
    die("DB-forbindelsesfejl: " . $e->getMessage());
}
?>
