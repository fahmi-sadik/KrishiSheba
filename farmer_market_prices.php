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

$filterCrop     = $_GET['crop'] ?? 'all';
$filterDistrict = $_GET['district'] ?? '';

$prices = fetchMarketPrices(
    $pdo,
    $farmer,
    $filterCrop !== 'all' ? $filterCrop : null,
    $filterDistrict !== '' ? $filterDistrict : null
);

$crops = ['all', 'rice', 'tomato', 'potato', 'wheat', 'mango', 'brinjal', 'onion'];
$districts = ['', 'ঢাকা', 'গাজীপুর', 'রাজশাহী', 'বগুড়া', 'রংপুর', 'খুলনা', 'চট্টগ্রাম', 'সিলেট', 'বরিশাল', 'ময়মনসিংহ', 'পাবনা', 'নরসিংদী', 'টাঙ্গাইল'];

$priceDate = !empty($prices[0]['price_date']) ? $prices[0]['price_date'] : date('Y-m-d');
$activePage = 'prices';

$bestSell = [];
foreach ($prices as $row) {
    $slug = $row['crop_slug'];
    if (!isset($bestSell[$slug]) || (float) $row['price_per_unit'] > (float) $bestSell[$slug]['price_per_unit']) {
        $bestSell[$slug] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বাজার দর - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .price-banner { background: linear-gradient(135deg, #1565c0, #42a5f5); color: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .insight-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px; }
        .insight-card { background: #fff; border-radius: 10px; padding: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .price-table { width: 100%; border-collapse: collapse; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
        .price-table th, .price-table td { padding: 14px 16px; text-align: left; border-bottom: 1px solid #eee; }
        .price-table th { background: #f5f5f5; font-weight: 600; }
        .price-table tr:hover { background: #fafafa; }
        .filter-bar { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; }
        .filter-bar select { padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px; }
    </style>
</head>
<body class="dashboard-body">
<?php include __DIR__ . '/includes/farmer_sidebar.php'; ?>

<main class="main-content">
    <header class="topbar">
        <h1 class="page-title" style="margin:0;">বাজার মূল্য</h1>
        <div class="topbar-right">
            <span style="font-size:0.9rem;color:var(--text-muted);">
                <i class="fa-solid fa-calendar-day"></i> আপডেট: <?= enToBn(date('d/m/Y', strtotime($priceDate))) ?>
            </span>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="price-banner">
            <h2 style="margin:0 0 8px;">আপনার এলাকার কাছাকাছি বাজার</h2>
            <p style="margin:0;opacity:0.95;">
                আপনার জেলা: <strong><?= htmlspecialchars($farmer['district']) ?></strong> —
                নিকটবর্তী বাজারের দৈনিক দর দেখে সঠিক সময় ও স্থানে বিক্রি করুন।
            </p>
        </div>

        <?php if (!empty($bestSell)): ?>
        <h3 style="margin-bottom:12px;">সেরা দর (ফসল অনুযায়ী)</h3>
        <div class="insight-grid">
            <?php foreach ($bestSell as $row): ?>
            <div class="insight-card">
                <p style="margin:0 0 4px;font-weight:600;"><?= htmlspecialchars($row['crop_name_bn']) ?></p>
                <p style="margin:0;font-size:1.4rem;color:var(--primary-color);"><?= formatPriceBn($row['price_per_unit']) ?> <small>/ <?= htmlspecialchars($row['unit']) ?></small></p>
                <p style="margin:8px 0 0;font-size:0.85rem;color:#666;">
                    <?= trendIcon($row['trend']) ?> <?= trendLabelBn($row['trend']) ?>
                    · <?= htmlspecialchars($row['market_name_bn']) ?>, <?= htmlspecialchars($row['district']) ?>
                </p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form method="get" class="filter-bar">
            <select name="crop" onchange="this.form.submit()">
                <?php foreach ($crops as $c): ?>
                    <option value="<?= $c ?>" <?= $filterCrop === $c ? 'selected' : '' ?>>
                        <?= $c === 'all' ? 'সব ফসল' : cropLabelBn($c) ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="district" onchange="this.form.submit()">
                <option value="">নিকটবর্তী বাজার (ডিফল্ট)</option>
                <?php foreach ($districts as $d): if ($d === '') continue; ?>
                    <option value="<?= htmlspecialchars($d) ?>" <?= $filterDistrict === $d ? 'selected' : '' ?>><?= htmlspecialchars($d) ?></option>
                <?php endforeach; ?>
            </select>
        </form>

        <?php if (empty($prices)): ?>
            <p style="text-align:center;padding:40px;color:#666;">কোনো বাজার দর পাওয়া যায়নি। <a href="install.php">install.php</a> চালিয়ে ডাটা লোড করুন।</p>
        <?php else: ?>
        <table class="price-table">
            <thead>
                <tr>
                    <th>ফসল</th>
                    <th>বাজার</th>
                    <th>জেলা</th>
                    <th>দর</th>
                    <th>প্রবণতা</th>
                    <th>গত দর</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($prices as $row): ?>
                <tr>
                    <td><strong><?= htmlspecialchars($row['crop_name_bn']) ?></strong></td>
                    <td><?= htmlspecialchars($row['market_name_bn']) ?></td>
                    <td><?= htmlspecialchars($row['district']) ?></td>
                    <td><?= formatPriceBn($row['price_per_unit']) ?> / <?= htmlspecialchars($row['unit']) ?></td>
                    <td><?= trendIcon($row['trend']) ?> <?= trendLabelBn($row['trend']) ?></td>
                    <td><?= $row['previous_price'] ? formatPriceBn($row['previous_price']) : '—' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
