<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Yakında içeriği düzenleme
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Mevcut 'yakında' içeriğini günceller
*/
require_once 'admin_guard.php';
require_once '../config.php';

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM yakinda WHERE id=?");
$stmt->execute([$id]);
$yakinda = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$yakinda) {
    die("Kayıt bulunamadı");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $baslik = $_POST['baslik'];
    $poster = $_POST['poster'];
    $sira = (int) $_POST['sira'];
    $aktif = isset($_POST['aktif']) ? 1 : 0;

    $stmt = $pdo->prepare("
        UPDATE yakinda 
        SET baslik=?, poster=?, sira=?, aktif=?
        WHERE id=?
    ");
    $stmt->execute([$baslik, $poster, $sira, $aktif, $id]);

    header("Location: dashboard.php?page=yakinda");
    exit;
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Yakında Düzenle • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>

    <div class="admin-main2">
        <form method="POST" class="admin-form">

            <h2>✏️ Yakında Düzenle</h2>

            <label>Başlık</label>
            <input type="text" name="baslik" value="<?= htmlspecialchars($yakinda['baslik']) ?>" required>

            <label>Poster URL</label>
            <input type="url" name="poster" value="<?= htmlspecialchars($yakinda['poster']) ?>" required>

            <label>Sıra</label>
            <input type="number" name="sira" value="<?= $yakinda['sira'] ?>">

            <label>
                <input type="checkbox" name="aktif" <?= $yakinda['aktif'] ? 'checked' : '' ?>>
                Aktif
            </label>

            <button class="btn-kaydet">Güncelle</button>
            <a href="dashboard.php?page=yakinda" class="btn-geri">Geri</a>

        </form>
    </div>

</body>

</html>