<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titel = $_POST['titel'] ?? '';
    $beskrivelse = $_POST['beskrivelse'] ?? '';
    $kunde_id = $_POST['kunde_id'] ?? null;
    $status_id = $_POST['status_id'] ?? null;
    $prioritet = ($_POST['prioritet'] === 'Høj') ? 'Høj' : 'Normal';
    $kategori = $_POST['kategori'] ?? 'Andet';

    // Combine deadline date + time
    $deadline_date = $_POST['deadline_date'] ?? '';
    $deadline_time = $_POST['deadline_time'] ?? '00:00';
    $deadline = $deadline_date ? $deadline_date . ' ' . $deadline_time . ':00' : null;

    $filnavn = null;
    if (!empty($_FILES['fil']['name'])) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $filnavn = time() . '_' . basename($_FILES['fil']['name']);
        move_uploaded_file($_FILES['fil']['tmp_name'], $uploadDir . $filnavn);
    }

    if ($titel && $kunde_id && $status_id) {
        $stmt = $pdo->prepare("INSERT INTO tasks (titel, beskrivelse, kunde_id, status_id, deadline, prioritet, kategori, filnavn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titel, $beskrivelse, $kunde_id, $status_id, $deadline, $prioritet, $kategori, $filnavn]);
        header("Location: ../pages/dashboard.php");
        exit;
    } else {
        die("Manglende felter. Prøv igen.");
    }
}
