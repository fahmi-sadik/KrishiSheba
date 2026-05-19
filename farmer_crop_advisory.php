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

$filterCrop     = isset($_GET['crop']) ? $_GET['crop'] : 'profile';
$filterActivity = $_GET['activity'] ?? 'all';

$crops = ['rice', 'wheat', 'potato', 'tomato', 'brinjal', 'onion', 'mango', 'jute', 'mustard', 'lentil'];
$activities = ['all', 'sowing', 'irrigation', 'fertilizer', 'pest_control', 'harvest', 'general'];

$effectiveCrop = ($filterCrop === 'profile' || $filterCrop === '') ? null : $filterCrop;
$tips = fetchCropAdvisory(
    $pdo,
    $farmer,
    $effectiveCrop,
    $filterActivity === 'all' ? null : $filterActivity
);

$season = getCurrentSeason();
$activePage = 'advisory';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ফসল পরামর্শ - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .advisory-banner { background: linear-gradient(135deg, #2e7d32, #66bb6a); color: #fff; border-radius: 12px; padding: 24px; margin-bottom: 24px; }
        .filter-bar { display: flex; flex-wrap: wrap; gap: 12px; margin-bottom: 20px; align-items: flex-end; }
        .filter-bar select { padding: 10px 14px; border: 1px solid #ddd; border-radius: 8px; min-width: 160px; }
        .tip-card { background: #fff; border-radius: 10px; padding: 20px; margin-bottom: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border-left: 4px solid var(--primary-color); }
        .tip-meta { display: flex; flex-wrap: wrap; gap: 8px; margin-bottom: 10px; }
        .tip-tag { font-size: 0.75rem; background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; }
        .empty-state { text-align: center; padding: 40px; color: #666; }
    </style>
</head>
<body class="dashboard-body">
<?php include __DIR__ . '/includes/farmer_sidebar.php'; ?>

<main class="main-content">
    <header class="topbar">
        <h1 class="page-title" style="margin:0;">ফসল পরামর্শ</h1>
        <div class="topbar-right">
            <span style="color:var(--text-muted);"><?= htmlspecialchars($farmer['name']) ?> · <?= htmlspecialchars($farmer['district']) ?></span>
        </div>
    </header>

    <div class="dashboard-content">
        <div class="advisory-banner">
            <h2 style="margin:0 0 8px;">আপনার জন্য 맞োখিত পরামর্শ</h2>
            <p style="margin:0;opacity:0.95;">
                অবস্থান: <strong><?= htmlspecialchars($farmer['district']) ?></strong>
                <?php if (!empty($farmer['upazila'])): ?> (<?= htmlspecialchars($farmer['upazila']) ?>)<?php endif; ?>
                · মৌসুম: <strong><?= seasonLabelBn($season) ?></strong>
                · প্রধান ফসল: <strong><?= cropLabelBn($farmer['crop_type'] ?? 'rice') ?></strong>
            </p>
        </div>

        <form method="get" class="filter-bar">
            <div>
                <label class="form-label">ফসল</label>
                <select name="crop" onchange="this.form.submit()">
                    <option value="profile" <?= $filterCrop === 'profile' ? 'selected' : '' ?>>প্রোফাইল অনুযায়ী (<?= cropLabelBn($farmer['crop_type'] ?? 'rice') ?>)</option>
                    <?php foreach ($crops as $c): ?>
                        <option value="<?= $c ?>" <?= $filterCrop === $c ? 'selected' : '' ?>><?= cropLabelBn($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label">কার্যক্রম</label>
                <select name="activity" onchange="this.form.submit()">
                    <?php foreach ($activities as $a): ?>
                        <option value="<?= $a ?>" <?= $filterActivity === $a ? 'selected' : '' ?>><?= $a === 'all' ? 'সব' : activityLabelBn($a) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </form>

        <?php if (empty($tips)): ?>
            <div class="empty-state">
                <i class="fa-solid fa-seedling fa-3x" style="color:#ccc;margin-bottom:16px;"></i>
                <p>এই ফিল্টারে কোনো পরামর্শ পাওয়া যায়নি। <a href="farmer_settings.php">সেটিংস</a> থেকে জেলা ও ফসল আপডেট করুন।</p>
            </div>
        <?php else: ?>
            <p style="color:var(--text-muted);margin-bottom:16px;">মোট <?= enToBn(count($tips)) ?>টি পরামর্শ পাওয়া গেছে</p>
            <?php foreach ($tips as $tip): ?>
                <article class="tip-card">
                    <div class="tip-meta">
                        <span class="tip-tag"><i class="fa-solid fa-wheat-awn"></i> <?= cropLabelBn($tip['crop_type']) ?></span>
                        <span class="tip-tag"><i class="fa-solid fa-cloud-sun"></i> <?= seasonLabelBn($tip['season']) ?></span>
                        <span class="tip-tag"><i class="fa-solid fa-location-dot"></i> <?= $tip['district'] === 'all' ? 'সারা দেশ' : htmlspecialchars($tip['district']) ?></span>
                        <span class="tip-tag"><i class="fa-solid fa-list-check"></i> <?= activityLabelBn($tip['activity_type']) ?></span>
                    </div>
                    <h3 style="margin:0 0 10px;color:var(--primary-color);"><?= htmlspecialchars($tip['title_bn']) ?></h3>
                    <p style="margin:0;line-height:1.7;"><?= nl2br(htmlspecialchars($tip['tip_bn'])) ?></p>
                </article>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</main>
</body>
</html>
