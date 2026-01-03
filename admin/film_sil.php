<?php
require_once '../config.php';
require_once 'admin_guard.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM filmler WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php?page=filmler");
exit;

?>