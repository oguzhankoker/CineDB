<?php
require_once 'config.php';
date_default_timezone_set('Europe/Istanbul');

$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare(
    "SELECT * FROM password_resets
     WHERE token = ? AND expire >= NOW()"
);
$stmt->execute([$token]);
$reset = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$reset) {
    die("Token geçersiz veya süresi dolmuş.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare(
        "UPDATE users SET sifre = ? WHERE id = ?"
    );
    $stmt->execute([$password, $reset['user_id']]);


    $pdo->prepare("DELETE FROM password_resets WHERE id = ?")
        ->execute([$reset['id']]);

    echo "Şifreniz başarıyla değiştirildi.
    <br><a href='giris.php'>Giriş Yap</a>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

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
            <h2>Yeni Şifre Belirle</h2>

            <?php if (isset($msg))
                echo "<p class='{$msgClass}'>$msg</p>"; ?>

            <label>Yeni Şifre</label>
            <input type="password" name="password" placeholder="Yeni şifrenizi girin" required>

            <button type="submit">Şifreyi Güncelle</button>
        </form>
    </div>
</body>

</html>