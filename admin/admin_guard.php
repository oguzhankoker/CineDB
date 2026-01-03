<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Admin erişim koruması (guard)
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Oturum ve rol kontrolü yapar; admin erişimini sınırlar
*/
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../giris.php");
    exit;
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
