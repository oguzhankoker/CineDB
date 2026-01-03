<?php
/*
📁 Bölüm: Frontend (Kullanıcı Tarafı)
📄 Amaç: Hakkımda statik sayfası
🔗 İlişkili: static/css/hakkimda.css
⚙️ Özet: Site/ proje hakkında bilgi gösterir (statik içerik)
*/
require_once 'config.php';
session_start();
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/filmler.css" />
  <link rel="stylesheet" href="static/css/hakkimda.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <title>Hakkımda • Cine.DB</title>
</head>

<body>
  <!-- HEADER -->
  <header class="hdr-ust">
    <a href="/templates/filmler/filmler.html" class="hdr-ust__sol"><span>Cine.</span>DB</a>
    <div class="hdr-ust__sag">
      <a href="index.php" class="btn-anasayfa">ANASAYFA</a>
      <a href="hakkimda.php" class="btn-hakkimda aktif">HAKKIMDA</a>
      <a href="iletisim.php" class="btn-iletisim">İLETİŞİM</a>
      <!-- PROFİL MENÜ -->
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
    </div>
  </header>

  <!-- MAIN -->
  <main class="hakkimda-main">
    <section class="hakkimda-icerik">
      <h1>Hakkımda</h1>
      <p>
        Merhaba! Ben <strong>Cine.DB</strong>’nin yaratıcısıyım. Bu proje,
        film ve dizi tutkunlarının bir araya gelip en güncel yapımları
        keşfedebileceği modern bir sinema platformu olarak tasarlandı.
      </p>
      <p>
        Amacım, kullanıcı dostu arayüzü ve veritabanı destekli yapısı
        sayesinde izlediğiniz ve izlemek istediğiniz yapımları kolayca takip
        etmenizi sağlamak. 🎬
      </p>
      <p>
        Bu siteyi geliştirirken <strong>HTML, CSS, JavaScript</strong> ve
        <strong>PHP (PHP + MySQL)</strong> teknolojilerini kullandım.
        Geri bildirimleriniz benim için çok değerli!
      </p>
    </section>
  </main>

  <!-- FOOTER -->
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
          <li><a href="/templates/filmler/filmler.html">Anasayfa</a></li>
          <li><a href="#">Kategoriler</a></li>
          <li><a href="#">Yakında</a></li>
          <li><a href="#">Kitaplığım</a></li>
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
  <script src="static/js/filmler.js"></script>
</body>

</html>