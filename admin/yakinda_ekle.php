<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Yakında gelecek içerik ekleme
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: 'yakinda' içerikleri ekleyip yönetmeyi sağlar
*/
require_once 'admin_guard.php';
require_once '../config.php';

$tur = $_GET['tur'] ?? 'film';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $_POST['baslik'];
    $poster = $_POST['poster'];
    $sira = (int) $_POST['sira'];
    $aktif = isset($_POST['aktif']) ? 1 : 0;

    $stmt = $pdo->prepare("
        INSERT INTO yakinda (baslik, poster, tur, sira, aktif)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->execute([$baslik, $poster, $tur, $sira, $aktif]);

    header("Location: dashboard.php?page=yakinda");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Yakında Ekle • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>

    <div class="admin-main2">
        <form method="POST" class="admin-form">

            <h2>⏳ Yakında Gelecek <?= $tur === 'film' ? 'Film' : 'Dizi' ?> Ekle</h2>

            <label>Başlık</label>
            <input type="text" name="baslik" required>

            <label>Poster URL</label>
            <input type="url" name="poster" required>

            <label>Sıra</label>
            <input type="number" name="sira" value="0">

            <label>
                <input type="checkbox" name="aktif" checked>
                Aktif
            </label>

            <button class="btn-kaydet">Kaydet</button>
            <a href="dashboard.php?page=yakinda" class="btn-geri">Geri</a>

        </form>
    </div>

</body>

</html>