<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Dizi düzenleme formu ve güncelleme
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Mevcut dizi verisini getirir ve güncelleyebilir
*/
require_once 'admin_guard.php';
require_once '../config.php';

if (!isset($_GET['id'])) {
    header("Location: diziler_yonet.php");
    exit;
}

$id = (int) $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM diziler WHERE id = ?");
$stmt->execute([$id]);
$dizi = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dizi) {
    die("Dizi bulunamadı!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $update = $pdo->prepare("UPDATE diziler SET 
    baslik=?, yil=?, poster=?, kategori=?, sezon_sayisi=?, bolum_sayisi=?, tur=?, imdb_puani=?, 
    ozet=?, yonetmen=?, yazar=?, basrollers=?, ulke=?, fragman_url=?, one_cikan=?
    WHERE id=?");

    $update->execute([
        $_POST['baslik'],
        $_POST['yil'],
        $_POST['poster'],
        $_POST['kategori'],
        $_POST['sezon_sayisi'],
        $_POST['bolum_sayisi'],
        $_POST['tur'],
        $_POST['imdb_puani'],
        $_POST['ozet'],
        $_POST['yonetmen'],
        $_POST['yazar'],
        $_POST['basrollers'],
        $_POST['ulke'],
        $_POST['fragman_url'],
        isset($_POST['one_cikan']) ? 1 : 0,
        $id
    ]);

    header("Location: dashboard.php?page=diziler");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Dizi Düzenle • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>

    <main class="admin-main2">

        <form method="POST" class="admin-form">

            <label>Dizi Başlığı</label>
            <input type="text" name="baslik" value="<?= htmlspecialchars($dizi['baslik']) ?>" required>

            <label>Yıl</label>
            <input type="number" name="yil" value="<?= htmlspecialchars($dizi['yil']) ?>" required>

            <label>Poster URL</label>
            <input type="text" name="poster" value="<?= htmlspecialchars($dizi['poster']) ?>">

            <label>Kategori</label>
            <input type="text" name="kategori" value="<?= htmlspecialchars($dizi['kategori']) ?>">

            <label>Sezon Sayısı</label>
            <input type="number" name="sezon_sayisi" value="<?= htmlspecialchars($dizi['sezon_sayisi']) ?>">

            <label>Bölüm Sayısı</label>
            <input type="number" name="bolum_sayisi" value="<?= htmlspecialchars($dizi['bolum_sayisi']) ?>">

            <label>Tür</label>
            <input type="text" name="tur" value="<?= htmlspecialchars($dizi['tur']) ?>">

            <label>IMDb Puanı</label>
            <input type="number" step="0.1" name="imdb_puani" value="<?= htmlspecialchars($dizi['imdb_puani']) ?>">

            <label>Özet</label>
            <textarea name="ozet" rows="4"><?= htmlspecialchars($dizi['ozet']) ?></textarea>

            <label>Yönetmen</label>
            <input type="text" name="yonetmen" value="<?= htmlspecialchars($dizi['yonetmen']) ?>">

            <label>Yazar</label>
            <input type="text" name="yazar" value="<?= htmlspecialchars($dizi['yazar']) ?>">

            <label>Başroller</label>
            <input type="text" name="basrollers" value="<?= htmlspecialchars($dizi['basrollers']) ?>">

            <label>Ülke</label>
            <input type="text" name="ulke" value="<?= htmlspecialchars($dizi['ulke']) ?>">

            <label>Fragman URL</label>
            <input type="text" name="fragman_url" value="<?= htmlspecialchars($dizi['fragman_url']) ?>">

            <label><input type="checkbox" name="one_cikan" <?= $dizi['one_cikan'] ? 'checked' : '' ?>> Öne Çıkan</label>

            <button type="submit" class="btn-kaydet">Güncelle</button>
            <a href="dashboard.php?page=diziler" class="btn-geri">Geri</a>
        </form>

    </main>

</body>

</html>