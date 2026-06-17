<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/helpers.php';

requireRole('farmer');

$farmerId = currentUserId();
$message = '';

$districts = ['ঢাকা', 'গাজীপুর', 'রাজশাহী', 'খুলনা', 'চট্টগ্রাম', 'সিলেট', 'রংপুর', 'বরিশাল', 'ময়মনসিংহ', 'বগুড়া', 'টাঙ্গাইল', 'নরসিংদী', 'পাবনা'];
$crops = ['rice', 'wheat', 'potato', 'tomato', 'brinjal', 'onion', 'mango', 'jute', 'mustard', 'lentil'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $name     = trim($_POST['name'] ?? '');
    $phone    = trim($_POST['phone'] ?? '');
    $address  = trim($_POST['address'] ?? '');
    $district = trim($_POST['district'] ?? 'ঢাকা');
    $upazila  = trim($_POST['upazila'] ?? '');
    $crop     = trim($_POST['crop_type'] ?? 'rice');

    if ($name !== '') {
        $stmt = $pdo->prepare('UPDATE users SET name=?, phone=?, address=?, district=?, upazila=?, crop_type=? WHERE id=?');
        if ($stmt->execute([$name, $phone, $address, $district, $upazila, $crop, $farmerId])) {
            $_SESSION['user_name'] = $name;
            $message = '<div class="success-msg" style="color:#2e7d32;background:#e8f5e9;padding:10px;border-radius:5px;margin-bottom:15px;"><i class="fa-solid fa-check-circle"></i> প্রোফাইল আপডেট হয়েছে!</div>';
        }
    }
}

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$farmerId]);
$farmer = $stmt->fetch();
$activePage = 'settings';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>কৃষক সেটিংস - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-card { background:#fff;border-radius:10px;padding:30px;box-shadow:0 2px 10px rgba(0,0,0,0.05);max-width:700px; }
        .form-control { width:100%;padding:10px;border:1px solid #ddd;border-radius:5px;margin-top:5px;box-sizing:border-box; }
        .form-group { margin-bottom:16px; }
        .form-label { font-weight:600;display:block;margin-bottom:4px; }
    </style>
</head>
<body class="dashboard-body">
<?php include __DIR__ . '/includes/farmer_sidebar.php'; ?>

<main class="main-content">
    <header class="topbar"><h1 class="page-title" style="margin:0;">সেটিংস</h1></header>
    <div class="dashboard-content">
        <p style="color:#666;margin-bottom:20px;">জেলা, উপজেলা ও প্রধান ফসল সেট করলে <strong>ফসল পরামর্শ</strong> ও <strong>বাজার দর</strong> আপনার জন্য উপযুক্ত হবে।</p>
        <?= $message ?>
        <div class="settings-card">
            <form method="POST">
                <input type="hidden" name="update_profile" value="1">
                <div class="form-group">
                    <label class="form-label">নাম</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($farmer['name'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">ফোন</label>
                    <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($farmer['phone'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">ঠিকানা</label>
                    <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($farmer['address'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">জেলা (অবস্থান)</label>
                    <select name="district" class="form-control" required>
                        <?php foreach ($districts as $d): ?>
                            <option value="<?= htmlspecialchars($d) ?>" <?= ($farmer['district'] ?? '') === $d ? 'selected' : '' ?>><?= htmlspecialchars($d) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">উপজেলা</label>
                    <input type="text" name="upazila" class="form-control" value="<?= htmlspecialchars($farmer['upazila'] ?? '') ?>">
                </div>
                <div class="form-group">
                    <label class="form-label">প্রধান ফসল</label>
                    <select name="crop_type" class="form-control" required>
                        <?php foreach ($crops as $c): ?>
                            <option value="<?= $c ?>" <?= ($farmer['crop_type'] ?? 'rice') === $c ? 'selected' : '' ?>><?= cropLabelBn($c) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">সংরক্ষণ করুন</button>
            </form>
        </div>
    </div>
</main>
</body>
</html>
