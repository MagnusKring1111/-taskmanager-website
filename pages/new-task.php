<?php
require_once '../config/db.php';
include_once '../includes/header.php';

$clients = $pdo->query("SELECT * FROM clients ORDER BY navn ASC")->fetchAll();
$statuses = $pdo->query("SELECT * FROM task_statuses")->fetchAll();
?>

<h2>Opret ny opgave</h2>

<form action="../actions/add_task.php" method="post" class="form" enctype="multipart/form-data">
    <label for="titel">Titel på opgave:</label>
    <input type="text" name="titel" id="titel" required>

    <label for="beskrivelse">Beskrivelse:</label>
    <textarea name="beskrivelse" id="beskrivelse" rows="4"></textarea>

    <label for="kunde_id">Vælg kunde:</label>
    <select name="kunde_id" required>
        <option value="">-- Vælg kunde --</option>
        <?php foreach ($clients as $client): ?>
            <option value="<?= $client['id'] ?>"><?= htmlspecialchars($client['navn']) ?></option>
        <?php endforeach; ?>
    </select>

    <p><a href="new-client.php">+ Opret ny kunde</a></p>

    <label for="status_id">Status:</label>
    <select name="status_id" required>
        <?php foreach ($statuses as $status): ?>
            <option value="<?= $status['id'] ?>"><?= htmlspecialchars($status['status_navn']) ?></option>
        <?php endforeach; ?>
    </select>

    <label for="prioritet">Prioritet:</label>
    <select name="prioritet">
        <option value="Normal" selected>Normal</option>
        <option value="Høj">Høj</option>
    </select>

    <label for="kategori">Kategori:</label>
    <input type="text" name="kategori" placeholder="F.eks. Print, Design, Web, osv.">

    <label for="deadline_date">Deadline dato:</label>
    <input type="date" name="deadline_date">

    <label for="deadline_time">Deadline tid:</label>
    <input type="time" name="deadline_time" value="16:00">

    <label for="fil">Vedhæft fil:</label>
    <input type="file" name="fil">

    <button type="submit">Opret opgave</button>
</form>

<?php include_once '../includes/footer.php'; ?>
