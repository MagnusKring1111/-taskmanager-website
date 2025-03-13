<?php
// Required: $task must be passed in
if (!isset($task)) return;

$deadlineBadge = '';
if (!function_exists('renderDeadlineBadge')) {
    require_once __DIR__ . '/deadline-badge.php';
    ob_start();
    renderDeadlineBadge($task['deadline']);
    $deadlineBadge = ob_get_clean();
} else {
    ob_start();
    renderDeadlineBadge($task['deadline']);
    $deadlineBadge = ob_get_clean();
}
?>

<a href="/pages/task.php?id=<?= $task['id'] ?>" class="mini-task-card">
    <div class="mini-task-title"><?= htmlspecialchars($task['titel']) ?></div>
    <div class="mini-task-sub">
        <a href="/pages/client.php?id=<?= $task['kunde_id'] ?>" class="client-link"><?= htmlspecialchars($task['kunde_navn']) ?></a>
        <?= $deadlineBadge ?>
    </div>
</a>
