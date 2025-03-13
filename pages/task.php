<?php
require_once '../config/db.php';
include_once '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Opgave-ID mangler.</p>";
    include_once '../includes/footer.php';
    exit;
}

$task_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT tasks.*, clients.navn AS kunde_navn FROM tasks LEFT JOIN clients ON tasks.kunde_id = clients.id WHERE tasks.id = ?");
$stmt->execute([$task_id]);
$task = $stmt->fetch();

if (!$task) {
    echo "<p>Opgaven blev ikke fundet.</p>";
    include_once '../includes/footer.php';
    exit;
}

$clients = $pdo->query("SELECT * FROM clients ORDER BY navn ASC")->fetchAll();
$statuses = $pdo->query("SELECT * FROM task_statuses")->fetchAll();
$editMode = isset($_GET['edit']) && $_GET['edit'] == 1;

// Format dates
$created = new DateTime($task['oprettet_dato']);
$deadline = $task['deadline'] ? new DateTime($task['deadline']) : null;
?>

<h2><?= $editMode ? "Rediger opgave: " . htmlspecialchars($task['titel']) : "Opgavedetaljer" ?></h2>

<div class="form" style="max-width: 700px; margin: 0 auto;">

    <?php if ($editMode): ?>
    <form action="../actions/update_task.php" method="post" enctype="multipart/form-data">
        <input type="hidden" name="task_id" value="<?= $task['id'] ?>">

        <div class="task-block">
            <div class="block-label">Titel:</div>
            <div class="block-content"><input type="text" name="titel" value="<?= htmlspecialchars($task['titel']) ?>" required></div>
        </div>

        <div class="task-block">
            <div class="block-label">Kunde:</div>
            <div class="block-content">
                <select name="kunde_id" required>
                    <?php foreach ($clients as $client): ?>
                        <option value="<?= $client['id'] ?>" <?= $client['id'] == $task['kunde_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($client['navn']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="task-block">
            <div class="block-label">Status:</div>
            <div class="block-content">
                <select name="status_id" required>
                    <?php foreach ($statuses as $status): ?>
                        <option value="<?= $status['id'] ?>" <?= $status['id'] == $task['status_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($status['status_navn']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="task-block">
            <div class="block-label">Prioritet:</div>
            <div class="block-content">
                <select name="prioritet">
                    <option value="Normal" <?= $task['prioritet'] == 'Normal' ? 'selected' : '' ?>>Normal</option>
                    <option value="Høj" <?= $task['prioritet'] == 'Høj' ? 'selected' : '' ?>>Høj</option>
                </select>
            </div>
        </div>

        <div class="task-block">
            <div class="block-label">Deadline:</div>
            <div class="block-content">
                <input type="datetime-local" name="deadline" value="<?= $deadline ? $deadline->format('Y-m-d\TH:i') : '' ?>">
            </div>
        </div>

        <div class="task-block">
            <div class="block-label">Beskrivelse:</div>
            <div class="block-content">
                <textarea name="beskrivelse" rows="4"><?= htmlspecialchars($task['beskrivelse']) ?></textarea>
            </div>
        </div>

        <div class="task-block">
            <div class="block-label">Oprettet:</div>
            <div class="block-content"><?= $created->format('Y-m-d') ?></div>
        </div>

        <?php if (!empty($task['filnavn'])): ?>
            <div class="task-block">
                <div class="block-label">Nuværende fil:</div>
                <div class="block-content">
                    <a href="../uploads/<?= htmlspecialchars($task['filnavn']) ?>" target="_blank"><?= htmlspecialchars($task['filnavn']) ?></a>
                </div>
            </div>
        <?php endif; ?>

        <div class="task-block">
            <div class="block-label">Udskift fil:</div>
            <div class="block-content"><input type="file" name="fil"></div>
        </div>

        <div style="text-align: right; margin-top: 20px;">
            <button type="submit" class="button">Gem ændringer</button>
        </div>
    </form>

    <?php else: ?>
        <h3><?= htmlspecialchars($task['titel']) ?></h3>

        <div class="task-block">
            <div class="block-label">Kunde:</div>
            <div class="block-content"><?= htmlspecialchars($task['kunde_navn']) ?></div>
        </div>

        <div class="task-block">
            <div class="block-label">Status:</div>
            <div class="block-content">
                <?php
                    foreach ($statuses as $s) {
                        if ($s['id'] == $task['status_id']) {
                            echo htmlspecialchars($s['status_navn']);
                            break;
                        }
                    }
                ?>
            </div>
        </div>

        <div class="task-block">
            <div class="block-label">Prioritet:</div>
            <div class="block-content"><?= htmlspecialchars($task['prioritet']) ?></div>
        </div>

        <div class="task-block">
            <div class="block-label">Deadline:</div>
            <div class="block-content"><?= $deadline ? $deadline->format('Y-m-d H:i') : '-' ?></div>
        </div>

        <div class="task-block">
            <div class="block-label">Beskrivelse:</div>
            <div class="block-content"><?= nl2br(htmlspecialchars($task['beskrivelse'])) ?></div>
        </div>

        <div class="task-block">
            <div class="block-label">Oprettet:</div>
            <div class="block-content"><?= $created->format('Y-m-d') ?></div>
        </div>

        <?php if (!empty($task['filnavn'])): ?>
            <div class="task-block">
                <div class="block-label">Vedhæftet fil:</div>
                <div class="block-content">
                    <a href="../uploads/<?= htmlspecialchars($task['filnavn']) ?>" target="_blank">
                        <?= htmlspecialchars($task['filnavn']) ?>
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <div style="text-align: right; margin-top: 20px;">
            <a href="task.php?id=<?= $task['id'] ?>&edit=1" class="button">✏️ Rediger opgave</a>
        </div>
    <?php endif; ?>
</div>

<?php include_once '../includes/footer.php'; ?>
