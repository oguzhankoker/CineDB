<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Kullanıcı silme işlemi
🔗 İlişkili: admin/dashboard.php, users tablosu
⚙️ Özet: Belirtilen kullanıcıyı sistemden kaldırır
*/
require_once 'admin_guard.php';
require_once '../config.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // İlişkili verileri (kitaplık, yorum, oylar) temizle
    $pdo->prepare("DELETE FROM kullanici_kitaplik WHERE user_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM yorumlar WHERE user_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM oylar WHERE user_id = ?")->execute([$id]);

    // Kullanıcıyı sil
    $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$id]);
}

header("Location: dashboard.php?page=kullanicilar");
exit;
?>