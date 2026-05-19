<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';
require_once __DIR__ . '/includes/crop_advisory_service.php';

requireRole('farmer');

$farmerId = currentUserId();
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$farmerId]);
$farmer = $stmt->fetch();
if (!$farmer) {
    header('Location: login.php');
    exit;
}

refreshDailyMarketPrices($pdo);

$tipsPreview = array_slice(fetchCropAdvisory($pdo, $farmer), 0, 3);
$nearbyPrices = array_slice(fetchMarketPrices($pdo, $farmer, $farmer['crop_type'] ?? null), 0, 5);

$productCount = $pdo->prepare('SELECT COUNT(*) FROM products WHERE farmer_id = ?');
$productCount->execute([$farmerId]);
$totalProducts = (int) $productCount->fetchColumn();

$season = getCurrentSeason();
$activePage = 'dashboard';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>কৃষক ড্যাশবোর্ড - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">
<?php include __DIR__ . '/includes/farmer_sidebar.php'; ?>

<main class="main-content">
    <header class="topbar">
        <h1 class="page-title" style="margin:0;">কৃষক ড্যাশবোর্ড</h1>
        <div class="topbar-right">
            <span><?= htmlspecialchars($farmer['name']) ?></span>
        </div>
    </header>

    <div class="dashboard-content">
        <div style="background:linear-gradient(135deg,var(--primary-color),var(--primary-light));border-radius:15px;padding:30px;color:#fff;margin-bottom:30px;">
            <h2 style="margin:0 0 10px;">স্বাগতম, <?= htmlspecialchars($farmer['name']) ?>!</h2>
            <p style="margin:0;opacity:0.9;">
                <?= htmlspecialchars($farmer['district']) ?> · <?= seasonLabelBn($season) ?> · <?= cropLabelBn($farmer['crop_type'] ?? 'rice') ?>
            </p>
        </div>

        <div class="stats-grid" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:20px;margin-bottom:30px;">
            <div class="stat-card" style="background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <p style="margin:0;color:#666;">আমার পণ্য</p>
                <p style="margin:5px 0 0;font-size:2rem;font-weight:700;color:var(--primary-color);"><?= enToBn($totalProducts) ?></p>
            </div>
            <div class="stat-card" style="background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <p style="margin:0;color:#666;">আজকের পরামর্শ</p>
                <p style="margin:5px 0 0;font-size:2rem;font-weight:700;color:var(--primary-color);"><?= enToBn(count($tipsPreview)) ?>+</p>
            </div>
            <div class="stat-card" style="background:#fff;padding:20px;border-radius:10px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <p style="margin:0;color:#666;">বাজার তালিকা</p>
                <p style="margin:5px 0 0;font-size:2rem;font-weight:700;color:var(--primary-color);"><?= enToBn(count($nearbyPrices)) ?>+</p>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">
            <section style="background:#fff;border-radius:10px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-wheat-awn"></i> ফসল পরামর্শ</h3>
                    <a href="farmer_crop_advisory.php" style="color:var(--primary-color);font-weight:600;">সব দেখুন →</a>
                </div>
                <?php if (empty($tipsPreview)): ?>
                    <p style="color:#666;">পরামর্শ লোড হয়নি। <a href="farmer_settings.php">প্রোফাইল</a> আপডেট করুন।</p>
                <?php else: ?>
                    <?php foreach ($tipsPreview as $tip): ?>
                        <div style="border-bottom:1px solid #eee;padding:12px 0;">
                            <strong><?= htmlspecialchars($tip['title_bn']) ?></strong>
                            <p style="margin:6px 0 0;font-size:0.9rem;color:#555;"><?= htmlspecialchars(mb_substr($tip['tip_bn'], 0, 120, 'UTF-8')) ?>…</p>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>

            <section style="background:#fff;border-radius:10px;padding:24px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                    <h3 style="margin:0;"><i class="fa-solid fa-chart-line"></i> বাজার দর</h3>
                    <a href="farmer_market_prices.php" style="color:var(--primary-color);font-weight:600;">সব দেখুন →</a>
                </div>
                <?php if (empty($nearbyPrices)): ?>
                    <p style="color:#666;">বাজার দর পাওয়া যায়নি।</p>
                <?php else: ?>
                    <?php foreach ($nearbyPrices as $row): ?>
                        <div style="display:flex;justify-content:space-between;border-bottom:1px solid #eee;padding:10px 0;">
                            <span><?= htmlspecialchars($row['crop_name_bn']) ?> <small style="color:#888;">(<?= htmlspecialchars($row['district']) ?>)</small></span>
                            <span style="font-weight:600;"><?= formatPriceBn($row['price_per_unit']) ?> <?= trendIcon($row['trend']) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
    </div>
</main>
</body>
</html>
