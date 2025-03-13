<?php
require_once '../config/db.php';
include_once '../includes/header.php';

$search = trim($_GET['q'] ?? '');

if (!$search) {
    echo "<p>Ingen søgeterm angivet.</p>";
    include_once '../includes/footer.php';
    exit;
}

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
");
$stmt->execute(['q' => "%$search%"]);
$results = $stmt->fetchAll();

include_once '../includes/components/deadline-badge.php';
?>

<h2>Søgeresultater for: <em><?= htmlspecialchars($search) ?></em></h2>

<?php if (count($results)): ?>
    <div class="search-results">
        <?php foreach ($results as $task): ?>
            <?php
            ob_start();
            renderDeadlineBadge($task['deadline']);
            $task['deadline_badge'] = ob_get_clean();
            include '../includes/components/mini-task-card.php';
            ?>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Ingen opgaver matchede søgningen.</p>
<?php endif; ?>

<?php include_once '../includes/footer.php'; ?>
