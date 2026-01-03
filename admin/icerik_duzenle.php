<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: İçerik düzenleme formu ve güncelleme
🔗 İlişkili: admin/dashboard.php, config.php
⚙️ Özet: Mevcut içeriği getirir ve güncellemeye izin verir
*/
require_once 'admin_guard.php';
require_once '../config.php';

$id = (int) $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM icerikler WHERE id=?");
$stmt->execute([$id]);
$icerik = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$icerik) {
    die("İçerik bulunamadı");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
    UPDATE icerikler SET
      baslik=?, ozet=?, icerik=?, gorsel=?, tur=?, hedef=?, link=?, konum=?, aktif=?, baslangic=?, bitis=?
    WHERE id=?
  ");

    $stmt->execute([
        $_POST['baslik'],
        $_POST['ozet'],
        $_POST['icerik'],
        $_POST['gorsel'],
        $_POST['tur'],
        $_POST['hedef'],
        $_POST['link'] ?: null,
        $_POST['konum'],
        isset($_POST['aktif']) ? 1 : 0,
        $_POST['baslangic'],
        $_POST['bitis'] ?: null,
        $id
    ]);

    header("Location: dashboard.php?page=icerikler");
    exit;
}
?>
<link rel="stylesheet" href="static/css/admin.css">
<div class="admin-main2">
    <form method="POST" class="admin-form">

        <h2>✏️ İçerik Düzenle</h2>

        <label>Başlık</label>
        <input type="text" name="baslik" value="<?= htmlspecialchars($icerik['baslik']) ?>" required>

        <label>Kısa Özet</label>
        <textarea name="ozet" rows="3"><?= htmlspecialchars($icerik['ozet']) ?></textarea>

        <label>İçerik</label>
        <textarea name="icerik" rows="6"><?= htmlspecialchars($icerik['icerik']) ?></textarea>

        <label>Görsel URL</label>
        <input type="url" name="gorsel" value="<?= $icerik['gorsel'] ?>">

        <label>Tür</label>
        <select name="tur">
            <option value="haber" <?= $icerik['tur'] === 'haber' ? 'selected' : '' ?>>Haber</option>
            <option value="reklam" <?= $icerik['tur'] === 'reklam' ? 'selected' : '' ?>>Reklam</option>
        </select>

        <label>Hedef</label>
        <select name="hedef">
            <option value="film" <?= $icerik['hedef'] === 'film' ? 'selected' : '' ?>>Film</option>
            <option value="dizi" <?= $icerik['hedef'] === 'dizi' ? 'selected' : '' ?>>Dizi</option>
            <option value="genel" <?= $icerik['hedef'] === 'genel' ? 'selected' : '' ?>>Genel</option>
        </select>

        <label>Sponsor / Yönlendirme Linki</label>
        <input type="url" name="link" value="<?= $icerik['link'] ?>">

        <label>Konum</label>
        <select name="konum">
            <option value="ust" <?= $icerik['konum'] === 'ust' ? 'selected' : '' ?>>Üst</option>
            <option value="yan" <?= $icerik['konum'] === 'yan' ? 'selected' : '' ?>>Yan</option>
        </select>

        <label>
            <input type="checkbox" name="aktif" <?= $icerik['aktif'] ? 'checked' : '' ?>>
            Aktif
        </label>

        <label>Başlangıç Tarihi</label>
        <input type="datetime-local" name="baslangic"
            value="<?= date('Y-m-d\TH:i', strtotime($icerik['baslangic'])) ?>">

        <label>Bitiş Tarihi</label>
        <input type="datetime-local" name="bitis"
            value="<?= $icerik['bitis'] ? date('Y-m-d\TH:i', strtotime($icerik['bitis'])) : '' ?>">

        <button type="submit" class="btn-kaydet">Güncelle</button>
        <a href="dashboard.php?page=icerikler" class="btn-geri">Geri Dön</a>

    </form>
</div>