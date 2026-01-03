<?php
/*
📁 Bölüm: Frontend (Kullanıcı Tarafı)
📄 Amaç: İletişim formu sayfası
🔗 İlişkili: config.php, static/css/iletisim.css
⚙️ Özet: Kullanıcı mesajlarını alır/işler (form), basit iletişim sayfası
*/
require_once 'config.php';
session_start();

$mesaj_gonderildi = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $isim = trim($_POST['isim']);
  $email = trim($_POST['email']);
  $mesaj = trim($_POST['mesaj']);

  if (!empty($isim) && !empty($email) && !empty($mesaj)) {
    $stmt = $pdo->prepare("INSERT INTO iletisim_mesajlari (isim, email, mesaj) VALUES (:isim, :email, :mesaj)");
    $stmt->execute([
      'isim' => $isim,
      'email' => $email,
      'mesaj' => $mesaj
    ]);
    $mesaj_gonderildi = true;
  }
}
?>


<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/filmler.css" />
  <link rel="stylesheet" href="static/css/iletisim.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <title>İletişim • Cine.DB</title>
</head>

<body>
  <!-- HEADER -->
  <header class="hdr-ust">
    <a href="/templates/filmler/filmler.html" class="hdr-ust__sol"><span>Cine.</span>DB</a>
    <div class="hdr-ust__sag">
      <a href="index.php" class="btn-anasayfa">ANASAYFA</a>
      <a href="hakkimda.php" class="btn-hakkimda">HAKKIMDA</a>
      <a href="iletisim.php" class="btn-iletisim aktif">İLETİŞİM</a>
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
  <main class="iletisim-main">

    <section class="iletisim-form">
      <?php if ($mesaj_gonderildi): ?>
        <p style="color: #4CAF50; margin-bottom: 10px;">Mesajınız başarıyla gönderildi 🎉</p>
      <?php endif; ?>
      <h1>İletişim</h1>
      <p>
        Görüş, öneri veya iş birliği için bizimle iletişime geçebilirsiniz 🎬
      </p>

      <form action="iletisim.php" method="post">
        <input type="text" name="isim" placeholder="Ad Soyad" required />
        <input type="email" name="email" placeholder="E-posta Adresi" required />
        <textarea name="mesaj" rows="6" placeholder="Mesajınız..." required></textarea>
        <button type="submit">Gönder</button>
      </form>

      <div class="iletisim-bilgi">
        <p><i class="fa fa-envelope"></i> kokeroguzhan64@gmail.com</p>
        <p><i class="fa fa-phone"></i> +90 (552) 881 04 64</p>
      </div>
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