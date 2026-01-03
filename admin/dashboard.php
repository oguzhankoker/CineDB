<?php
/*
📁 Bölüm: Admin (Yönetim Paneli)
📄 Amaç: Admin ana paneli ve sayfa yönlendirmeleri
🔗 İlişkili: admin_guard.php, admin/*_ekle.php, admin/*_duzenle.php
⚙️ Özet: Admin istatistikleri gösterir ve CRUD alt sayfalarına yönlendirir
*/
require_once 'admin_guard.php';
require_once '../config.php';

// URL parametresinden sayfa adı al, yoksa 'panel' varsayılan
$page = isset($_GET['page']) ? $_GET['page'] : 'panel';
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Admin Paneli • Cine.DB</title>
    <link rel="stylesheet" href="static/css/admin.css">
</head>

<body>
    <section class="admin-main">
        <div class="admin-main__sidebar">
            <h1><span>Cine.DB •</span> Admin</h1>

            <a href="dashboard.php?page=panel">📊 Panel</a>
            <a href="dashboard.php?page=filmler">🎬 Filmler</a>
            <a href="dashboard.php?page=diziler">📺 Diziler</a>
            <a href="dashboard.php?page=yakinda">⏳ Yakında Gelecekler</a>
            <a href="dashboard.php?page=yorumlar">💬 Yorumlar</a>
            <a href="dashboard.php?page=oylar">⭐ Oylar</a>
            <a href="dashboard.php?page=icerikler">📰 İçerikler</a>
            <a href="dashboard.php?page=kullanicilar">🧑‍💻 Kullanıcılar</a>
            <a href="dashboard.php?page=mesajlar">✉️ Mesajlar</a>

            <a href="../index.php" class="geri-don">🔙 Siteye Geri Dön</a>
            <a href="../cikis.php" class="logout">Çıkış</a>
        </div>

        <div class="admin-main__icerik">
            <?php
            switch ($page) {

                case 'panel':
                    // Film + Dizi Yorum Sayısı
                    $filmYorum = $pdo->query("SELECT COUNT(*) FROM yorumlar")->fetchColumn();
                    $diziYorum = $pdo->query("SELECT COUNT(*) FROM dizi_yorumlar")->fetchColumn();
                    $toplamYorum = $filmYorum + $diziYorum;

                    // Film + Dizi Oy Sayısı
                    $filmOy = $pdo->query("SELECT COUNT(*) FROM oylar")->fetchColumn();
                    $diziOy = $pdo->query("SELECT COUNT(*) FROM dizi_oylar")->fetchColumn();
                    $toplamOy = $filmOy + $diziOy;

                    $toplamTiklanma = $pdo->query("
                    SELECT SUM(tiklanma) FROM icerikler WHERE tur='reklam'
                    ")->fetchColumn();

                    $enCokTiklanan = $pdo->query("
                    SELECT baslik, tiklanma
                    FROM icerikler
                    WHERE tur='reklam'
                    ORDER BY tiklanma DESC
                    LIMIT 1
                    ")->fetch(PDO::FETCH_ASSOC);

                    ?>
                    <div class="istatistik-grid">

                        <div class="istatistik-kart">
                            <span class="ikon">🎬</span>
                            <div class="bilgi">
                                <strong><?= $pdo->query("SELECT COUNT(*) FROM filmler")->fetchColumn(); ?></strong>
                                <span>Toplam Film</span>
                            </div>
                        </div>

                        <div class="istatistik-kart">
                            <span class="ikon">📺</span>
                            <div class="bilgi">
                                <strong><?= $pdo->query("SELECT COUNT(*) FROM diziler")->fetchColumn(); ?></strong>
                                <span>Toplam Dizi</span>
                            </div>
                        </div>

                        <div class="istatistik-kart">
                            <span class="ikon">💬</span>
                            <div class="bilgi">
                                <strong><?= $toplamYorum ?></strong>
                                <span>Toplam Yorum</span>
                            </div>
                        </div>

                        <div class="istatistik-kart">
                            <span class="ikon">⭐</span>
                            <div class="bilgi">
                                <strong><?= $toplamOy ?></strong>
                                <span>Toplam Oy</span>
                            </div>
                        </div>

                        <div class="istatistik-kart">
                            <span class="ikon">🧑‍💻</span>
                            <div class="bilgi">
                                <strong><?= $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn(); ?></strong>
                                <span>Kullanıcı</span>
                            </div>
                        </div>

                        <div class="istatistik-kart">
                            <span class="ikon">✉️</span>
                            <div class="bilgi">
                                <strong><?= $pdo->query("SELECT COUNT(*) FROM iletisim_mesajlari")->fetchColumn(); ?></strong>
                                <span>Mesaj</span>
                            </div>
                        </div>

                        <div class="istatistik-kart">
                            <span class="ikon">📢</span>
                            <div class="bilgi">
                                <strong><?= $toplamTiklanma ?: 0 ?></strong>
                                <span>Reklam Tıklanma</span>
                            </div>
                        </div>

                        <?php if ($enCokTiklanan): ?>
                            <div class="istatistik-kart">
                                <span class="ikon">🔥</span>
                                <div class="bilgi">
                                    <strong><?= $enCokTiklanan['tiklanma'] ?></strong>
                                    <span><?= htmlspecialchars($enCokTiklanan['baslik']) ?></span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    break;

                case 'filmler':
                    $stmt = $pdo->query("SELECT id, resim_url, baslik, yil, tur, imdb_puani FROM filmler ORDER BY id DESC");
                    ?>
                    <div class="film-liste2">
                        <div class="icerik-baslik">
                            <h2>🎬 Filmler</h2>
                            <a href="film_ekle.php" class="btn-ekle">+ Yeni Film Ekle</a>
                        </div>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Poster</th>
                                    <th>Başlık</th>
                                    <th>Yıl</th>
                                    <th>Tür</th>
                                    <th>IMDb</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stmt as $film): ?>
                                    <tr>
                                        <td><img src="<?= htmlspecialchars($film['resim_url']) ?>" width="45"></td>
                                        <td><?= htmlspecialchars($film['baslik']) ?></td>
                                        <td><?= htmlspecialchars($film['yil']) ?></td>
                                        <td><?= htmlspecialchars($film['tur']) ?></td>
                                        <td><?= htmlspecialchars($film['imdb_puani']) ?></td>
                                        <td>
                                            <a href="film_duzenle.php?id=<?= $film['id'] ?>" class="btn-duzenle">Düzenle</a>
                                            <a href="film_sil.php?id=<?= $film['id'] ?>" class="btn-sil"
                                                onclick="return confirm('Bu filmi silmek istediğine emin misin?')">Sil</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    break;

                case 'diziler':
                    $stmt = $pdo->query("SELECT id, poster, baslik, yil, sezon_sayisi, bolum_sayisi, tur, imdb_puani FROM diziler ORDER BY id DESC");
                    ?>
                    <div class="film-liste2">
                        <div class="icerik-baslik">
                            <h2>📺 Diziler</h2>
                            <a href="dizi_ekle.php" class="btn-ekle">+ Yeni Dizi Ekle</a>
                        </div>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Poster</th>
                                    <th>Başlık</th>
                                    <th>Yıl</th>
                                    <th>Sezon</th>
                                    <th>Bölüm</th>
                                    <th>Tür</th>
                                    <th>IMDb</th>
                                    <th>İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($stmt as $dizi): ?>
                                    <tr>
                                        <td><img src="<?= htmlspecialchars($dizi['poster']) ?>" width="45"></td>
                                        <td><?= htmlspecialchars($dizi['baslik']) ?></td>
                                        <td><?= htmlspecialchars($dizi['yil']) ?></td>
                                        <td><?= htmlspecialchars($dizi['sezon_sayisi']) ?></td>
                                        <td><?= htmlspecialchars($dizi['bolum_sayisi']) ?></td>
                                        <td><?= htmlspecialchars($dizi['tur']) ?></td>
                                        <td><?= htmlspecialchars($dizi['imdb_puani']) ?></td>
                                        <td>
                                            <a href="dizi_duzenle.php?id=<?= $dizi['id'] ?>" class="btn-duzenle">Düzenle</a>
                                            <a href="dizi_sil.php?id=<?= $dizi['id'] ?>" class="btn-sil"
                                                onclick="return confirm('Bu diziyi silmek istiyor musun?')">Sil</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                    break;

                case 'yorumlar':
                    $yorumlar = $pdo->query("
                        SELECT 
                            y.id,
                            u.kullanici_adi,
                            y.yorum,
                            y.tarih,
                            f.baslik AS film_baslik
                        FROM yorumlar y
                        JOIN users u ON u.id = y.user_id
                        JOIN filmler f ON f.id = y.film_id
                        ORDER BY y.tarih DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);


                    $dizi_yorumlar = $pdo->query("
                        SELECT y.id, u.kullanici_adi, y.yorum, y.tarih, d.baslik AS dizi_baslik
                        FROM dizi_yorumlar y
                        JOIN users u ON u.id = y.user_id
                        JOIN diziler d ON d.id = y.dizi_id
                        ORDER BY y.tarih DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="yorum-container">
                        <h2>💬 Film Yorumları</h2>
                        <div class="yorum-listesi">
                            <?php foreach ($yorumlar as $y): ?>
                                <div class="yorum-card">
                                    <div class="yorum-ust">
                                        <div class="yorum-isim"><?= $y['kullanici_adi'] ?></div>
                                        <div class="yorum-film">🎬 <?= $y['film_baslik'] ?></div>
                                    </div>
                                    <div class="yorum-metin"><?= nl2br(htmlspecialchars($y['yorum'])) ?></div>
                                    <div class="yorum-alt">
                                        <div class="yorum-tarih"><?= $y['tarih'] ?></div>
                                        <a href="yorum_sil.php?id=<?= $y['id'] ?>&tur=film"
                                            onclick="return confirm('Bu yorumu silmek istiyor musun?')">Sil</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <hr style="margin:50px 0">

                        <h2>📺 Dizi Yorumları</h2>
                        <div class="yorum-listesi">
                            <?php foreach ($dizi_yorumlar as $y): ?>
                                <div class="yorum-card">
                                    <div class="yorum-ust">
                                        <div class="yorum-isim"><?= $y['kullanici_adi'] ?></div>
                                        <div class="yorum-film">📺 <?= $y['dizi_baslik'] ?></div>
                                    </div>
                                    <div class="yorum-metin"><?= nl2br(htmlspecialchars($y['yorum'])) ?></div>
                                    <div class="yorum-alt">
                                        <div class="yorum-tarih"><?= $y['tarih'] ?></div>
                                        <a href="yorum_sil.php?id=<?= $y['id'] ?>&tur=dizi"
                                            onclick="return confirm('Bu yorumu silmek istiyor musun?')">Sil</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    break;

                case 'oylar':
                    $oylar = $pdo->query("
                        SELECT 
                            o.id,
                            u.kullanici_adi,
                            o.puan,
                            o.tarih,
                            f.baslik AS film_baslik
                        FROM oylar o
                        JOIN users u ON u.id = o.user_id
                        JOIN filmler f ON f.id = o.film_id
                        ORDER BY o.tarih DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);

                    $ortalama_list = $pdo->query("
                        SELECT f.baslik, ROUND(AVG(o.puan),1) AS ortalama
                        FROM oylar o
                        JOIN filmler f ON o.film_id = f.id
                        GROUP BY f.id
                        ORDER BY ortalama DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);

                    $dizi_oylar = $pdo->query("
                        SELECT o.id, u.kullanici_adi, o.puan, o.tarih, d.baslik AS dizi_baslik
                        FROM dizi_oylar o
                        JOIN users u ON u.id = o.user_id
                        JOIN diziler d ON d.id = o.dizi_id
                        ORDER BY o.tarih DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);

                    $dizi_ortalama_list = $pdo->query("
                        SELECT d.baslik, ROUND(AVG(o.puan),1) AS ortalama
                        FROM dizi_oylar o
                        JOIN diziler d ON d.id = o.dizi_id
                        GROUP BY d.id
                        ORDER BY ortalama DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="oylar-container">
                        <div class="istatistik-panel">
                            <h2>📊 Film Ortalama Puanları</h2>
                            <div class="ortalama-listesi">
                                <?php foreach ($ortalama_list as $a): ?>
                                    <div class="ortalama-item">
                                        <div><?= htmlspecialchars($a['baslik']) ?></div>
                                        <div class="ortalama-puan">⭐ <?= $a['ortalama'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <div class="istatistik-panel">
                            <h2>📊 Dizi Ortalama Puanları</h2>
                            <div class="ortalama-listesi">
                                <?php foreach ($dizi_ortalama_list as $a): ?>
                                    <div class="ortalama-item">
                                        <div><?= htmlspecialchars($a['baslik']) ?></div>
                                        <div class="ortalama-puan">⭐ <?= $a['ortalama'] ?></div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <h2 class="oylar-baslik">⭐ Film Oyları</h2>
                        <div class="oy-listesi">
                            <?php foreach ($oylar as $o): ?>
                                <div class="oy-kart">
                                    <div class="oy-ust">
                                        <div class="oy-kullanici"><?= $o['kullanici_adi'] ?></div>
                                        <div class="oy-film">🎬 <?= $o['film_baslik'] ?></div>
                                    </div>
                                    <div class="oy-puan">⭐ <?= $o['puan'] ?></div>
                                    <div class="oy-alt">
                                        <div class="oy-tarih"><?= $o['tarih'] ?></div>
                                        <a href="oy_sil.php?id=<?= $o['id'] ?>&tur=film"
                                            onclick="return confirm('Bu oyu silmek istiyor musun?')">Sil</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <h2 class="oylar-baslik">📺 Dizi Oyları</h2>
                        <div class="oy-listesi">
                            <?php foreach ($dizi_oylar as $o): ?>
                                <div class="oy-kart">
                                    <div class="oy-ust">
                                        <div class="oy-kullanici"><?= $o['kullanici_adi'] ?></div>
                                        <div class="oy-film">📺 <?= $o['dizi_baslik'] ?></div>
                                    </div>
                                    <div class="oy-puan">⭐ <?= $o['puan'] ?></div>
                                    <div class="oy-alt">
                                        <div class="oy-tarih"><?= $o['tarih'] ?></div>
                                        <a href="oy_sil.php?id=<?= $o['id'] ?>&tur=dizi"
                                            onclick="return confirm('Bu oyu silmek istiyor musun?')">Sil</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    break;

                case 'kullanicilar':
                    $kullanicilar = $pdo->query("SELECT id, kullanici_adi, email, kayit_tarihi FROM users ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="kullanici-container">
                        <h2>🧑‍💻 Kayıtlı Kullanıcılar</h2>
                        <div class="kullanici-grid">
                            <?php foreach ($kullanicilar as $k): ?>
                                <div class="kullanici-card">
                                    <div class="kullanici-ad"><?= htmlspecialchars($k['kullanici_adi']) ?></div>
                                    <div class="kullanici-email"><?= htmlspecialchars($k['email']) ?></div>
                                    <div class="kullanici-tarih">📅 <?= htmlspecialchars($k['kayit_tarihi']) ?></div>
                                    <a href="kullanici_sil.php?id=<?= $k['id'] ?>" class="kullanici-sil-btn"
                                        onclick="return confirm('Bu kullanıcıyı silmek istediğine emin misin?')">Sil</a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    break;


                case 'mesajlar':
                    $mesajlar = $pdo->query("SELECT * FROM iletisim_mesajlari ORDER BY tarih DESC")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="mesaj-container">
                        <h2>📩 Gelen Mesajlar</h2>
                        <div class="mesaj-grid">
                            <?php foreach ($mesajlar as $m): ?>
                                <div class="mesaj-card">
                                    <div class="mesaj-baslik"><?= htmlspecialchars($m['isim']) ?></div>
                                    <div class="mesaj-email">📧 <?= htmlspecialchars($m['email']) ?></div>
                                    <div class="mesaj-icerik"><?= nl2br(htmlspecialchars($m['mesaj'])) ?></div>
                                    <div class="mesaj-tarih">📅 <?= $m['tarih'] ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php
                    break;

                case 'yakinda':

                    // SİLME İŞLEMİ
                    if (isset($_GET['sil'])) {
                        $id = (int) $_GET['sil'];
                        $pdo->prepare("DELETE FROM yakinda WHERE id=?")->execute([$id]);
                        header("Location: dashboard.php?page=yakinda");
                        exit;
                    }

                    // AKTİF / PASİF
                    if (isset($_GET['toggle'])) {
                        $id = (int) $_GET['toggle'];
                        $pdo->query("UPDATE yakinda SET aktif = IF(aktif=1,0,1) WHERE id=$id");
                        header("Location: dashboard.php?page=yakinda");
                        exit;
                    }

                    // LİSTELER
                    $yakinda_filmler = $pdo->query("
                        SELECT * FROM yakinda 
                        WHERE tur='film' 
                        ORDER BY sira ASC
                    ")->fetchAll(PDO::FETCH_ASSOC);

                    $yakinda_diziler = $pdo->query("
                        SELECT * FROM yakinda 
                        WHERE tur='dizi' 
                        ORDER BY sira ASC
                    ")->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <div class="film-liste2">

                        <!-- ================= FILMLER ================= -->
                        <div class="icerik-baslik">
                            <h2>⏳ Yakında Gelecek Filmler</h2>
                            <a href="yakinda_ekle.php?tur=film" class="btn-ekle">+ Film Ekle</a>
                        </div>

                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Poster</th>
                                    <th>Başlık</th>
                                    <th>Sıra</th>
                                    <th>Aktif</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($yakinda_filmler as $y): ?>
                                    <tr>
                                        <td><img src="<?= $y['poster'] ?>" width="45"></td>
                                        <td><?= htmlspecialchars($y['baslik']) ?></td>
                                        <td><?= $y['sira'] ?></td>
                                        <td>
                                            <a href="dashboard.php?page=yakinda&toggle=<?= $y['id'] ?>">
                                                <?= $y['aktif'] ? '✅' : '❌' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="yakinda_duzenle.php?id=<?= $y['id'] ?>" class="btn-duzenle">Düzenle</a>
                                            <a href="dashboard.php?page=yakinda&sil=<?= $y['id'] ?>" class="btn-sil"
                                                onclick="return confirm('Silmek istiyor musun?')">Sil</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <hr style="margin:40px 0">

                        <!-- ================= DIZILER ================= -->
                        <div class="icerik-baslik">
                            <h2>⏳ Yakında Gelecek Diziler</h2>
                            <a href="yakinda_ekle.php?tur=dizi" class="btn-ekle">+ Dizi Ekle</a>
                        </div>

                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Poster</th>
                                    <th>Başlık</th>
                                    <th>Sıra</th>
                                    <th>Aktif</th>
                                    <th>İşlem</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($yakinda_diziler as $y): ?>
                                    <tr>
                                        <td><img src="<?= $y['poster'] ?>" width="45"></td>
                                        <td><?= htmlspecialchars($y['baslik']) ?></td>
                                        <td><?= $y['sira'] ?></td>
                                        <td>
                                            <a href="dashboard.php?page=yakinda&toggle=<?= $y['id'] ?>">
                                                <?= $y['aktif'] ? '✅' : '❌' ?>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="yakinda_duzenle.php?id=<?= $y['id'] ?>" class="btn-duzenle">Düzenle</a>
                                            <a href="dashboard.php?page=yakinda&sil=<?= $y['id'] ?>" class="btn-sil"
                                                onclick="return confirm('Silmek istiyor musun?')">Sil</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </div>
                    <?php
                    break;

                case 'icerikler':

                    require_once '../config.php';

                    $icerikler = $pdo->query("
                        SELECT *
                        FROM icerikler
                        ORDER BY olusturma_tarihi DESC
                    ")->fetchAll(PDO::FETCH_ASSOC);
                    ?>

                    <h2>📰 İçerikler (Haber & Reklam)</h2>

                    <a href="icerik_ekle.php" class="btn-ekle">+ Yeni İçerik</a>

                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Başlık</th>
                                <th>Tür</th>
                                <th>Hedef</th>
                                <th>Aktif</th>
                                <th>İşlemler</th>
                                <th>Tıklanma</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($icerikler as $i): ?>
                                <tr>
                                    <td><?= $i['id'] ?></td>
                                    <td><?= htmlspecialchars($i['baslik']) ?></td>
                                    <td><?= strtoupper($i['tur']) ?></td>
                                    <td><?= strtoupper($i['hedef']) ?></td>
                                    <td><?= $i['aktif'] ? '✅' : '❌' ?></td>
                                    <td>
                                        <a href="icerik_duzenle.php?id=<?= $i['id'] ?>">✏️ Düzenle</a> |
                                        <a href="icerik_sil.php?id=<?= $i['id'] ?>"
                                            onclick="return confirm('Silmek istiyor musun?')">🗑️ Sil</a>
                                    </td>
                                    <td><?= $i['tur'] === 'reklam' ? $i['tiklanma'] : '—' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <?php
                    break;

                default:
                    echo "<h2>Sayfa bulunamadı</h2>";
            }
            ?>
        </div>
    </section>
</body>

</html>