<?php
/*
📁 Bölüm: Helpers (Yardımcılar / Konfigürasyon)
📄 Amaç: Veritabanı bağlantı ayarları
🔗 İlişkili: Tüm PHP sayfaları (index, admin/* vb.)
⚙️ Özet: PDO ile veritabanı bağlantısını kurar ve hata yönetimi yapar
*/
$host = 'localhost';
$dbname = 'cinedb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>