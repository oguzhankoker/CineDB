<?php
/*
📁 Bölüm: Auth (Kimlik Doğrulama)
📄 Amaç: Kullanıcı çıkış işlemi
🔗 İlişkili: giris.php, profil.php
⚙️ Özet: Oturumu temizler ve kullanıcıyı giriş sayfasına yönlendirir
*/
session_start();          // Oturumu başlat
session_unset();          // Tüm session verilerini temizle
session_destroy();        // Oturumu tamamen sonlandır

header("Location: giris.php");  // Giriş sayfasına yönlendir
exit;
?>