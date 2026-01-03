<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Oy silme işlemi
🔗 İlişkili: admin/dashboard.php, oylar tablosu
⚙️ Özet: Belirtilen oy kaydını veritabanından siler
*/
require_once 'admin_guard.php';
require_once '../config.php';

if (!isset($_GET['id'], $_GET['tur'])) {
    header("Location: dashboard.php?page=oylar");
    exit;

}

$id = (int) $_GET['id'];
$tur = $_GET['tur']; // film | dizi

if ($tur === 'film') {
    $stmt = $pdo->prepare("DELETE FROM oylar WHERE id = ?");
} elseif ($tur === 'dizi') {
    $stmt = $pdo->prepare("DELETE FROM dizi_oylar WHERE id = ?");
} else {
    header("Location: dashboard.php?page=oylar");
    exit;
}

$stmt->execute([$id]);

header("Location: dashboard.php?page=oylar");
exit;

