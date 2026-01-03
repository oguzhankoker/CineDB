<?php
/*
📁 Bölüm: Frontend (Kullanıcı Tarafı)
📄 Amaç: Film detay sayfası
🔗 İlişkili: index.php, static/js/film-dizi-detay.js, config.php
⚙️ Özet: Film bilgilerini, yorum ve oyları gösterir; tıklama/etkileşimleri işler
*/
require_once 'config.php';
session_start();

/* ============================================================
   1️⃣ URL'den film ID'sini al
============================================================ */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Geçersiz film ID'si");
}
$film_id = (int) $_GET['id'];

/* ============================================================
   2️⃣ YORUM EKLEME
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['yorum'])) {
  if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
  }

  $yorum = trim($_POST['yorum']);
  if (!empty($yorum)) {
    $yorumEkle = $pdo->prepare("INSERT INTO yorumlar (film_id, user_id, yorum) VALUES (?, ?, ?)");
    $yorumEkle->execute([$film_id, $_SESSION['user_id'], $yorum]);
  }

  header("Location: film-detay.php?id=" . $film_id);
  exit;
}

/* ============================================================
   3️⃣ PUAN VERME
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['puan'])) {
  if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
  }

  $puan = (int) $_POST['puan'];
  if ($puan >= 1 && $puan <= 5) {
    // Aynı kullanıcı aynı filme daha önce puan vermişse güncelle
    $kontrol = $pdo->prepare("SELECT * FROM oylar WHERE film_id = ? AND user_id = ?");
    $kontrol->execute([$film_id, $_SESSION['user_id']]);

    if ($kontrol->rowCount() > 0) {
      $guncelle = $pdo->prepare("UPDATE oylar SET puan = ?, tarih = NOW() WHERE film_id = ? AND user_id = ?");
      $guncelle->execute([$puan, $film_id, $_SESSION['user_id']]);
    } else {
      $ekle = $pdo->prepare("INSERT INTO oylar (film_id, user_id, puan) VALUES (?, ?, ?)");
      $ekle->execute([$film_id, $_SESSION['user_id'], $puan]);
    }
  }

  header("Location: film-detay.php?id=" . $film_id);
  exit;
}

/* ============================================================
   ✅ 4️⃣ BURAYA EKLE (ortalama + kullanıcının puanı)
============================================================ */
// Kullanıcının bu filme verdiği puan (varsa)
$kullanici_puani = 0;
if (isset($_SESSION['user_id'])) {
  $st = $pdo->prepare("SELECT puan FROM oylar WHERE film_id = ? AND user_id = ? LIMIT 1");
  $st->execute([$film_id, $_SESSION['user_id']]);
  $kullanici_puani = (int) ($st->fetchColumn() ?: 0);
}

// Ortalama puan
$stAvg = $pdo->prepare("SELECT AVG(puan) FROM oylar WHERE film_id = ?");
$stAvg->execute([$film_id]);
$ortalama = $stAvg->fetchColumn();
$ortalama = $ortalama ? number_format($ortalama, 1) : "0.0";

/* ============================================================
   5️⃣ Film Bilgilerini Veritabanından Çek
============================================================ */
$stmt = $pdo->prepare("SELECT * FROM filmler WHERE id = ?");
$stmt->execute([$film_id]);
$film = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$film) {
  die("Film bulunamadı.");
}
?>


<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/film-dizi-detay.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet" />
  <title><?= htmlspecialchars($film['baslik']) ?> | Cine.DB</title>
</head>

