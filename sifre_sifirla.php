<?php
require_once 'config.php';
date_default_timezone_set('Europe/Istanbul');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Bu e-posta sistemde kayıtlı değil.");
    }

    // Önce eski tokenleri sil
    $pdo->prepare("DELETE FROM password_resets WHERE user_id = ?")
        ->execute([$user['id']]);

    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

    $stmt = $pdo->prepare(
        "INSERT INTO password_resets (user_id, token, expire)
         VALUES (?, ?, ?)"
    );
    $stmt->execute([$user['id'], $token, $expire]);

    $resetLink = "http://localhost/cinedb/sifre_yenile.php?token=$token";

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kokeroguzhan0@gmail.com';
        $mail->Password = 'sctwjnsewsbiljvv';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('kokeroguzhan0@gmail.com', 'CineDB');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Şifre Sıfırlama';
        $mail->Body = "
            Şifrenizi sıfırlamak için linke tıklayın:<br><br>
            <a href='$resetLink'>$resetLink</a><br><br>
            <b>Bu link 1 saat geçerlidir.</b>
        ";

        $mail->send();
        echo "Şifre sıfırlama linki e-posta adresinize gönderildi.";

    } catch (Exception $e) {
        echo "Mail gönderilemedi: {$mail->ErrorInfo}";
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="htmll">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="static/css/sifre-sifirlama.css">
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

    <div class="sifre-page">
        <form method="POST" class="sifre-form">
            <h2>Şifre Sıfırlama</h2>

            <?php if (isset($msg))
                echo "<p class='{$msgClass}'>$msg</p>"; ?>

            <label>E-posta</label>
            <input type="email" name="email" placeholder="Email adresinizi girin" required>

            <button type="submit">Şifre Sıfırlama Linki Gönder</button>
        </form>
    </div>
</body>

</html>