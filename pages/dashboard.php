<?php
require_once '../config/db.php';
include_once '../includes/header.php';

// Hent statuser undtagen færdige
$statuses = $pdo->query("SELECT * FROM task_statuses WHERE status_navn != 'Færdige opgaver'")->fetchAll();

// Hent opgaver per status
$tasks_by_status = [];
foreach ($statuses as $status) {
    $stmt = $pdo->prepare("
        SELECT tasks.*, clients.navn AS kunde_navn 
        FROM tasks 
        LEFT JOIN clients ON tasks.kunde_id = clients.id 
        WHERE status_id = ?
        ORDER BY deadline ASC, oprettet_dato DESC
    ");
    $stmt->execute([$status['id']]);
    $tasks_by_status[$status['id']] = $stmt->fetchAll();
}
?>

<h2>Opgaveoversigt</h2>

<section class="taskboard">
    <?php foreach ($statuses as $status): ?>
        <div class="column">
            <h2><?= htmlspecialchars($status['status_navn']) ?></h2>
            <div class="task-list" data-status-id="<?= $status['id'] ?>">
                <?php if (!empty($tasks_by_status[$status['id']])): ?>
                    <?php foreach ($tasks_by_status[$status['id']] as $task): ?>
                        <?php include '../includes/components/task-card.php'; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-tasks">Ingen opgaver</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</section>

<?php include_once '../includes/footer.php'; ?>
