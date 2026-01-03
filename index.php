<?php
/*
📁 Bölüm: Frontend (Kullanıcı Tarafı)
📄 Amaç: Anasayfa - film ve dizi listeleme, öneri
🔗 İlişkili: config.php, static/css/filmler.css, film-detay.php, dizi-detay.php
⚙️ Özet: Ana sayfa; AJAX ile öneri döndürür, film/dizi listeler ve sayfalandırma yapar
*/
require_once 'config.php';
session_start();

/* ==========================
   AJAX ROUTER (JSON)
========================== */
if (
  isset($_GET['page'], $_GET['action']) &&
  $_GET['page'] === 'oner' &&
  $_GET['action'] === 'get_random_oner'
) {
  header('Content-Type: application/json; charset=utf-8');

  $film = $pdo->query("
    SELECT id, baslik, yil, resim_url AS poster
    FROM filmler
    ORDER BY RAND()
    LIMIT 1
  ")->fetch(PDO::FETCH_ASSOC);

  $dizi = $pdo->query("
    SELECT id, baslik, yil, poster
    FROM diziler
    ORDER BY RAND()
    LIMIT 1
  ")->fetch(PDO::FETCH_ASSOC);

  $film['baslik'] = kisalt($film['baslik'], 18);
  $dizi['baslik'] = kisalt($dizi['baslik'], 18);

  echo json_encode([
    'film' => $film,
    'dizi' => $dizi
  ]);
  exit;
}


function kisalt($metin, $limit = 12)
{
  if (mb_strlen($metin, 'UTF-8') <= $limit) {
    return $metin;
  }
  return mb_substr($metin, 0, $limit, 'UTF-8') . '...';
}

// ==========================
// PAGINATION AYARLARI
// ==========================
$sayfa = isset($_GET['sayfa']) ? max(1, (int) $_GET['sayfa']) : 1;
$limit = 24; // sayfa başına film / dizi
$offset = ($sayfa - 1) * $limit;


/* ==========================
   SAYFA PARAMETRESİ
========================== */
$page = $_GET['page'] ?? 'filmler';

/* ==========================
   FİLMLER
========================== */
if ($page === 'filmler') {

  $stmt = $pdo->prepare("
    SELECT * FROM filmler
    ORDER BY id ASC
    LIMIT :limit OFFSET :offset
  ");
  $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->execute();
  $tum_filmler = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // TOPLAM SAYFA
  $toplam_film = $pdo->query("SELECT COUNT(*) FROM filmler")->fetchColumn();
  $toplam_sayfa = ceil($toplam_film / $limit);


  $one_cikan = $pdo->query("
    SELECT * FROM filmler
    WHERE kategori='featured'
    ORDER BY imdb_puani DESC
    LIMIT 12
  ")->fetchAll(PDO::FETCH_ASSOC);

  $yakinda = $pdo->query("
    SELECT baslik, poster
    FROM yakinda
    WHERE tur='film' AND aktif=1
    ORDER BY sira ASC
  ")->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================
   DİZİLER
========================== */
if ($page === 'diziler') {

  $stmt = $pdo->prepare("
    SELECT * FROM diziler
    ORDER BY id ASC
    LIMIT :limit OFFSET :offset
  ");
  $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
  $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
  $stmt->execute();
  $tum_diziler = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // TOPLAM SAYFA
  $toplam_dizi = $pdo->query("SELECT COUNT(*) FROM diziler")->fetchColumn();
  $toplam_sayfa = ceil($toplam_dizi / $limit);


  $one_cikan = $pdo->query("
    SELECT * FROM diziler
    WHERE one_cikan=1
    ORDER BY imdb_puani DESC
    LIMIT 12
  ")->fetchAll(PDO::FETCH_ASSOC);

  $yakinda = $pdo->query("
    SELECT baslik, poster
    FROM yakinda
    WHERE tur='dizi' AND aktif=1
    ORDER BY sira ASC
  ")->fetchAll(PDO::FETCH_ASSOC);
}

/* ==========================
   SIDEBAR İÇERİKLERİ
========================== */
$sidebar_icerikler = $pdo->query("
  SELECT id, baslik, ozet, gorsel, tur, link
  FROM icerikler
  WHERE aktif = 1
    AND baslangic <= NOW()
    AND (bitis IS NULL OR bitis >= NOW())
  ORDER BY olusturma_tarihi DESC
  LIMIT 6
")->fetchAll(PDO::FETCH_ASSOC);


/* ==========================
   LİSTE (ARAMA & FİLTRE)
========================== */
if ($page === 'liste') {

  $arama = trim($_GET['arama'] ?? '');
  $tur = $_GET['tur'] ?? '';
  $yil = $_GET['yil'] ?? '';
  $imdb = $_GET['imdb'] ?? '';
  $cinedb = $_GET['cinedb'] ?? '';
  $tip = $_GET['tip'] ?? '';

  $arama_var = strlen($arama) >= 2;
  $filtre_var = ($tur || $yil || $imdb || $cinedb);

  $film_sonuclari = [];
  $dizi_sonuclari = [];

  /* -------- FİLM SORGUSU -------- */
  if (($arama_var || $filtre_var) && ($tip === '' || $tip === 'film')) {

    $sql = "
    SELECT 
      f.id,
      f.baslik,
      f.yil,
      f.resim_url AS poster,
      f.imdb_puani,
      AVG(o.puan) AS cinedb_puan
    FROM filmler f
    LEFT JOIN oylar o ON o.film_id = f.id
    WHERE 1=1
    ";

    $params = [];

    // 🔎 Arama
    if ($arama_var) {
      $sql .= " AND (
      f.baslik LIKE :arama OR
      f.tur LIKE :arama OR
      f.yonetmen LIKE :arama
    )";
      $params['arama'] = "%$arama%";
    }

    // 🎭 Tür
    if ($tur) {
      $sql .= " AND f.tur LIKE :tur";
      $params['tur'] = "%$tur%";
    }

    // 📅 Yıl
    if ($yil) {
      $sql .= " AND f.yil = :yil";
      $params['yil'] = $yil;
    }

    // ⭐ IMDb
    if (is_numeric($imdb)) {
      $sql .= " AND f.imdb_puani >= :imdb";
      $params['imdb'] = (float) $imdb;
    }

    // 🔗 GROUP BY (AVG için zorunlu)
    $sql .= " GROUP BY f.id";

    // ⭐ Cine.DB (oylar tablosu)
    if (is_numeric($cinedb)) {
      $sql .= " HAVING AVG(o.puan) >= :cinedb";
      $params['cinedb'] = (float) $cinedb;
    }

    // 📊 Sıralama
    $sql .= " ORDER BY f.imdb_puani DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $film_sonuclari = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  /* -------- DİZİ SORGUSU -------- */
  if (($arama_var || $filtre_var) && ($tip === '' || $tip === 'dizi')) {

    $sql = "
    SELECT 
      d.id,
      d.baslik,
      d.yil,
      d.poster,
      d.imdb_puani,
      AVG(do.puan) AS cinedb_puan
    FROM diziler d
    LEFT JOIN dizi_oylar do ON do.dizi_id = d.id
    WHERE 1=1
    ";

    $params = [];

    // 🔎 Arama
    if ($arama_var) {
      $sql .= " AND (
      d.baslik LIKE :arama OR
      d.tur LIKE :arama OR
      d.yonetmen LIKE :arama
    )";
      $params['arama'] = "%$arama%";
    }

    // 🎭 Tür
    if ($tur) {
      $sql .= " AND d.tur LIKE :tur";
      $params['tur'] = "%$tur%";
    }

    // 📅 Yıl
    if ($yil) {
      $sql .= " AND d.yil = :yil";
      $params['yil'] = $yil;
    }

    // ⭐ IMDb
    if (is_numeric($imdb)) {
      $sql .= " AND d.imdb_puani >= :imdb";
      $params['imdb'] = (float) $imdb;
    }

    // 🔗 GROUP BY (AVG için zorunlu)
    $sql .= " GROUP BY d.id";

    // ⭐ Cine.DB filtresi
    if (is_numeric($cinedb)) {
      $sql .= " HAVING AVG(do.puan) >= :cinedb";
      $params['cinedb'] = (float) $cinedb;
    }

    // 📊 Sıralama
    $sql .= " ORDER BY d.imdb_puani DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $dizi_sonuclari = $stmt->fetchAll(PDO::FETCH_ASSOC);
  }


}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/filmler.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <title>Filmler&Diziler...</title>
</head>

<body>
  <!-- ÜST HEADER -->
  <header class="hdr-ust">
    <a href="#" class="hdr-ust__sol"><span>Cine.</span>DB</a>
    <div class="hdr-ust__sag">
      <a href="index.php" class="btn-anasayfa">ANASAYFA</a>
      <a href="hakkimda.php" class="btn-hakkimda">HAKKIMDA</a>
      <a href="iletisim.php" class="btn-iletisim">İLETİŞİM</a>
      <!-- PROFİL MENÜ -->
      <?php if (isset($_SESSION['user_id'])): ?>
        <!-- GİRİŞ YAPMIŞ KULLANICI -->
        <div class="profil-menu">
          <div class="profil-ikon"><i class="fa fa-user-circle"></i></div>

          <div class="profil-dropdown">
            <div class="profil-info">
              <i class="fa fa-user-circle"></i>
              <div>
                <p class="isim"><?= htmlspecialchars($_SESSION['kullanici_adi']) ?></p>
                <p class="email"><?= htmlspecialchars($_SESSION['email']) ?></p>
              </div>
            </div>
            <hr />
            <?php if ($_SESSION['role'] === 'admin'): ?>
              <a href="admin/dashboard.php" class="admin-link">Admin Panel</a>
            <?php endif; ?>
            <a href="profil.php">Profilim</a>
            <a href="profil.php">Kitaplığım</a>
            <a href="cikis.php" class="logout">Çıkış Yap</a>
          </div>
        </div>
      <?php else: ?>
        <!-- GİRİŞ YAPILMAMIŞ KULLANICI -->
        <div class="profil-menu">
          <div class="profil-ikon"><i class="fa fa-user-circle"></i></div>

          <div class="profil-dropdown">
            <div class="profil-info">
              <i class="fa fa-user-circle"></i>
              <div>
                <p class="isim">Misafir</p>
                <p class="email">Giriş yapmadınız</p>
              </div>
            </div>
            <hr />
            <a href="giris.php">Giriş Yap</a>
            <a href="kayit.php">Kayıt Ol</a>
          </div>
        </div>
      <?php endif; ?>

    </div>
  </header>

  <!-- ALT HEADER -->
  <nav class="hdr-alt">
    <div class="hdr-alt__sol">
      <a href="index.php?page=filmler" class="btn-filmler">Filmler</a>
      <a href="index.php?page=diziler">Diziler</a>
      <a href="index.php?page=liste">Kategoriler</a>
      <a href="index.php?page=icerikler">Haberler</a>
      <a href="index.php?page=oner">Günün Film&Dizi'si</a>
    </div>
    <div class=" hdr-alt__sag">
      <form method="GET" action="index.php" style="display: flex; align-items: center;">
        <input type="hidden" name="page" value="liste">
        <input type="text" name="arama" placeholder="Film&Dizi Ara..."
          value="<?= htmlspecialchars($_GET['arama'] ?? '') ?>"
          style="padding: 6px 10px; border: 1px solid #555; border-radius: 4px; background: #111; color: #fff;" />
        <button type="submit"
          style="margin-left: 6px; background: #222; border: none; color: #fff; padding: 6px 10px; border-radius: 4px; cursor: pointer;">
          <i class="fa fa-search"></i>
        </button>
      </form>
    </div>

  </nav>


  <?php
  switch ($page) {

    case 'filmler':
      ?>
      <main>
        <!-- 1) ÖNE ÇIKAN FİLMLER (FEATURED) -->
        <section class="one-cikan">
          <h1 class="ana-baslik">ÖNE ÇIKAN FİLMLER</h1>
          <div class="kayan-container">
            <button class="kaydir-btn onceki">‹</button>
            <div class="kayan" id="featuredMovies">
              <?php if (!empty($one_cikan)): ?>
                <?php foreach ($one_cikan as $film): ?>
                  <article class="yeni-kart">
                    <div class="kapak">
                      <img src="<?= htmlspecialchars($film['resim_url']) ?>" alt="<?= htmlspecialchars($film['baslik']) ?>"
                        loading="lazy" />
                      <div class="kaplama">
                        <a href="http://localhost/CineDB/film-detay.php?id=<?= $film['id'] ?>" class="btn-fragman">▶ Fragman</a>
                        <form method="POST" action="kitaplik_ekle.php">
                          <input type="hidden" name="icerik_id" value="<?= $film['id'] ?>">
                          <input type="hidden" name="icerik_turu" value="film">
                          <button type="submit" class="btn-kitaplik">+ Kitaplığa Ekle</button>
                        </form>


                      </div>
                    </div>
                    <h3 class="baslik">
                      <?= htmlspecialchars(kisalt($film['baslik'])) ?>
                    </h3>
                    <p class="yil"><?= htmlspecialchars($film['yil']) ?></p>
                  </article>
                <?php endforeach; ?>
              <?php else: ?>
                <p style="color: #ccc; padding: 20px;">Henüz öne çıkan film yok.</p>
              <?php endif; ?>
            </div>


            <button class="kaydir-btn sonraki">›</button>
          </div>
        </section>

        <!-- 2) YAKINDA GELECEKLER (UPCOMING) -->
        <section class="yakinda" id="upcomingMovies">
          <?php foreach ($yakinda as $film): ?>
            <div class="yakinda-container">
              <div class="yakinda-img">
                <img src="<?= htmlspecialchars($film['poster']) ?>" alt="<?= htmlspecialchars($film['baslik']) ?>"
                  loading="lazy">
              </div>
              <a href="#"><?= htmlspecialchars($film['baslik']) ?></a>
            </div>
          <?php endforeach; ?>
        </section>
        <!-- Ana içerik -->
        <section class="genel">
          <div class="genel-sol" id="genel-sol">
            <h1 class="genel-baslik">Filmler</h1>

            <div class="film-grid" id="filmGrid">
              <?php foreach ($tum_filmler as $film): ?>
                <article class="yeni-kart">
                  <div class="kapak">
                    <img src="<?= htmlspecialchars($film['resim_url']) ?>" alt="<?= htmlspecialchars($film['baslik']) ?>"
                      loading="lazy" />
                    <div class="kaplama">
                      <a href="http://localhost/CineDB/film-detay.php?id=<?= $film['id'] ?>" class="btn-fragman">▶ Fragman</a>
                      <form method="POST" action="kitaplik_ekle.php">
                        <input type="hidden" name="icerik_id" value="<?= $film['id'] ?>">
                        <input type="hidden" name="icerik_turu" value="film">
                        <button type="submit" class="btn-kitaplik">+ Kitaplığa Ekle</button>
                      </form>
                    </div>
                  </div>
                  <h3 class="baslik">
                    <?= htmlspecialchars(kisalt($film['baslik'])) ?>
                  </h3>
                  <p class="yil"><?= htmlspecialchars($film['yil']) ?></p>
                </article>
              <?php endforeach; ?>
            </div>

            <div class="pagination">

              <?php if ($sayfa > 1): ?>
                <a href="index.php?page=filmler&sayfa=<?= $sayfa - 1 ?>#genel-sol">« Önceki</a>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $toplam_sayfa; $i++): ?>
                <a href="index.php?page=filmler&sayfa=<?= $i ?>#genel-sol" class="<?= $i == $sayfa ? 'active' : '' ?>">
                  <?= $i ?>
                </a>
              <?php endfor; ?>

              <?php if ($sayfa < $toplam_sayfa): ?>
                <a href="index.php?page=filmler&sayfa=<?= $sayfa + 1 ?>#genel-sol">Sonraki »</a>
              <?php endif; ?>

            </div>

            <div id="loading" style="text-align: center; padding: 20px; display: none">
              🔄
            </div>
          </div>
          <aside class="genel-sidebar">

            <h3 class="sidebar-baslik">🎬 Cine.DB İçerikler</h3>

            <?php if (!empty($sidebar_icerikler)): ?>
              <?php foreach ($sidebar_icerikler as $i): ?>
                <div class="sidebar-kart <?= $i['tur'] === 'reklam' ? 'reklam' : 'haber' ?>">
                  <img src="<?= htmlspecialchars($i['gorsel']) ?>" alt="">
                  <div class="sidebar-icerik">
                    <span class="etiket-mini">
                      <?= $i['tur'] === 'reklam' ? 'Sponsor' : 'Haber' ?>
                    </span>

                    <h4><?= htmlspecialchars(kisalt($i['baslik'], 28)) ?></h4>

                    <?php if ($i['tur'] === 'haber'): ?>
                      <p><?= htmlspecialchars(kisalt($i['ozet'], 60)) ?></p>
                      <a href="icerik-detay.php?id=<?= $i['id'] ?>">Devamı →</a>
                    <?php else: ?>
                      <a href="reklam_tikla.php?id=<?= $i['id'] ?>" target="_blank">İncele →</a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="sidebar-bos">
                <p>Şu an gösterilecek içerik yok.</p>
              </div>
            <?php endif; ?>

          </aside>
        </section>
      </main>
      <?php
      break;

    case 'diziler':
      ?>
      <main>
        <!-- ÖNE ÇIKAN DİZİLER -->
        <section class="one-cikan">
          <h1 class="ana-baslik">ÖNE ÇIKAN DİZİLER</h1>
          <div class="kayan-container">
            <button class="kaydir-btn onceki">‹</button>
            <div class="kayan" id="featuredDiziler">
              <?php if (!empty($one_cikan)): ?>
                <?php foreach ($one_cikan as $dizi): ?>
                  <article class="yeni-kart">
                    <div class="kapak">
                      <img src="<?= htmlspecialchars($dizi['poster']) ?>" alt="<?= htmlspecialchars($dizi['baslik']) ?>"
                        loading="lazy" />
                      <div class="kaplama">
                        <a href="dizi-detay.php?id=<?= $dizi['id'] ?>" class="btn-fragman">▶ Fragman</a>
                        <form method="POST" action="kitaplik_ekle.php">
                          <input type="hidden" name="icerik_id" value="<?= $dizi['id'] ?>">
                          <input type="hidden" name="icerik_turu" value="dizi">
                          <button type="submit" class="btn-kitaplik">+ Kitaplığa Ekle</button>
                        </form>

                      </div>
                    </div>
                    <h3 class="baslik">
                      <?= htmlspecialchars(kisalt($dizi['baslik'])) ?>
                    </h3>
                    <p class="yil"><?= htmlspecialchars($dizi['yil']) ?></p>
                  </article>
                <?php endforeach; ?>
              <?php else: ?>
                <p style="color:#ccc; padding:20px;">Henüz öne çıkan dizi yok.</p>
              <?php endif; ?>
            </div>
            <button class="kaydir-btn sonraki">›</button>
          </div>
        </section>

        <!-- 2) YAKINDA GELECEKLER (UPCOMING) -->
        <section class="yakinda" id="upcomingSeries">
          <?php foreach ($yakinda as $dizi): ?>
            <div class="yakinda-container">
              <div class="yakinda-img">
                <img src="<?= htmlspecialchars($dizi['poster']) ?>" alt="<?= htmlspecialchars($dizi['baslik']) ?>"
                  loading="lazy">
              </div>
              <a href="#"><?= htmlspecialchars($dizi['baslik']) ?></a>
            </div>
          <?php endforeach; ?>
        </section>


        <!-- ANA İÇERİK -->
        <section class="genel">
          <div class="genel-sol" id="genel-sol">
            <h1 class="genel-baslik">Diziler</h1>
            <div class="film-grid" id="diziGrid">
              <?php foreach ($tum_diziler as $dizi): ?>
                <article class="yeni-kart">
                  <div class="kapak">
                    <img src="<?= htmlspecialchars($dizi['poster']) ?>" alt="<?= htmlspecialchars($dizi['baslik']) ?>"
                      loading="lazy" />
                    <div class="kaplama">
                      <a href="dizi-detay.php?id=<?= $dizi['id'] ?>" class="btn-fragman">▶ Fragman</a>
                      <form method="POST" action="kitaplik_ekle.php">
                        <input type="hidden" name="icerik_id" value="<?= $dizi['id'] ?>">
                        <input type="hidden" name="icerik_turu" value="dizi">
                        <button type="submit" class="btn-kitaplik">+ Kitaplığa Ekle</button>
                      </form>
                    </div>
                  </div>
                  <h3 class="baslik">
                    <?= htmlspecialchars(kisalt($dizi['baslik'])) ?>
                  </h3>
                  <p class="yil"><?= htmlspecialchars($dizi['yil']) ?></p>
                </article>
              <?php endforeach; ?>
            </div>
            <div class="pagination">

              <?php if ($sayfa > 1): ?>
                <a href="index.php?page=diziler&sayfa=<?= $sayfa - 1 ?>#genel-sol">« Önceki</a>
              <?php endif; ?>

              <?php for ($i = 1; $i <= $toplam_sayfa; $i++): ?>
                <a href="index.php?page=diziler&sayfa=<?= $i ?>#genel-sol" class="<?= $i == $sayfa ? 'active' : '' ?>">
                  <?= $i ?>
                </a>
              <?php endfor; ?>

              <?php if ($sayfa < $toplam_sayfa): ?>
                <a href="index.php?page=diziler&sayfa=<?= $sayfa + 1 ?>#genel-sol">Sonraki »</a>
              <?php endif; ?>

            </div>
          </div>
          <aside class="genel-sidebar">

            <h3 class="sidebar-baslik">🎬 Cine.DB İçerikler</h3>

            <?php if (!empty($sidebar_icerikler)): ?>
              <?php foreach ($sidebar_icerikler as $i): ?>
                <div class="sidebar-kart <?= $i['tur'] === 'reklam' ? 'reklam' : 'haber' ?>">
                  <img src="<?= htmlspecialchars($i['gorsel']) ?>" alt="">
                  <div class="sidebar-icerik">
                    <span class="etiket-mini">
                      <?= $i['tur'] === 'reklam' ? 'Sponsor' : 'Haber' ?>
                    </span>

                    <h4><?= htmlspecialchars(kisalt($i['baslik'], 28)) ?></h4>

                    <?php if ($i['tur'] === 'haber'): ?>
                      <p><?= htmlspecialchars(kisalt($i['ozet'], 60)) ?></p>
                      <a href="icerik-detay.php?id=<?= $i['id'] ?>">Devamı →</a>
                    <?php else: ?>
                      <a href="<?= $i['link'] ?>" target="_blank">İncele →</a>
                    <?php endif; ?>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="sidebar-bos">
                <p>Şu an gösterilecek içerik yok.</p>
              </div>
            <?php endif; ?>

          </aside>

        </section>
      </main>
      <?php
      break;

    case 'liste':
      ?>
      <main>
        <section class="genel">

          <!-- SOL: SONUÇLAR -->
          <div class="genel-sol">

            <?php if (!$arama_var && !$filtre_var): ?>
              <p style="color:#888; padding:20px;">Lütfen arama yapın veya filtre kullanın.</p>
            <?php endif; ?>

            <?php if ($tip === '' || $tip === 'film'): ?>
              <h1 class="genel-baslik">🎬 Filmler</h1>

              <?php if (empty($film_sonuclari)): ?>
                <p style="color:#aaa">Film bulunamadı.</p>
              <?php else: ?>
                <div class="film-grid">
                  <?php foreach ($film_sonuclari as $film): ?>
                    <article class="yeni-kart">
                      <div class="kapak">
                        <img src="<?= htmlspecialchars($film['poster'] ?: 'static/img/no-poster.jpg') ?>">
                        <div class="kaplama">
                          <a href="film-detay.php?id=<?= $film['id'] ?>" class="btn-fragman">▶ Fragman</a>
                        </div>
                      </div>
                      <h3 class="baslik">
                        <?= htmlspecialchars(kisalt($film['baslik'])) ?>
                      </h3>
                      <p><?= htmlspecialchars($film['yil']) ?></p>
                      <?php if ($page === 'liste'): ?>
                        <p class="puan">
                          ⭐ Cine.DB:
                          <?= $film['cinedb_puan'] ? number_format($film['cinedb_puan'], 1) : '—' ?>
                        </p>
                      <?php endif; ?>

                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($tip === '' || $tip === 'dizi'): ?>
              <h1 class="genel-baslik">📺 Diziler</h1>

              <?php if (empty($dizi_sonuclari)): ?>
                <p style="color:#aaa">Dizi bulunamadı.</p>
              <?php else: ?>
                <div class="film-grid">
                  <?php foreach ($dizi_sonuclari as $dizi): ?>
                    <article class="yeni-kart">
                      <div class="kapak">
                        <img src="<?= htmlspecialchars($dizi['poster'] ?: 'static/img/no-poster.jpg') ?>">
                        <div class="kaplama">
                          <a href="dizi-detay.php?id=<?= $dizi['id'] ?>" class="btn-fragman">▶ Fragman</a>
                        </div>
                      </div>
                      <h3 class="baslik">
                        <?= htmlspecialchars(kisalt($dizi['baslik'])) ?>
                      </h3>
                      <p><?= htmlspecialchars($dizi['yil']) ?></p>
                      <p class="puan">
                        ⭐ Cine.DB:
                        <?= $dizi['cinedb_puan'] !== null
                          ? number_format($dizi['cinedb_puan'], 1)
                          : '—' ?>
                      </p>
                    </article>
                  <?php endforeach; ?>
                </div>
              <?php endif; ?>
            <?php endif; ?>

          </div>

          <!-- SAĞ: FİLM & DİZİ ROBOTU -->
          <div class="genel-sidebar">

            <div class="film-robotu">
              <h1 class="genel-baslik">Film & Dizi Robotu</h1>

              <form method="GET" action="index.php">
                <input type="hidden" name="page" value="liste">

                <?php if (!empty($arama)): ?>
                  <input type="hidden" name="arama" value="<?= htmlspecialchars($arama) ?>">
                <?php endif; ?>

                <!-- Film / Dizi -->
                <select name="tip">
                  <option value="">Film + Dizi</option>
                  <option value="film" <?= $tip === 'film' ? 'selected' : '' ?>>Sadece Film</option>
                  <option value="dizi" <?= $tip === 'dizi' ? 'selected' : '' ?>>Sadece Dizi</option>
                </select>

                <!-- Tür -->
                <select name="tur">
                  <option value="">Tür Seç</option>
                  <option value="Aksiyon" <?= $tur === 'Aksiyon' ? 'selected' : '' ?>>Aksiyon</option>
                  <option value="Dram" <?= $tur === 'Dram' ? 'selected' : '' ?>>Dram</option>
                  <option value="Komedi" <?= $tur === 'Komedi' ? 'selected' : '' ?>>Komedi</option>
                  <option value="Bilim Kurgu" <?= $tur === 'Bilim Kurgu' ? 'selected' : '' ?>>Bilim Kurgu</option>
                  <option value="Korku" <?= $tur === 'Korku' ? 'selected' : '' ?>>Korku</option>
                </select>

                <!-- Yıl -->
                <select name="yil">
                  <option value="">Yıl</option>
                  <?php for ($y = date('Y'); $y >= 1980; $y--): ?>
                    <option value="<?= $y ?>" <?= $yil == $y ? 'selected' : '' ?>><?= $y ?></option>
                  <?php endfor; ?>
                </select>

                <!-- IMDb -->
                <select name="imdb">
                  <option value="">IMDb Alt Sınır</option>
                  <option value="9" <?= $imdb == '9' ? 'selected' : '' ?>>9+</option>
                  <option value="8" <?= $imdb == '8' ? 'selected' : '' ?>>8+</option>
                  <option value="7" <?= $imdb == '7' ? 'selected' : '' ?>>7+</option>
                  <option value="6" <?= $imdb == '6' ? 'selected' : '' ?>>6+</option>
                </select>

                <select name="cinedb">
                  <option value="">Cine.DB Puan</option>
                  <option value="4" <?= $cinedb == '4' ? 'selected' : '' ?>>4+</option>
                  <option value="3" <?= $cinedb == '3' ? 'selected' : '' ?>>3+</option>
                  <option value="2" <?= $cinedb == '2' ? 'selected' : '' ?>>2+</option>
                </select>


                <div style="display:flex; justify-content:space-between;">
                  <button type="submit" class="btn-getir">Getir</button>
                  <a href="index.php?page=liste" class="btn-sifirla"
                    style="text-align:center; line-height:34px;">Sıfırla</a>
                </div>
              </form>
            </div>

          </div>

        </section>
      </main>
      <?php
      break;

    case 'icerikler':

      $icerikler = $pdo->query("
        SELECT * FROM icerikler
        WHERE aktif = 1
          AND baslangic <= NOW()
          AND (bitis IS NULL OR bitis >= NOW())
        ORDER BY olusturma_tarihi DESC
      ")->fetchAll(PDO::FETCH_ASSOC);

      $haberler = [];
      $reklamlar = [];

      foreach ($icerikler as $i) {
        if ($i['tur'] === 'haber') {
          $haberler[] = $i;
        } elseif ($i['tur'] === 'reklam') {
          $reklamlar[] = $i;
        }
      }
      ?>

      <main class="haberler-main">

        <h1 class="haberler-baslik">📰 Cine.DB Haberler</h1>

        <!-- 🔥 ÜST REKLAM -->
        <?php if (!empty($reklamlar)): ?>
          <?php foreach ($reklamlar as $r): ?>
            <?php if ($r['konum'] === 'ust'): ?>
              <a href="reklam_tikla.php?id=<?= $r['id'] ?>" target="_blank" class="haber-reklam-ust">
                <div class="interactive-img">
                  <img src="<?= $r['gorsel'] ?>" alt="">
                  <div class="glow"></div>
                </div>
              </a>
            <?php endif; ?>
          <?php endforeach; ?>
        <?php endif; ?>

        <!-- HABERLER -->
        <section class="haberler-grid">

          <?php foreach ($haberler as $h): ?>
            <article class="haber-kart">

              <div class="haber-gorsel">
                <img src="<?= htmlspecialchars($h['gorsel']) ?>" alt="">
                <span class="haber-etiket"><?= strtoupper($h['hedef']) ?></span>
              </div>

              <div class="haber-icerik">
                <h3><?= htmlspecialchars($h['baslik']) ?></h3>
                <p><?= htmlspecialchars(mb_substr($h['ozet'], 0, 120)) ?>...</p>

                <a href="icerik-detay.php?id=<?= $h['id'] ?>">Haberi Oku →</a>
              </div>

            </article>
          <?php endforeach; ?>

        </section>

        <!-- 🔥 ALT REKLAM -->
        <?php foreach ($reklamlar as $r): ?>
          <?php if ($r['konum'] === 'alt'): ?>
            <a href="reklam_tikla.php?id=<?= $r['id'] ?>" target="_blank" class="haber-reklam-alt">
              <img src="<?= $r['gorsel'] ?>">
            </a>
          <?php endif; ?>
        <?php endforeach; ?>

      </main>
      <?php break;

    case 'oner':
      ?>
      <main class="oner-wrapper">

        <h2>🎯 Bugün Ne İzlesem?</h2>

        <div class="oner-container">

          <div class="oner-card">
            <img id="film-img" src="static/img/premium_photo-1710409625244-e9ed7e98f67b.avif">
            <h3 id="film-baslik">Film</h3>
            <p id="film-yil">Butona Bas!!!</p>
            <a id="film-link" href="#">Detay</a>
          </div>

          <div class="oner-card">
            <img id="dizi-img" src="static/img/premium_photo-1710409625244-e9ed7e98f67b.avif">
            <h3 id="dizi-baslik">Dizi</h3>
            <p id="dizi-yil">Butona Bas!!!</p>
            <a id="dizi-link" href="#">Detay</a>
          </div>

        </div>

        <button id="btn-oner-getir">✨ Başka Öner</button>
      </main>

      <script>
        document.addEventListener('DOMContentLoaded', () => {

          const btn = document.getElementById('btn-oner-getir');

          function onerGetir() {
            btn.disabled = true;
            btn.innerText = "🔄 Seçiliyor...";

            fetch('index.php?page=oner&action=get_random_oner')
              .then(r => r.json())
              .then(data => {

                document.getElementById('film-img').src =
                  data.film.poster || 'static/img/no-poster.jpg';
                document.getElementById('film-baslik').innerText =
                  data.film.baslik;
                document.getElementById('film-yil').innerText =
                  data.film.yil;
                document.getElementById('film-link').href =
                  'film-detay.php?id=' + data.film.id;

                document.getElementById('dizi-img').src =
                  data.dizi.poster || 'static/img/no-poster.jpg';
                document.getElementById('dizi-baslik').innerText =
                  data.dizi.baslik;
                document.getElementById('dizi-yil').innerText =
                  data.dizi.yil;
                document.getElementById('dizi-link').href =
                  'dizi-detay.php?id=' + data.dizi.id;

                btn.disabled = false;
                btn.innerText = "✨ Başka Öner";
              })
              .catch(() => {
                btn.innerText = "❌ Hata";
                btn.disabled = false;
              });
          }

          // 🔥 SADECE BUTONA BASILINCA
          btn.addEventListener('click', onerGetir);
        });
      </script>

      <?php
      break;

    default:
      echo "<h2>Sayfa bulunamadı</h2>";
  }
  ?>

  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="footer-container">
      <!-- Sol taraf: logo & açıklama -->
      <div class="footer-left">
        <h2><span>Cine.</span>DB</h2>
        <p>
          En yeni filmleri, dizileri ve fragmanları keşfedin. Cine.DB, sinema
          dünyasının kalbinde!
        </p>
      </div>

      <!-- Orta: menü linkleri -->
      <div class="footer-center">
        <h3>Keşfet</h3>
        <ul>
          <li><a href="#">Anasayfa</a></li>
          <li><a href="#">Kategoriler</a></li>
          <li><a href="#">Yakında</a></li>
          <li><a href="#">Kitaplığım</a></li>
        </ul>
      </div>

      <!-- Sağ: sosyal medya -->
      <div class="footer-right">
        <h3>Bizi Takip Et</h3>
        <div class="social-icons">
          <a href="#"><i class="fa fa-instagram"></i></a>
          <a href="#"><i class="fa fa-twitter"></i></a>
          <a href="#"><i class="fa fa-youtube"></i></a>
          <a href="#"><i class="fa fa-facebook"></i></a>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© 2025 Cine.DB — Tüm hakları saklıdır.</p>
    </div>
  </footer>

  <script src="static/js/filmler.js"></script>
</body>

</html>