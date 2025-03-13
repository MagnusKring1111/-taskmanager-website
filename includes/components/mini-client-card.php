<?php
// Required: $client must be passed in
if (!isset($client)) return;
?>

<a href="/pages/client.php?id=<?= $client['id'] ?>" class="mini-task-card">
    <div class="mini-task-title"><?= htmlspecialchars($client['navn']) ?></div>
    <div class="mini-task-sub">
        <?= htmlspecialchars($client['email'] ?? '-') ?>
    </div>
</a>
