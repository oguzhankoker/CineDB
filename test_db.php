<?php
/*
📁 Bölüm: Helpers (Yardımcılar)
📄 Amaç: Veritabanı bağlantı testi
🔗 İlişkili: config.php
⚙️ Özet: DB bağlantısını test eden basit betik, geliştirme amacıyla kullanılır
*/
require_once 'config.php';

$stmt = $pdo->query("SELECT COUNT(*) FROM filmler");
$sayi = $stmt->fetchColumn();

echo "✅ Veritabanı bağlantısı başarılı! Filmler tablosunda {$sayi} kayıt var.";
?>