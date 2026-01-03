<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: İçerik silme işlemi
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Belirtilen içeriği veritabanından siler
*/
require_once 'admin_guard.php';
require_once '../config.php';

$id = (int) $_GET['id'];

$pdo->prepare("DELETE FROM icerikler WHERE id=?")->execute([$id]);

header("Location: dashboard.php?page=icerikler");
exit;
