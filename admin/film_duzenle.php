<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Film düzenleme formu ve güncelleme işlemi
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Mevcut film verisini getirir, form ile günceller
*/
require_once 'admin_guard.php';
require_once '../config.php';

if (!isset($_GET['id'])) {
    header("Location: filmler_yonet.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM filmler WHERE id = ?");
$stmt->execute([$id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
    die("Film bulunamadı!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $_POST['baslik'];
    $yil = $_POST['yil'];
    $resim_url = $_POST['resim_url'];
    $kategori = $_POST['kategori'];
    $sure = $_POST['sure'];
    $tur = $_POST['tur'];
    $imdb_puani = $_POST['imdb_puani'];
    $ozet = $_POST['ozet'];
    $yonetmen = $_POST['yonetmen'];
    $yazar = $_POST['yazar'];
    $basroller = $_POST['basroller'];
    $ulke = $_POST['ulke'];
    $fragman_url = $_POST['fragman_url'];
    $one_cikan = isset($_POST['one_cikan']) ? 1 : 0;

    $update = $pdo->prepare("UPDATE filmler SET 
    baslik=?, yil=?, resim_url=?, kategori=?, sure=?, tur=?, imdb_puani=?, 
    ozet=?, yonetmen=?, yazar=?, basroller=?, ulke=?, fragman_url=?, one_cikan=?
    WHERE id=?");

    $update->execute([
        $baslik,
        $yil,
        $resim_url,
        $kategori,
        $sure,
        $tur,
        $imdb_puani,
        $ozet,
        $yonetmen,
        $yazar,
        $basroller,
        $ulke,
        $fragman_url,
        $one_cikan,
        $id
    ]);

    header("Location: dashboard.php?page=filmler");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Film Düzenle • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>
    <main class="admin-main2">
        <form method="POST" class="admin-form">
            <label>Film Başlığı</label>
            <input type="text" name="baslik" value="<?= htmlspecialchars($film['baslik']) ?>" required>

            <label>Yıl</label>
            <input type="number" name="yil" value="<?= htmlspecialchars($film['yil']) ?>" required>

            <label>Poster URL</label>
            <input type="text" name="resim_url" value="<?= htmlspecialchars($film['resim_url']) ?>">

            <label>Kategori</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($film['kategori']) ?>">

            <label>Süre (dk)</label>
            <input type="number" name="sure" value="<?= htmlspecialchars($film['sure']) ?>">

            <label>Tür</label>
            <input type="text" name="tur" value="<?= htmlspecialchars($film['tur']) ?>">

            <label>IMDb Puanı</label>
            <input type="number" step="0.1" name="imdb_puani" value="<?= htmlspecialchars($film['imdb_puani']) ?>">

            <label>Özet</label>
            <textarea name="ozet" rows="4"><?= htmlspecialchars($film['ozet']) ?></textarea>

            <label>Yönetmen</label>
            <input type="text" name="yonetmen" value="<?= htmlspecialchars($film['yonetmen']) ?>">

            <label>Yazar</label>
            <input type="text" name="yazar" value="<?= htmlspecialchars($film['yazar']) ?>">

            <label>Başroller</label>
            <input type="text" name="basroller" value="<?= htmlspecialchars($film['basroller']) ?>">

            <label>Ülke</label>
            <input type="text" name="ulke" value="<?= htmlspecialchars($film['ulke']) ?>">

            <label>Fragman URL</label>
            <input type="text" name="fragman_url" value="<?= htmlspecialchars($film['fragman_url']) ?>">

            <label><input type="checkbox" name="one_cikan" <?= $film['one_cikan'] ? 'checked' : '' ?>> Öne Çıkan</label>

            <button type="submit" class="btn-kaydet">Güncelle</button>
            <a href="dashboard.php?page=filmler" class="btn-geri">Geri</a>
        </form>
    </main>
</body>

</html>