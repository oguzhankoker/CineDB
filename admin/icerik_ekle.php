<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: İçerik ekleme (haber/reklam vb.)
🔗 İlişkili: admin/dashboard.php, reklam_tikla.php, config.php
⚙️ Özet: İçerik formunu işler ve 'icerikler' tablosuna ekler
*/
require_once 'admin_guard.php';
require_once '../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
    INSERT INTO icerikler
    (baslik, ozet, icerik, gorsel, tur, hedef, link, konum, aktif, baslangic, bitis)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
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
        $_POST['bitis'] ?: null
    ]);

    header("Location: dashboard.php?page=icerikler");
    exit;
}
?>
<link rel="stylesheet" href="static/css/admin.css">
<div class="admin-main2">
    <form method="POST" class="admin-form">

        <h2>➕ Yeni İçerik Ekle</h2>

        <label>Başlık</label>
        <input type="text" name="baslik" required>

        <label>Kısa Özet</label>
        <textarea name="ozet" rows="3"></textarea>

        <label>İçerik (Haber metni)</label>
        <textarea name="icerik" rows="6"></textarea>

        <label>Görsel URL</label>
        <input type="url" name="gorsel">

        <label>Tür</label>
        <select name="tur">
            <option value="haber">Haber</option>
            <option value="reklam">Reklam</option>
        </select>

        <label>Hedef</label>
        <select name="hedef">
            <option value="film">Film</option>
            <option value="dizi">Dizi</option>
            <option value="genel">Genel</option>
        </select>

        <label>Sponsor / Yönlendirme Linki</label>
        <input type="url" name="link">

        <label>Konum</label>
        <select name="konum">
            <option value="ust">Üst Banner</option>
            <option value="yan">Yan Banner</option>
        </select>

        <label>
            <input type="checkbox" name="aktif" checked>
            Aktif
        </label>

        <label>Başlangıç Tarihi</label>
        <input type="datetime-local" name="baslangic" required>

        <label>Bitiş Tarihi</label>
        <input type="datetime-local" name="bitis">

        <button type="submit" class="btn-kaydet">Kaydet</button>
        <a href="dashboard.php?page=icerikler" class="btn-geri">Geri Dön</a>

    </form>
</div>