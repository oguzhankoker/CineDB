<?php
/*
📁 Bölüm: Helpers (Yardımcılar)
📄 Amaç: Reklam veya içerik tıklama sayısını arttırma
🔗 İlişkili: icerik-detay.php, config.php
⚙️ Özet: İçerik tıklama sayısını veritabanında günceller ve yönlendirir
*/
require_once 'config.php';
session_start();

$id = (int) ($_GET['id'] ?? 0);

if ($id <= 0) {
    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| Reklamı kontrol et
|--------------------------------------------------------------------------
*/
$stmt = $pdo->prepare("
    SELECT id, link 
    FROM icerikler 
    WHERE id = ? 
      AND aktif = 1 
      AND tur = 'reklam'
");
$stmt->execute([$id]);
$icerik = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$icerik) {
    header("Location: index.php");
    exit;
}

/*
|--------------------------------------------------------------------------
| ÇİFT TIKLAMA ENGELİ (SESSION)
|--------------------------------------------------------------------------
*/
if (!isset($_SESSION['tiklanan_reklamlar'])) {
    $_SESSION['tiklanan_reklamlar'] = [];
}

if (!in_array($id, $_SESSION['tiklanan_reklamlar'])) {
    $pdo->prepare("
        UPDATE icerikler 
        SET tiklanma = tiklanma + 1 
        WHERE id = ?
    ")->execute([$id]);

    $_SESSION['tiklanan_reklamlar'][] = $id;
}

/*
|--------------------------------------------------------------------------
| GERÇEK LİNKE YÖNLENDİR
|--------------------------------------------------------------------------
*/
header("Location: " . $icerik['link']);
exit;
