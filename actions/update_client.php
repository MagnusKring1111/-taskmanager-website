<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $client_id = $_POST['client_id'] ?? null;
    $navn = $_POST['navn'] ?? '';
    $kontakt = $_POST['kontaktperson'] ?? '';
    $email = $_POST['email'] ?? '';
    $telefon = $_POST['telefon'] ?? '';
    $adresse = $_POST['adresse'] ?? '';

    if ($client_id && $navn) {
        $stmt = $pdo->prepare("UPDATE clients SET navn = ?, kontaktperson = ?, email = ?, telefon = ?, adresse = ? WHERE id = ?");
        $stmt->execute([$navn, $kontakt, $email, $telefon, $adresse, $client_id]);

        header("Location: ../pages/clients.php");
        exit;
    } else {
        die("Manglende data.");
    }
}
