<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass  = $_POST['password'] ?? '';

    if ($email === '' || $pass === '') {
        $error = 'ইমেইল ও পাসওয়ার্ড দিন।';
    } else {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($pass, $user['password'])) {
            // Fully clear and regenerate session for clean login
            $_SESSION = [];
            session_regenerate_id(true);
            loginUser($user);
            header('Location: ' . dashboardUrlForRole($user['role']));
            exit;
        }
        $error = 'ভুল ইমেইল বা পাসওয়ার্ড।';
    }
}

if (isLoggedIn()) {
    header('Location: ' . dashboardUrlForRole(currentUserRole()));
    exit;
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - কৃষিসেবা | KrishiSheba</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <a href="index.php" style="position:absolute;top:20px;left:20px;font-weight:bold;font-size:1.2rem;">
        <i class="fa-solid fa-arrow-left"></i> ফিরে যান
    </a>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo" style="justify-content:center;margin-bottom:10px;">
                    <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
                </div>
                <h2 class="auth-title">স্বাগতম!</h2>
                <p style="color:var(--text-muted);">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
            </div>

            <?php if ($error): ?>
                <p style="background:#ffebee;color:#c62828;padding:10px;border-radius:6px;margin-bottom:15px;"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <form method="POST" action="login.php">
                <div class="form-group">
                    <label class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" class="form-control" placeholder="farmer@krishisheba.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <p style="font-size:0.8rem;color:#888;margin-bottom:15px;">ডেমো (install.php পর): farmer@krishisheba.com / password123</p>
                <div class="auth-actions">
                    <button type="submit" class="btn btn-primary btn-full">লগইন করুন</button>
                    <div style="text-align:center;margin:10px 0;color:#999;font-size:0.9rem;">অথবা</div>
                    <a href="register.php" class="btn btn-outline btn-full">নতুন ব্যবহারকারী নিবন্ধন</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
