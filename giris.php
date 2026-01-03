<?php
/*
📁 Bölüm: Auth (Kimlik Doğrulama)
📄 Amaç: Kullanıcı girişi sayfası
🔗 İlişkili: kayit.php, sifre_sifirla.php, config.php
⚙️ Özet: POST ile gelen bilgileri doğrular, başarılıysa oturum başlatır ve yönlendirir
*/
require_once 'config.php';
session_start();

$hata = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $kullanici_adi = trim($_POST['username']);
  $sifre = $_POST['password'];

  if (empty($kullanici_adi) || empty($sifre)) {
    $hata = "Lütfen tüm alanları doldurun.";
  } else {
    // Kullanıcıyı veritabanından çek
    $stmt = $pdo->prepare("SELECT * FROM users WHERE kullanici_adi = ?");
    $stmt->execute([$kullanici_adi]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($sifre, $user['sifre'])) {
      // Giriş başarılı → session başlat
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['kullanici_adi'] = $user['kullanici_adi'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];

      // Anasayfaya yönlendir
      header("Location: index.php");
      exit;
    } else {
      $hata = "Kullanıcı adı veya şifre hatalı.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="tr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="static/css/giris.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet" />
  <title>Giriş Yap</title>
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

  <!-- GİRİŞ EKRANI -->
  <main class="login-container">
    <div class="login-box">
      <h2>Giriş Yap</h2>
      <?php if (!empty($hata)): ?>
        <div class="hata" style="color:#ff4444; margin-bottom:10px;"><?= htmlspecialchars($hata) ?></div>
      <?php endif; ?>
      <form id="loginForm" method="POST" action="">
        <div class="input-group">
          <i class="fa fa-user"></i>
          <input type="text" id="username" name="username" placeholder="Kullanıcı Adı" required />
        </div>

        <div class="input-group">
          <i class="fa fa-lock"></i>
          <input type="password" id="password" name="password" placeholder="Şifre" required />
        </div>

        <button type="submit" class="login-btn">Giriş Yap</button>

        <div class="links">
          <a href="kayit.php">Hesabın yok mu? Kayıt Ol</a>
          <a href="sifre_sifirla.php">Şifremi Unuttum</a>
        </div>
      </form>
    </div>
  </main>

  <!-- INTRO -->
  <div id="intro">
    <div class="intro-logo">
      <span class="intro-text">Cine.<strong>DB</strong></span>
    </div>
  </div>


  <script src="static/js/giris-kayit.js"></script>
</body>

</html>