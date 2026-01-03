<?php
/*
📁 Bölüm: Frontend (Kullanıcı Tarafı)
📄 Amaç: İçerik detay sayfası (makale/reklam vb.)
🔗 İlişkili: reklam_tikla.php, config.php
⚙️ Özet: İçerik detayını gösterir, tıklama/istatistikleri yönetir
*/
require_once 'config.php';
session_start();

$id = (int) ($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
  SELECT * FROM icerikler
  WHERE id = ? AND aktif = 1
");
$stmt->execute([$id]);
$icerik = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$icerik) {
    die("İçerik bulunamadı.");
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($icerik['baslik']) ?> | Cine.DB</title>

    <!-- ANA TEMA CSS -->
    <link rel="stylesheet" href="static/css/filmler.css">

    <!-- FONT AWESOME (etiket vs için gerekirse) -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <div class="haber-detay-wrapper">

        <article class="haber-detay">

            <a href="javascript:history.back()" class="haber-geri-btn">
                ← Geri
            </a>


            <div class="haber-detay-etiketler">
                <span><?= strtoupper($icerik['hedef']) ?></span>

                <?php if (!empty($icerik['link'])): ?>
                    <span class="sponsor">Sponsorlu</span>
                <?php endif; ?>
            </div>

            <h1><?= htmlspecialchars($icerik['baslik']) ?></h1>

            <?php if (!empty($icerik['gorsel'])): ?>
                <img src="<?= htmlspecialchars($icerik['gorsel']) ?>" alt="">
            <?php endif; ?>

            <div class="haber-detay-icerik">
                <?= nl2br(htmlspecialchars($icerik['icerik'])) ?>
            </div>

            <?php if (!empty($icerik['link'])): ?>
                <a href="<?= htmlspecialchars($icerik['link']) ?>" target="_blank" class="haber-sponsor-btn">
                    Sponsor Bağlantısı →
                </a>
            <?php endif; ?>

        </article>

    </div>

</body>

</html>