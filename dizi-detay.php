<?php
/*
📁 Bölüm: Frontend (Kullanıcı Tarafı)
📄 Amaç: Dizi detay sayfası
🔗 İlişkili: index.php, static/js/film-dizi-detay.js, config.php
⚙️ Özet: Dizi bilgilerini, yorum ve oyları gösterir; etkileşimleri işler
*/
require_once 'config.php';
session_start();

/* ============================================================
   1️⃣ URL'den dizi ID
============================================================ */
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  die("Geçersiz dizi ID'si");
}
$dizi_id = (int) $_GET['id'];

/* ============================================================
   2️⃣ YORUM EKLEME
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['yorum'])) {
  if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
  }

  $yorum = trim($_POST['yorum']);
  if ($yorum !== '') {
    $stmt = $pdo->prepare("
      INSERT INTO dizi_yorumlar (dizi_id, user_id, yorum)
      VALUES (?, ?, ?)
    ");
    $stmt->execute([$dizi_id, $_SESSION['user_id'], $yorum]);
  }

  header("Location: dizi-detay.php?id=" . $dizi_id);
  exit;
}

/* ============================================================
   ⭐ DİZİ PUANLAMA
============================================================ */
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['puan'])) {
  if (!isset($_SESSION['user_id'])) {
    header("Location: giris.php");
    exit;
  }

  $puan = (int) $_POST['puan'];

  if ($puan >= 1 && $puan <= 5) {
    $stmt = $pdo->prepare("
      INSERT INTO dizi_oylar (dizi_id, user_id, puan)
      VALUES (?, ?, ?)
      ON DUPLICATE KEY UPDATE puan = VALUES(puan)
    ");
    $stmt->execute([$dizi_id, $_SESSION['user_id'], $puan]);
  }

  header("Location: dizi-detay.php?id=" . $dizi_id);
  exit;
}

/* ============================================================
   3️⃣ Dizi Bilgileri
============================================================ */
$stmt = $pdo->prepare("SELECT * FROM diziler WHERE id = ?");
$stmt->execute([$dizi_id]);
$dizi = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$dizi) {
  die("Dizi bulunamadı.");
}

