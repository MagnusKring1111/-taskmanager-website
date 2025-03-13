<?php
// Required: $task object must be passed in
if (!isset($task)) return;

// Format creation date
$created = new DateTime($task['oprettet_dato'] ?? $task['created_at'] ?? 'now');

// Priority badge only if Høj
$showPriority = strtolower($task['prioritet']) === 'høj';

// Description shortening
$desc = strip_tags($task['beskrivelse']);
$shortDesc = mb_strlen($desc) > 180 ? mb_substr($desc, 0, 180) . '…' : $desc;

// Status class (for left border color)
$statusClass = 'status-' . ($task['status_id'] ?? 1);
?>

<a href="task.php?id=<?= $task['id'] ?>" class="task-card-link">
    <div class="task-card <?= $statusClass ?>" data-task-id="<?= $task['id'] ?>" draggable="true">
        <div class="task-card-top">
            <div class="task-title-block">
                <h3 class="task-title"><?= htmlspecialchars($task['titel']) ?></h3>
            </div>
            <div class="task-top-right">
                <?php if ($showPriority): ?>
                    <div class="tooltip-wrapper">
                        <span class="priority-badge priority-high">Høj</span>
                        <span class="tooltip">Prioritet: Høj</span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($task['deadline'])): ?>
                    <?php include_once __DIR__ . '/deadline-badge.php'; ?>
                    <?php renderDeadlineBadge($task['deadline']); ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- CLIENT SECTION -->
        <div class="task-block">
            <div class="block-label">Kunde:</div>
            <div class="block-content"><?= htmlspecialchars($task['kunde_navn'] ?? '-') ?></div>
        </div>

        <!-- DESCRIPTION SECTION -->
        <div class="task-block">
            <div class="block-label">Beskrivelse:</div>
            <div class="block-content"><?= htmlspecialchars($shortDesc) ?></div>
        </div>

        <!-- CREATED DATE -->
        <div class="task-card-bottom">
            <span></span>
            <div class="task-created">
                <strong>Oprettet:</strong> <?= $created->format('Y-m-d') ?>
            </div>
        </div>
    </div>
</a>
