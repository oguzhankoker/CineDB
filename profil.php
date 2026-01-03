<?php
/*
📁 Bölüm: Kullanıcı (Profil & Kitaplık)
📄 Amaç: Kullanıcı profil sayfası
🔗 İlişkili: config.php, kitaplik_ekle.php, kitaplik_sil.php, static/css/profil.css
⚙️ Özet: Giriş kontrolü yapar, kullanıcı bilgilerini çeker ve profil görünümünü sağlar
*/
require_once 'config.php';
session_start();

// Giriş yapılmamışsa giriş sayfasına yönlendir
if (!isset($_SESSION['user_id'])) {
  header("Location: giris.php");
  exit;
}

// Kullanıcı bilgilerini çek
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  die("Kullanıcı bulunamadı.");
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/profil.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet" />
  <title><?= htmlspecialchars($user['kullanici_adi']) ?> • Cine.DB</title>
</head>

<body>
  <div class="cine-bg">
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
    <span>Cine.DB</span>
  </div>
  <!-- ÜST HEADER -->
  <header class="hdr-ust">
    <a href="#" class="hdr-ust__sol"><span>Cine.</span>DB</a>
    <div class="hdr-ust__sag">
      <a href="index.php">Anasayfa</a>
      <a href="#kitapligim">Kitaplığım</a>
      <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="admin/dashboard.php" class="admin-link">Admin Panel</a>
      <?php endif; ?>
      <a href="cikis.php">Çıkış Yap</a>

    </div>
  </header>

  <!-- PROFİL ANA İÇERİK -->
  <main class="profile-container">
    <section class="profile-card">
      <div class="profile-header">
        <div class="avatar">
          <i class="fa fa-user-circle"></i>
        </div>
        <div class="user-info">
          <h2 id="username"><?= htmlspecialchars($user['kullanici_adi']) ?></h2>
          <p class="email"><?= htmlspecialchars($user['email']) ?></p>
          <span class="role">Kullanıcı</span>
        </div>
      </div>

      <div class="profile-actions">
        <!-- <button class="edit-btn">
          <i class="fa fa-pencil"></i> Profili Düzenle
        </button> -->
        <a href="cikis.php" class="cikis-btn">Çıkış Yap</a>

      </div>

      <hr class="divider" />

      <div class="profile-details">
        <h3>Hesap Bilgileri</h3>
        <ul>
          <li><strong>Kullanıcı Adı:</strong> <?= htmlspecialchars($user['kullanici_adi']) ?></li>
          <li><strong>E-posta:</strong> <?= htmlspecialchars($user['email']) ?></li>
          <li><strong>Kayıt Tarihi:</strong> <?= date('d M Y', strtotime($user['kayit_tarihi'])) ?></li>
          <li><strong>Favori Tür:</strong> <?= htmlspecialchars($user['favori_tur'] ?? 'Belirtilmemiş') ?></li>
        </ul>
      </div>

      <div class="profile-library">
        <h3 id="kitapligim">Kitaplığım</h3>

        <h3 style="margin-top:30px;">Filmler</h3>

        <div class="film-grid">
          <?php
          // Kullanıcının kitaplığı
          $stmt = $pdo->prepare("
          SELECT f.id, f.baslik, f.resim_url, f.yil
          FROM kullanici_kitaplik k
          JOIN filmler f ON f.id = k.icerik_id
          WHERE k.user_id = ?
          AND k.icerik_turu = 'film'
          ORDER BY k.eklenme_tarihi DESC
          ");


          $stmt->execute([$_SESSION['user_id']]);
          $kitaplik_filmler = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if ($kitaplik_filmler):
            foreach ($kitaplik_filmler as $film):
              ?>
              <article class="yeni-kart">
                <div class="kapak">
                  <img src="<?= htmlspecialchars($film['resim_url']) ?>" alt="<?= htmlspecialchars($film['baslik']) ?>"
                    loading="lazy" />

                  <div class="kaplama">
                    <a href="film-detay.php?id=<?= $film['id'] ?>" class="btn-fragman">▶ Fragman</a>
                    <form method="POST" action="kitaplik_sil.php"
                      onsubmit="return confirm('Bu filmi kitaplıktan kaldırmak istediğine emin misin?');">
                      <input type="hidden" name="icerik_id" value="<?= $film['id'] ?>">
                      <input type="hidden" name="icerik_turu" value="film">
                      <button type="submit" class="sil-btn">❌ Kaldır</button>
                    </form>
                  </div>
                </div>

                <h3 class="baslik"><?= htmlspecialchars($film['baslik']) ?></h3>
                <p class="yil"><?= htmlspecialchars($film['yil'] ?? '—') ?></p>
              </article>

              <?php
            endforeach;
          else:
            echo '<p class="kitaplik-bos">Henüz kitaplığınıza film eklemediniz.</p>';
          endif;
          ?>
        </div>

        <h3 style="margin-top:30px;">Diziler</h3>

        <div class="film-grid">
          <?php
          $stmt = $pdo->prepare("
            SELECT 
              d.id,
              d.baslik,
              d.poster AS resim_url,
              d.yil
            FROM kullanici_kitaplik k
            JOIN diziler d ON d.id = k.icerik_id
            WHERE k.user_id = ?
            AND k.icerik_turu = 'dizi'
            ORDER BY k.eklenme_tarihi DESC
          ");


          $stmt->execute([$user_id]);
          $diziler = $stmt->fetchAll(PDO::FETCH_ASSOC);

          if ($diziler):
            foreach ($diziler as $dizi):
              ?>
              <article class="yeni-kart">
                <div class="kapak">
                  <img src="<?= htmlspecialchars($dizi['resim_url']) ?>" alt="<?= htmlspecialchars($dizi['baslik']) ?>">

                  <div class="kaplama">
                    <a href="dizi-detay.php?id=<?= $dizi['id'] ?>" class="btn-fragman">▶ Fragman</a>

                    <form method="POST" action="kitaplik_sil.php"
                      onsubmit="return confirm('Bu diziyi kitaplıktan kaldırmak istediğine emin misin?');">
                      <input type="hidden" name="icerik_id" value="<?= $dizi['id'] ?>">
                      <input type="hidden" name="icerik_turu" value="dizi">
                      <button type="submit" class="sil-btn">❌ Kaldır</button>
                    </form>
                  </div>
                </div>

                <h3 class="baslik"><?= htmlspecialchars($dizi['baslik']) ?></h3>
                <p class="yil"><?= htmlspecialchars($dizi['yil'] ?? '—') ?></p>
              </article>
              <?php
            endforeach;
          else:
            echo '<p class="kitaplik-bos">Henüz kitaplığınıza dizi eklemediniz.</p>';
          endif;
          ?>
        </div>

      </div>


    </section>
  </main>

  <!-- FOOTER -->
  <footer class="site-footer">
    <!-- INTRO -->
    <div id="intro">
      <div class="intro-logo">
        <span class="intro-text">Cine.<strong>DB</strong></span>
      </div>
    </div>
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