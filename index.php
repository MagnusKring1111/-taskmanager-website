<?php
require_once __DIR__ . '/includes/functions.php';
update_structure_file_if_changed();

header('Location: pages/dashboard.php');
exit;
?>
