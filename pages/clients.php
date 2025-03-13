<?php
require_once '../config/db.php';
include_once '../includes/header.php';

$clients = $pdo->query("SELECT * FROM clients ORDER BY navn ASC")->fetchAll();
?>

<h2>Kundeliste</h2>

<a href="new-client.php" class="button">+ Tilføj ny kunde</a>

<table class="client-table">
    <thead>
        <tr>
            <th>Firmanavn</th>
            <th>Kontaktperson</th>
            <th>Email</th>
            <th>Telefon</th>
            <th>Handling</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
            <tr>
                <td><?= htmlspecialchars($client['navn']) ?></td>
                <td><?= htmlspecialchars($client['kontaktperson']) ?></td>
                <td><?= htmlspecialchars($client['email']) ?></td>
                <td><?= htmlspecialchars($client['telefon']) ?></td>
                <td><a href="client.php?id=<?= $client['id'] ?>">Rediger</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include_once '../includes/footer.php'; ?>
