<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Yorum silme işlemi
🔗 İlişkili: admin/dashboard.php, film-detay.php, dizi-detay.php
⚙️ Özet: Belirtilen yorumu veritabanından siler
*/
require_once 'admin_guard.php';
require_once '../config.php';

if (!isset($_GET['id'], $_GET['tur'])) {
    header("Location: dashboard.php?page=yorumlar");
    exit;

}

$id = (int) $_GET['id'];
$tur = $_GET['tur']; // film | dizi

if ($tur === 'film') {
    $stmt = $pdo->prepare("DELETE FROM yorumlar WHERE id = ?");
} elseif ($tur === 'dizi') {
    $stmt = $pdo->prepare("DELETE FROM dizi_yorumlar WHERE id = ?");
} else {
    header("Location: yorumlar.php");
    exit;
}

$stmt->execute([$id]);

header("Location: dashboard.php?page=yorumlar");
exit;
