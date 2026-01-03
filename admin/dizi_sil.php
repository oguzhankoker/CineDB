<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Dizi silme işlemi
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Belirtilen diziyi veritabanından kaldırır
*/
require_once 'admin_guard.php';
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM diziler WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: dashboard.php?page=diziler");
exit;

?>