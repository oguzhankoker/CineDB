<?php
/*
📁 Bölüm: Kullanıcı (Profil & Kitaplık)
📄 Amaç: Kitaplığa film/dizi ekleme
🔗 İlişkili: profil.php, config.php
⚙️ Özet: Kullanıcının kitaplığına seçenek ekler (veritabanı işlemi)
*/
require_once 'config.php';
session_start();

// Giriş kontrolü
if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
}

// Sadece POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $user_id = $_SESSION['user_id'];
    $icerik_id = $_POST['icerik_id'] ?? null;
    $icerik_turu = $_POST['icerik_turu'] ?? null;

    // Güvenlik
    if (!$icerik_id || !in_array($icerik_turu, ['film', 'dizi'])) {
        header("Location: index.php");
        exit;
    }

    // Daha önce eklenmiş mi?
    $kontrol = $pdo->prepare("
        SELECT id 
        FROM kullanici_kitaplik 
        WHERE user_id = ? 
        AND icerik_id = ? 
        AND icerik_turu = ?
    ");
    $kontrol->execute([$user_id, $icerik_id, $icerik_turu]);

    if ($kontrol->rowCount() === 0) {
        // Ekle
        $ekle = $pdo->prepare("
            INSERT INTO kullanici_kitaplik (user_id, icerik_id, icerik_turu)
            VALUES (?, ?, ?)
        ");
        $ekle->execute([$user_id, $icerik_id, $icerik_turu]);
    }

    header("Location: profil.php#kitapligim");
    exit;
}
