<?php
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'] ?? null;
    $status_id = $_POST['status_id'] ?? null;

    if ($task_id && $status_id) {
        $stmt = $pdo->prepare("UPDATE tasks SET status_id = ? WHERE id = ?");
        $stmt->execute([$status_id, $task_id]);
    }

    // Only redirect if this was a normal form post (not JS fetch)
    if (empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
        header("Location: ../pages/dashboard.php");
        exit;
    }
}