<body>
  <!-- =========================
         HEADER
    ========================== -->
  <header class="hdr-ust">
    <a href="#" class="hdr-ust__sol"><span>Cine.</span>DB</a>
    <div class="hdr-ust__sag">
      <a href="index.php" class="btn-anasayfa">ANASAYFA</a>
      <a href="hakkimda.php">HAKKIMDA</a>
      <a href="iletisim.php">İLETİŞİM</a>

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

  <!-- =========================
         MAIN
    ========================== -->
  <main id="filmMain" data-film-id="godfather-1972">
    <!-- Geri Butonu -->
    <button class="geri-btn" id="geriBtn" aria-label="Geri dön">
      <i class="fa fa-arrow-left"></i> Geri
    </button>

    <!-- Film Bilgileri -->
    <section class="detay-hero">
      <div class="hero-icerik">
        <div class="hero-afis">
          <img src="<?= htmlspecialchars($film['resim_url']) ?>" alt="<?= htmlspecialchars($film['baslik']) ?> Poster"
            loading="lazy" />
        </div>

        <div class="hero-metin">
          <h1 class="film-baslik"><?= htmlspecialchars($film['baslik']) ?></h1>

          <ul class="film-etiketler">
            <li><?= htmlspecialchars($film['yil']) ?></li>
            <li><?= htmlspecialchars($film['sure']) ?> dk</li>
            <li><?= htmlspecialchars($film['tur']) ?></li>
            <li>IMDb <?= htmlspecialchars($film['imdb_puani']) ?></li>
          </ul>

          <p class="film-ozet"><?= htmlspecialchars($film['ozet']) ?></p>

          <div class="aksiyon-alani">
            <a href="#fragman" class="aksiyon-btn fragman-btn">
              <i class="fa fa-play"></i> Fragmanı İzle
            </a>

            <form method="POST" action="kitaplik_ekle.php">
              <input type="hidden" name="film_id" value="<?= $film['id'] ?>">
              <button type="submit" class="btn-kitaplik">+ Kitaplığa Ekle</button>
            </form>


            <div class="inline-rating">
              <div class="stars" id="inlineStars" aria-label="Puan ver">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="puan" value="<?= $i ?>">
                    <button type="submit" style="background:none;border:none;cursor:pointer;">
                      <i class="fa fa-star"></i>
                    </button>
                  </form>
                <?php endfor; ?>
              </div>

              <?php
              $oy = $pdo->prepare("SELECT AVG(puan) FROM oylar WHERE film_id = ?");
              $oy->execute([$film_id]);
              $ortalama = $oy->fetchColumn();
              $ortalama = $ortalama ? number_format($ortalama, 1) : "0.0";
              ?>
              <span id="inlineAverage" data-avg="<?= $ortalama ?>">(<?= $ortalama ?> / 5)</span>

            </div>
          </div>

          <div class="bilgi-grid">
            <div><span>Yönetmen</span> <?= htmlspecialchars($film['yonetmen']) ?></div>
            <div><span>Yazar</span> <?= htmlspecialchars($film['yazar']) ?></div>
            <div><span>Başroller</span> <?= htmlspecialchars($film['basroller']) ?></div>
            <div><span>Ülke</span> <?= htmlspecialchars($film['ulke']) ?></div>
          </div>
        </div>
      </div>
    </section>

    <!-- Fragman -->
    <section class="fragman-blok" id="fragman">
      <h2>Fragman</h2>
      <div class="video-wrap">
        <iframe src="<?= htmlspecialchars($film['fragman_url']) ?>"
          title="<?= htmlspecialchars($film['baslik']) ?> Fragman" allowfullscreen></iframe>
      </div>
    </section>

    <!-- YORUMLAR -->
    <section class="yorum-blok">
      <h2>Yorumlar</h2>

      <form id="yorumForm" class="yorum-form" method="POST" action="">
        <textarea name="yorum" id="yorumInput" placeholder="Düşüncelerini paylaş..." required></textarea>
        <button type="submit" class="yorum-gonder">Gönder</button>
      </form>


      <div id="yorumListesi" class="yorum-listesi">
        <?php
        $yorumlar = $pdo->prepare("
    SELECT y.*, u.kullanici_adi 
    FROM yorumlar y 
    JOIN users u ON u.id = y.user_id 
    WHERE y.film_id = ? 
    ORDER BY y.tarih DESC
  ");
        $yorumlar->execute([$film_id]);
        $yorumlar = $yorumlar->fetchAll(PDO::FETCH_ASSOC);

        if ($yorumlar):
          foreach ($yorumlar as $yrm):
            ?>
            <div class="yorum">
              <p><strong><?= htmlspecialchars($yrm['kullanici_adi']) ?></strong>
                <small>(<?= date('d M Y H:i', strtotime($yrm['tarih'])) ?>)</small>
              </p>
              <p><?= nl2br(htmlspecialchars($yrm['yorum'])) ?></p>
            </div>
            <?php
          endforeach;
        else:
          echo "<p>Henüz yorum yapılmamış. İlk yorumu sen yaz!</p>";
        endif;
        ?>
      </div>

    </section>
  </main>

  <!-- =========================
         FOOTER
    ========================== -->
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-left">
        <h2><span>Cine.</span>DB</h2>
        <p>
          En yeni filmleri, dizileri ve fragmanları keşfedin. Cine.DB, sinema
          dünyasının kalbinde!
        </p>
      </div>
      <div class="footer-center">
        <h3>Keşfet</h3>
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="profil.php">Kitaplığım</a></li>
        </ul>
      </div>
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

  <script src="static/js/film-dizi-detay.js"></script>
</body>

</html>