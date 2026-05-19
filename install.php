<?php
/**
 * One-time database installer for KrishiSheba (XAMPP / MySQL)
 */
$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'krishisheba';
$sqlFile = __DIR__ . '/db.sql';

$messages = [];
$ok = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_GET['auto'])) {
    try {
        $pdoRoot = new PDO("mysql:host={$host};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        if (!file_exists($sqlFile)) {
            throw new RuntimeException('db.sql file not found.');
        }

        $sql = file_get_contents($sqlFile);
        $pdoRoot->exec($sql);

        $pdo = new PDO("mysql:host={$host};dbname={$dbName};charset=utf8mb4", $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ]);

        $today = date('Y-m-d');
        $pdo->exec("UPDATE market_prices SET price_date = '{$today}', updated_at = NOW() WHERE 1=1");

        $messages[] = 'ডাটাবেস সফলভাবে ইনস্টল হয়েছে!';
        $hash = password_hash('password123', PASSWORD_DEFAULT);
        $pdo->prepare('UPDATE users SET password = ?')->execute([$hash]);
        $messages[] = 'ডেমো লগইন: farmer@krishisheba.com / password123';
        $ok = true;
    } catch (Throwable $e) {
        $messages[] = 'ত্রুটি: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ডাটাবেস ইনস্টল - কৃষিসেবা</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body style="padding:40px; max-width:600px; margin:0 auto;">
    <h1><i class="fa-solid fa-database"></i> KrishiSheba ডাটাবেস সেটআপ</h1>
    <?php foreach ($messages as $msg): ?>
        <p style="padding:12px; background:<?= $ok ? '#e8f5e9' : '#ffebee' ?>; border-radius:8px;"><?= htmlspecialchars($msg) ?></p>
    <?php endforeach; ?>
    <?php if ($ok): ?>
        <p><a href="login.php" class="btn btn-primary">লগইন পেজে যান</a>
        <a href="farmer_dashboard.php" class="btn btn-outline">কৃষক ড্যাশবোর্ড</a></p>
    <?php else: ?>
        <p>XAMPP-এ MySQL চালু আছে কিনা নিশ্চিত করুন, তারপর ইনস্টল বাটনে ক্লিক করুন।</p>
        <form method="POST">
            <button type="submit" class="btn btn-primary">ডাটাবেস ইনস্টল করুন</button>
        </form>
    <?php endif; ?>
</body>
</html>
