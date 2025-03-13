<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $navn = $_POST['navn'] ?? '';
    $kontakt = $_POST['kontaktperson'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    if ($navn) {
        $stmt = $pdo->prepare("INSERT INTO clients (navn, kontaktperson, email, telefon, adresse) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$navn, $kontakt, $email, $telefon, $adresse]);

        header("Location: ../pages/clients.php");
        exit;
    } else {
        die("Firmanavn er påkrævet.");
    }
}
