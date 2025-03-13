<?php
require_once '../config/db.php';
include_once '../includes/header.php';

if (!isset($_GET['id'])) {
    echo "<p>Kunde-ID mangler.</p>";
    include_once '../includes/footer.php';
    exit;
}

$client_id = intval($_GET['id']);
$stmt = $pdo->prepare("SELECT * FROM clients WHERE id = ?");
$stmt->execute([$client_id]);
$client = $stmt->fetch();

if (!$client) {
    echo "<p>Kunden blev ikke fundet.</p>";
    include_once '../includes/footer.php';
    exit;
}
?>

<h2>Rediger kunde: <?= htmlspecialchars($client['navn']) ?></h2>

<form action="../actions/update_client.php" method="post" class="form">
    <input type="hidden" name="client_id" value="<?= $client['id'] ?>">

    <label for="navn">Firmanavn:</label>
    <input type="text" name="navn" id="navn" value="<?= htmlspecialchars($client['navn']) ?>" required>

    <label for="kontaktperson">Kontaktperson:</label>
    <input type="text" name="kontaktperson" value="<?= htmlspecialchars($client['kontaktperson']) ?>">

    <label for="email">Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($client['email']) ?>">

    <label for="telefon">Telefon:</label>
    <input type="text" name="telefon" value="<?= htmlspecialchars($client['telefon']) ?>">

    <label for="adresse">Adresse:</label>
    <textarea name="adresse" rows="3"><?= htmlspecialchars($client['adresse']) ?></textarea>

    <button type="submit">Gem ændringer</button>
</form>

<?php include_once '../includes/footer.php'; ?>
