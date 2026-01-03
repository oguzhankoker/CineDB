<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Yeni dizi ekleme formu ve ekleme işlemi
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Form verisini işleyip 'diziler' tablosuna kayıt yapar
*/
require_once 'admin_guard.php';
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $baslik = $_POST['baslik'];
    $yil = $_POST['yil'];
    $poster = $_POST['poster'];
    $kategori = $_POST['kategori'];
    $sezon_sayisi = $_POST['sezon_sayisi'];
    $bolum_sayisi = $_POST['bolum_sayisi'];
    $tur = $_POST['tur'];
    $imdb_puani = $_POST['imdb_puani'];
    $ozet = $_POST['ozet'];
    $yonetmen = $_POST['yonetmen'];
    $yazar = $_POST['yazar'];
    $basrollers = $_POST['basrollers'];
    $ulke = $_POST['ulke'];
    $fragman_url = $_POST['fragman_url'];
    $one_cikan = isset($_POST['one_cikan']) ? 1 : 0;

    $stmt = $pdo->prepare("INSERT INTO diziler 
    (baslik, yil, poster, kategori, sezon_sayisi, bolum_sayisi, tur, imdb_puani, ozet, yonetmen, yazar, basrollers, ulke, fragman_url, one_cikan)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->execute([
        $baslik,
        $yil,
        $poster,
        $kategori,
        $sezon_sayisi,
        $bolum_sayisi,
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

    header("Location: dashboard.php?page=diziler");
    exit;
}
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Yeni Dizi Ekle • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>

    <main class="admin-main2">
        <form method="POST" class="admin-form">

            <label>📺 Dizi Başlığı</label>
            <input type="text" name="baslik" required>

            <label>📅 Yayın Yılı</label>
            <input type="number" name="yil" required>

            <label>🖼️ Poster URL</label>
            <input type="text" name="poster" required>

            <label>📂 Kategori</label>
            <input type="text" name="kategori">

            <label>📀 Sezon Sayısı</label>
            <input type="number" name="sezon_sayisi" required>

            <label>🎞️ Bölüm Sayısı</label>
            <input type="number" name="bolum_sayisi" required>

            <label>🎭 Tür</label>
            <input type="text" name="tur">

            <label>⭐ IMDb Puanı</label>
            <input type="number" step="0.1" name="imdb_puani">

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

            <label>▶️ Fragman URL</label>
            <input type="text" name="fragman_url">

            <label><input type="checkbox" name="one_cikan"> Öne Çıkan Dizi Olsun</label>

            <button class="btn-kaydet" type="submit">Kaydet</button>
            <a href="dashboard.php?page=diziler" class="btn-geri">Geri</a>

        </form>
    </main>

</body>

</html>