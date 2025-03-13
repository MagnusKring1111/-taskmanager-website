<?php
require_once '../config/db.php';
include_once '../includes/header.php';
?>

<h2>Opret ny kunde</h2>

<form action="../actions/add_client.php" method="post" class="form">
    <label for="navn">Firmanavn:</label>
    <input type="text" name="navn" id="navn" required>

    <label for="kontaktperson">Kontaktperson:</label>
    <input type="text" name="kontaktperson" id="kontaktperson">

    <label for="email">Email:</label>
    <input type="email" name="email" id="email">

    <label for="telefon">Telefon:</label>
    <input type="text" name="telefon" id="telefon">

    <label for="adresse">Adresse:</label>
    <textarea name="adresse" id="adresse" rows="3"></textarea>

    <button type="submit">Opret kunde</button>
</form>

<?php include_once '../includes/footer.php'; ?>