/* ============================================================
   4️⃣ ORTALAMA PUAN
============================================================ */
$stmt = $pdo->prepare("
  SELECT AVG(puan)
  FROM dizi_oylar
  WHERE dizi_id = ?
");
$stmt->execute([$dizi_id]);
$ortalama = $stmt->fetchColumn();
$ortalama = $ortalama ? number_format($ortalama, 1) : "0.0";
?>



<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/film-dizi-detay.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <title><?= htmlspecialchars($dizi['baslik']) ?> | Cine.DB</title>
</head>

<body>

  <!-- ========================= HEADER ========================= -->
  <header class="hdr-ust">
    <a href="#" class="hdr-ust__sol"><span>Cine.</span>DB</a>
    <div class="hdr-ust__sag">
      <a href="index.php" class="btn-anasayfa">ANASAYFA</a>
      <a href="hakkimda.php">HAKKIMDA</a>
      <a href="iletisim.php">İLETİŞİM</a>

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

  <!-- ========================= MAIN ========================= -->
  <main id="filmMain">

    <button class="geri-btn" onclick="window.history.back()">
      <i class="fa fa-arrow-left"></i> Geri
    </button>

    <!-- HERO BÖLÜMÜ -->
    <section class="detay-hero">
      <div class="hero-icerik">

        <div class="hero-afis">
          <img src="<?= htmlspecialchars($dizi['poster']) ?>" alt="<?= htmlspecialchars($dizi['baslik']) ?> Poster" />
        </div>

        <div class="hero-metin">
          <h1 class="film-baslik"><?= htmlspecialchars($dizi['baslik']) ?></h1>

          <ul class="film-etiketler">
            <li><?= htmlspecialchars($dizi['yil']) ?></li>
            <li><?= htmlspecialchars($dizi['tur']) ?></li>
            <li><?= htmlspecialchars($dizi['sezon_sayisi']) ?> Sezon</li>
            <li><?= htmlspecialchars($dizi['bolum_sayisi']) ?> Bölüm</li>
            <li>IMDb: <?= htmlspecialchars($dizi['imdb_puani']) ?></li>
          </ul>

          <p class="film-ozet"><?= htmlspecialchars($dizi['ozet']) ?></p>

          <div class="aksiyon-alani">
            <a href="#fragman" class="aksiyon-btn fragman-btn">
              <i class="fa fa-play"></i> Fragmanı İzle
            </a>

            <form method="POST" action="kitaplik_ekle.php">
              <input type="hidden" name="icerik_id" value="<?= $dizi['id'] ?>">
              <input type="hidden" name="icerik_turu" value="dizi">
              <button type="submit" class="btn-kitaplik">+ Kitaplığa Ekle</button>
            </form>


            <div class="inline-rating">
              <div class="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                  <form method="POST" style="display:inline;">
                    <input type="hidden" name="puan" value="<?= $i ?>">
                    <button type="submit" style="background:none;border:none;cursor:pointer;">
                      <i class="fa fa-star"></i>
                    </button>
                  </form>
                <?php endfor; ?>
              </div>

              <span>(<?= $ortalama ?> / 5)</span>
            </div>



            <?php
            $oy = $pdo->prepare("
              SELECT AVG(puan) 
              FROM dizi_oylar 
              WHERE dizi_id = ?
            ");
            $oy->execute([$dizi_id]);
            $ortalama = $oy->fetchColumn();
            $ortalama = $ortalama ? number_format($ortalama, 1) : "0.0";

            ?>
          </div>
          <div class="bilgi-grid">
            <div><span>Yönetmen</span> <?= htmlspecialchars($dizi['yonetmen']) ?></div>
            <div><span>Yazar</span> <?= htmlspecialchars($dizi['yazar']) ?></div>
            <div><span>Başroller</span> <?= htmlspecialchars($dizi['basrollers']) ?></div>
            <div><span>Ülke</span> <?= htmlspecialchars($dizi['ulke']) ?></div>
          </div>
        </div>



      </div>
      </div>
    </section>

    <!-- FRAGMAN -->
    <section class="fragman-blok" id="fragman">
      <h2>Fragman</h2>
      <div class="video-wrap">
        <iframe src="<?= htmlspecialchars($dizi['fragman_url']) ?>" allowfullscreen></iframe>
      </div>
    </section>

    <!-- YORUMLAR -->
    <section class="yorum-blok">
      <h2>Yorumlar</h2>

      <?php if (isset($_SESSION['user_id'])): ?>
        <form class="yorum-form" method="POST">
          <textarea name="yorum" placeholder="Düşüncelerini paylaş..." required></textarea>
          <button type="submit" class="yorum-gonder">Gönder</button>
        </form>
      <?php else: ?>
        <p style="color:#ccc;">Yorum yapmak için giriş yapmalısın.</p>
      <?php endif; ?>

      <div class="yorum-listesi">
        <?php
        $yorumlar = $pdo->prepare("
          SELECT y.*, u.kullanici_adi
          FROM dizi_yorumlar y
          JOIN users u ON u.id = y.user_id
          WHERE y.dizi_id = ?
          ORDER BY y.tarih DESC
        ");
        $yorumlar->execute([$dizi_id]);
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

  <!-- ========================= FOOTER ========================= -->
  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-left">
        <h2><span>Cine.</span>DB</h2>
        <p>Dizileri keşfedin, fragmanları izleyin.</p>
      </div>
      <div class="footer-center">
        <h3>Keşfet</h3>
        <ul>
          <li><a href="index.php">Anasayfa</a></li>
          <li><a href="diziler.php">Diziler</a></li>
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