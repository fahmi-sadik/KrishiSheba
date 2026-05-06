<?php
// Session start and database connection
session_start();

// Database configuration
$host = 'localhost';
$dbname = 'krishisheba'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'buyer') {
    header("Location: ../auth/login.php");
    exit();
}
$buyer_id = $_SESSION['user_id'];

$message = '';

// ১. প্রোফাইল ছবি আপলোড লজিক
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES['profile_image'])) {
    $target_dir = "../uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = $_FILES['profile_image']['name'];
    $file_tmp = $_FILES['profile_image']['tmp_name'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $extensions = array("jpeg", "jpg", "png");

    if (in_array($file_ext, $extensions)) {
        $new_filename = "user_" . $buyer_id . "_" . time() . "." . $file_ext;
        if (move_uploaded_file($file_tmp, $target_dir . $new_filename)) {
            $stmt = $pdo->prepare("UPDATE users SET image = ? WHERE id = ?");
            $stmt->execute([$new_filename, $buyer_id]);
            $message = "<div class='success-msg' style='color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight:bold;'><i class='fa-solid fa-check-circle'></i> প্রোফাইল ছবি আপডেট হয়েছে!</div>";
        }
    }
}

// ২. প্রোফাইল তথ্য আপডেট লজিক
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_profile'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET name = ?, phone = ?, address = ? WHERE id = ?");
        if($stmt->execute([$name, $phone, $address, $buyer_id])) {
            $message = "<div class='success-msg' style='color: #2e7d32; background: #e8f5e9; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-weight:bold;'><i class='fa-solid fa-check-circle'></i> প্রোফাইল সফলভাবে আপডেট হয়েছে!</div>";
        }
    } catch(PDOException $e) {
        $message = "<div class='error-msg' style='color: red;'>আপডেট ব্যর্থ হয়েছে।</div>";
    }
}

// ইউজারের তথ্য আনা
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$buyer_id]);
$buyer = $stmt->fetch(PDO::FETCH_ASSOC);

function getInitials($name) {
    $words = explode(" ", $name);
    $initials = "";
    foreach ($words as $w) { $initials .= mb_substr($w, 0, 1, 'UTF-8'); }
    return mb_strtoupper(mb_substr($initials, 0, 2, 'UTF-8'), 'UTF-8');
}
$avatarText = getInitials($buyer['name'] ?: 'ক্রেতা');
?>

<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল সেটিংস - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; }
        .settings-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .form-control { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; margin-top: 5px; box-sizing: border-box; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 15px; }
        .avatar-circle { width: 130px; height: 130px; background-color: #fbc02d; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 45px; font-weight: bold; margin: 0 auto 20px; position: relative; }
        .avatar-circle img { width: 100%; height: 100%; border-radius: 50%; object-fit: cover; }
        .camera-icon { position: absolute; bottom: 5px; right: 5px; background: #2e7d32; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; border: 2px solid white; }
    </style>
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="sidebar" style="display: flex; flex-direction: column; height: 100vh; position: fixed;">
        <div class="sidebar-header">
            <div class="logo"><i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span></div>
        </div>
        <div class="sidebar-menu" style="flex-grow: 1;">
            <a href="buyer_dashboard.php" class="menu-item"><i class="fa-solid fa-store"></i> তাজা বাজার</a>
            <a href="buyer_cart.php" class="menu-item"><i class="fa-solid fa-basket-shopping"></i> আমার কার্ট</a>
            <a href="#" class="menu-item"><i class="fa-solid fa-clock-rotate-left"></i> অর্ডার ইতিহাস</a>
            <a href="#" class="menu-item"><i class="fa-solid fa-heart"></i> পছন্দের তালিকা</a>
            <a href="buyer_settings.php" class="menu-item active"><i class="fa-solid fa-gear"></i> সেটিংস</a>
        </div>
        <!-- Logout Fixed at Bottom -->
        <div style="padding: 20px; border-top: 1px solid #f0f0f0;">
            <a href="../index.php" class="menu-item" style="color: #d32f2f; text-decoration: none; font-weight: bold;">
                <i class="fa-solid fa-right-from-bracket"></i> লগআউট
            </a>
        </div>
    </aside>

    <main class="main-content" style="margin-left: 260px;">
        <header class="topbar">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="খুঁজুন...">
            </div>
        </header>

        <div class="dashboard-content">
            <h2 style="margin-bottom: 20px;">প্রোফাইল সেটিংস</h2>
            <?php echo $message; ?>

            <div class="settings-grid">
                <div class="settings-card" style="text-align: center;">
                    <form action="buyer_settings.php" method="POST" enctype="multipart/form-data" id="imgForm">
                        <div class="avatar-circle">
                            <?php if(!empty($buyer['image'])): ?>
                                <img src="../uploads/<?php echo $buyer['image']; ?>">
                            <?php else: echo $avatarText; endif; ?>
                            <label for="profile_image" class="camera-icon">
                                <i class="fa-solid fa-camera"></i>
                                <input type="file" name="profile_image" id="profile_image" style="display:none;" onchange="document.getElementById('imgForm').submit();">
                            </label>
                        </div>
                    </form>
                    <h3><?php echo htmlspecialchars($buyer['name']); ?></h3>
                    <p style="color: #666;">নিয়মিত ক্রেতা</p>
                </div>

                <div class="settings-card">
                    <form action="buyer_settings.php" method="POST">
                        <div class="form-row">
                            <div><label>নাম</label><input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($buyer['name']); ?>"></div>
                            <div><label>ইমেইল</label><input type="text" class="form-control" value="<?php echo htmlspecialchars($buyer['email']); ?>" readonly style="background:#f5f5f5;"></div>
                        </div>
                        <div class="form-row">
                            <div><label>ফোন</label><input type="text" name="phone" class="form-control" value="<?php echo htmlspecialchars($buyer['phone'] ?? ''); ?>"></div>
                            <div><label>ঠিকানা</label><input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($buyer['address'] ?? ''); ?>"></div>
                        </div>
                        <button type="submit" name="update_profile" class="btn" style="background:#2e7d32; color:white; border:none; padding:10px 20px; border-radius:5px; cursor:pointer;">তথ্য সেভ করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
