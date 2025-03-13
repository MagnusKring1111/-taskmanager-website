<?php
require_once '../config/db.php';
include_once '../includes/header.php';

$stmt = $pdo->prepare("SELECT id FROM task_statuses WHERE status_navn = 'Færdige opgaver' LIMIT 1");
$stmt->execute();
$status_row = $stmt->fetch();
$completed_status_id = $status_row ? $status_row['id'] : null;

if (!$completed_status_id) {
    echo "<p>Status 'Færdige opgaver' ikke fundet i systemet.</p>";
    include_once '../includes/footer.php';
    exit;
}

$stmt = $pdo->prepare("
    SELECT tasks.*, clients.navn AS kunde_navn 
    FROM tasks 
    LEFT JOIN clients ON tasks.kunde_id = clients.id 
    WHERE status_id = ? 
    ORDER BY deadline DESC, oprettet_dato DESC
");
$stmt->execute([$completed_status_id]);
$tasks = $stmt->fetchAll();
?>

<h2>Arkiv: Færdige opgaver</h2>

<?php if (count($tasks)): ?>
    <div class="taskboard">
        <div class="column">
            <?php foreach ($tasks as $task): ?>
                <?php include '../includes/components/task-card.php'; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php else: ?>
    <p>Ingen færdige opgaver i arkivet.</p>
<?php endif; ?>

<?php include_once '../includes/footer.php'; ?>
