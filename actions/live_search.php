<?php
require_once '../config/db.php';
header('Content-Type: application/json');

$q = trim($_GET['q'] ?? '');
if (!$q) {
    echo json_encode(['tasks' => [], 'clients' => []]);
    exit;
}

// Fetch tasks
$stmt = $pdo->prepare("
    SELECT tasks.*, clients.navn AS kunde_navn
    FROM tasks
    LEFT JOIN clients ON tasks.kunde_id = clients.id
    WHERE tasks.titel LIKE :q
        OR tasks.beskrivelse LIKE :q
        OR clients.navn LIKE :q
        OR tasks.deadline LIKE :q
        OR tasks.oprettet_dato LIKE :q
    ORDER BY deadline ASC
    LIMIT 5
");
$stmt->execute(['q' => "%$q%"]);
$tasks = $stmt->fetchAll();

require_once '../includes/components/deadline-badge.php';

foreach ($tasks as &$task) { 
    ob_start();
    renderDeadlineBadge($task['deadline']);
    $task['deadline_badge'] = ob_get_clean();
}

// Fetch clients
$stmt2 = $pdo->prepare("SELECT * FROM clients WHERE navn LIKE :q OR email LIKE :q LIMIT 5");
$stmt2->execute(['q' => "%$q%"]);
$clients = $stmt2->fetchAll();

echo json_encode(['tasks' => $tasks, 'clients' => $clients]);
