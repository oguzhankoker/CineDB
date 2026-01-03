<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Yeni film ekleme formu ve işleme
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Form verisini alır, doğrular ve 'filmler' tablosuna ekler
*/
require_once 'admin_guard.php';
require_once '../config.php';

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

    $stmt = $pdo->prepare("INSERT INTO filmler 
    (baslik, yil, resim_url, kategori, sure, tur, imdb_puani, ozet, yonetmen, yazar, basroller, ulke, fragman_url, one_cikan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
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
        $basrollers,
        $ulke,
        $fragman_url,
        $one_cikan
    ]);

    header("Location: dashboard.php?page=filmler");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Yeni Film Ekle • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>
    <main class="admin-main2">
        <form method="POST" class="admin-form">
            <label>🎬 Film Başlığı</label>
            <input type="text" name="baslik" required>

            <label>📅 Yıl</label>
            <input type="number" name="yil" required>

            <label>🖼️ Poster URL</label>
            <input type="text" name="resim_url" required>

            <label>📂 Kategori</label>
            <input type="text" name="kategori" placeholder="örn: all veya featured">

            <label>⏱️ Süre (dakika)</label>
            <input type="number" name="sure" required>

            <label>🎭 Tür</label>
            <input type="text" name="tur" placeholder="örn: Suç • Dram">

            <label>⭐ IMDb Puanı</label>
            <input type="number" step="0.1" name="imdb_puani" min="0" max="10">

            <label>🧾 Özet</label>
            <textarea name="ozet" rows="4"></textarea>

            <label>🎬 Yönetmen</label>
            <input type="text" name="yonetmen">

            <label>✍️ Yazar</label>
            <input type="text" name="yazar">

            <label>🎭 Başroller</label>
            <input type="text" name="basrollers">

            <label>🌍 Ülke</label>
            <input type="text" name="ulke">

            <label>▶️ Fragman URL (YouTube embed link)</label>
            <input type="text" name="fragman_url">

            <label><input type="checkbox" name="one_cikan"> Öne Çıkan Film Olsun</label>

            <button type="submit" class="btn-kaydet">Kaydet</button>
            <a href="dashboard.php?page=filmler" class="btn-geri">Geri</a>
        </form>
    </main>
</body>

</html>