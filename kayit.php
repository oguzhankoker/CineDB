<?php
/*
📁 Bölüm: Auth (Kimlik Doğrulama)
📄 Amaç: Kullanıcı kayıt sayfası
🔗 İlişkili: giris.php, config.php
⚙️ Özet: Yeni kullanıcı oluşturur, giriş bilgilerini doğrular ve veritabanına kaydeder
*/
require_once 'config.php';
session_start();

$hata = "";
$basari = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $kullanici_adi = trim($_POST['username']);
  $email = trim($_POST['email']);
  $sifre = $_POST['password'];
  $sifre_tekrar = $_POST['password2'];

  // Boş alan kontrolü
  if (empty($kullanici_adi) || empty($email) || empty($sifre) || empty($sifre_tekrar)) {
    $hata = "Lütfen tüm alanları doldurun.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $hata = "Geçerli bir e-posta adresi girin.";
  } elseif ($sifre !== $sifre_tekrar) {
    $hata = "Şifreler eşleşmiyor.";
  } else {
    // Aynı kullanıcı veya mail var mı?
    $kontrol = $pdo->prepare("SELECT * FROM users WHERE kullanici_adi = ? OR email = ?");
    $kontrol->execute([$kullanici_adi, $email]);

    if ($kontrol->rowCount() > 0) {
      $hata = "Bu kullanıcı adı veya e-posta zaten kayıtlı.";
    } else {
      // Şifreyi hashle
      $hashed = password_hash($sifre, PASSWORD_DEFAULT);

      // Veritabanına ekle
      $ekle = $pdo->prepare("INSERT INTO users (kullanici_adi, email, sifre) VALUES (?, ?, ?)");
      $ekle->execute([$kullanici_adi, $email, $hashed]);

      if ($ekle) {
        $basari = "Kayıt başarıyla oluşturuldu! Giriş sayfasına yönlendiriliyorsunuz...";
        header("refresh:2; url=giris.php");
      } else {
        $hata = "Kayıt oluşturulurken bir hata oluştu.";
      }
    }
  }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/kayit.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <title>Kayıt Ol</title>
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

  <!-- KAYIT EKRANI -->
  <main class="register-container">
    <div class="register-box">
      <h2>Kayıt Ol</h2>
      <?php if (!empty($hata)): ?>
        <div class="hata" style="color:#ff4444; margin-bottom:10px;"><?= htmlspecialchars($hata) ?></div>
      <?php elseif (!empty($basari)): ?>
        <div class="basari" style="color:#00c851; margin-bottom:10px;"><?= htmlspecialchars($basari) ?></div>
      <?php endif; ?>

      <form id="registerForm" method="POST" action="">
        <div class="input-group">
          <i class="fa fa-user"></i>
          <input type="text" id="username" name="username" placeholder="Kullanıcı Adı" required />
        </div>

        <div class="input-group">
          <i class="fa fa-envelope"></i>
          <input type="email" id="email" name="email" placeholder="E-posta" required />
        </div>

        <div class="input-group">
          <i class="fa fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="Şifre" required />
        </div>

        <div class="input-group">
          <i class="fa fa-lock"></i>
          <input type="password" id="password2" name="password2" placeholder="Şifre (Tekrar)" required />
        </div>

        <button type="submit" class="register-btn">Kayıt Ol</button>

        <div class="links">
          <a href="giris.php">Zaten hesabın var mı?</a>
          <a href="#">Yardım</a>
        </div>
      </form>
    </div>
  </main>

  <script src="static/js/giris-kayit.js"></script>
</body>

</html>