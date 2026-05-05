<?php
session_start();

$host = 'localhost';
$dbname = 'krishisheba';
$username = 'root';
$password = '';

$message = '';
$messageType = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database Connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login_submit'])) {
    $email = trim($_POST['email']);
    $pass = $_POST['password'];
    $role = $_POST['role'];
    
    try {
        $stmt = $pdo->prepare("SELECT id, name, role, password, image FROM users WHERE email = ? AND role = ?");
        $stmt->execute([$email, $role]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($pass, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_image'] = $user['image'];
            
            // Redirect based on role
            if ($role === 'admin') {
                header("Location: ../admin/admin_dashboard.php");
                exit();
            } elseif ($role === 'buyer') {
                header("Location: ../buyer/buyer_dashboard.php");
                exit();
            } elseif ($role === 'farmer') {
                echo "<script>alert('কৃষক ড্যাশবোর্ড এখনও তৈরি করা হয়নি। (Farmer dashboard pending)'); window.location.href='login.php';</script>";
                exit();
            }
        } else {
            $message = "ভুল ইমেইল বা পাসওয়ার্ড!";
            $messageType = "error";
        }
    } catch(PDOException $e) {
        $message = "লগইন ব্যর্থ হয়েছে: " . $e->getMessage();
        $messageType = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - কৃষিসেবা | KrishiSheba</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Back to home button floating -->
    <a href="../index.php" style="position: absolute; top: 20px; left: 20px; font-weight: bold; font-size: 1.2rem;">
        <i class="fa-solid fa-arrow-left"></i> ফিরে যান
    </a>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo" style="justify-content: center; margin-bottom: 10px;">
                    <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
                </div>
                <h2 class="auth-title">স্বাগতম!</h2>
                <p style="color: var(--text-muted);">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
                <?php if($message): ?>
                    <div style="margin-top:15px; padding: 10px; border-radius: 5px; text-align: center; <?php echo $messageType == 'error' ? 'background: #ffebee; color: #c62828;' : 'background: #e8f5e9; color: #2e7d32;'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <form action="" method="POST">
                <div class="form-group">
                    <label class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" class="form-control" placeholder="example@krishisheba.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">লগইন ধরন</label>
                    <select name="role" class="form-control" style="cursor: pointer;" required>
                        <option value="admin">অ্যাডমিন (Admin)</option>
                        <option value="buyer">ক্রেতা (Buyer)</option>
                        <option value="farmer">কৃষক (Farmer)</option>
                    </select>
                </div>
                
                <div class="auth-actions">
                    <!-- Login Button -->
                    <button type="submit" name="login_submit" class="btn btn-primary btn-full">লগইন করুন</button>
                    
                    <div style="text-align: center; margin: 10px 0; color: #999; font-size: 0.9rem;">অথবা</div>
                    
                    <!-- Registration Button -->
                    <a href="register.php" class="btn btn-outline btn-full">
                        নতুন ব্যবহারকারী নিবন্ধন
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>

