<?php
/*
📁 Bölüm: Kullanıcı (Profil & Kitaplık)
📄 Amaç: Kitaplıktan film/dizi silme
🔗 İlişkili: profil.php, config.php
⚙️ Özet: Kullanıcının kitaplığından seçilen içeriği kaldırır
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

    if (!$icerik_id || !in_array($icerik_turu, ['film', 'dizi'])) {
        header("Location: profil.php");
        exit;
    }

    // Sadece bu kullanıcıya ait olanı sil
    $sil = $pdo->prepare("
        DELETE FROM kullanici_kitaplik
        WHERE user_id = ?
        AND icerik_id = ?
        AND icerik_turu = ?
    ");
    $sil->execute([$user_id, $icerik_id, $icerik_turu]);

    header("Location: profil.php#kitapligim");
    exit;
}
