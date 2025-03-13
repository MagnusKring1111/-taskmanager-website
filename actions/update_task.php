<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id    = $_POST['task_id'] ?? null;
    $titel      = $_POST['titel'] ?? '';
    $beskrivelse= $_POST['beskrivelse'] ?? '';
    $kunde_id   = $_POST['kunde_id'] ?? null;
    $status_id  = $_POST['status_id'] ?? null;
    $deadline   = $_POST['deadline'] ?? null; // Expecting format: 2025-03-11T15:00
    $prioritet  = $_POST['prioritet'] ?? 'Normal';
    $kategori   = $_POST['kategori'] ?? '';

    // Normalize datetime if needed
    if ($deadline !== null && $deadline !== '') {
        $deadline = str_replace('T', ' ', $deadline) . ':00'; // Add seconds to make it Y-m-d H:i:s
    } else {
        $deadline = null;
    }

    // File upload
    $filnavn = null;
    if (!empty($_FILES['fil']['name'])) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0777, true);
        $filnavn = time() . '_' . basename($_FILES['fil']['name']);
        move_uploaded_file($_FILES['fil']['tmp_name'], $uploadDir . $filnavn);
    }

    if ($task_id && $titel && $kunde_id && $status_id) {
        if ($filnavn) {
            $stmt = $pdo->prepare("UPDATE tasks SET titel=?, beskrivelse=?, kunde_id=?, status_id=?, deadline=?, prioritet=?, kategori=?, filnavn=? WHERE id=?");
            $stmt->execute([$titel, $beskrivelse, $kunde_id, $status_id, $deadline, $prioritet, $kategori, $filnavn, $task_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE tasks SET titel=?, beskrivelse=?, kunde_id=?, status_id=?, deadline=?, prioritet=?, kategori=? WHERE id=?");
            $stmt->execute([$titel, $beskrivelse, $kunde_id, $status_id, $deadline, $prioritet, $kategori, $task_id]);
        }

        header("Location: ../pages/task.php?id={$task_id}");
        exit;
    } else {
        die("Manglende data.");
    }
}
