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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register_submit'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $nid = trim($_POST['nid']);
    $role = $_POST['role'];
    $pass = $_POST['password'];
    $confirm_pass = $_POST['confirm_password'];
    
    // Check if email exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        $message = "এই ইমেইল দিয়ে ইতিমধ্যে একটি অ্যাকাউন্ট রয়েছে!";
        $messageType = "error";
    } elseif ($pass !== $confirm_pass) {
        $message = "পাসওয়ার্ডগুলো মিলছে না!";
        $messageType = "error";
    } else {
        // Handle file upload
        $image_path = '';
        if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == 0) {
            $allowed = ['jpg', 'jpeg', 'png', 'gif'];
            $filename = $_FILES['profile_image']['name'];
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $new_filename = uniqid() . '.' . $ext;
                $destination = '../uploads/' . $new_filename;
                if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $destination)) {
                    $image_path = $new_filename;
                }
            }
        }
        
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        
        try {
            $stmt = $pdo->prepare("INSERT INTO users (name, email, nid, image, role, password) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $email, $nid, $image_path, $role, $hashed_password]);
            
            echo "<script>alert('আপনার নিবন্ধন সফল হয়েছে! এখন লগইন করুন।'); window.location.href='login.php';</script>";
            exit();
        } catch(PDOException $e) {
            $message = "নিবন্ধন ব্যর্থ হয়েছে: " . $e->getMessage();
            $messageType = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নিবন্ধন - কৃষিসেবা | KrishiSheba</title>
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
        <div class="auth-card" style="max-width: 500px;">
            <div class="auth-header">
                <div class="logo" style="justify-content: center; margin-bottom: 10px;">
                    <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
                </div>
                <h2 class="auth-title">নতুন অ্যাকাউন্ট তৈরি করুন</h2>
                <p style="color: var(--text-muted);">কৃষিসেবা পরিবারে আপনাকে স্বাগতম</p>
                <?php if($message): ?>
                    <div style="margin-top:15px; padding: 10px; border-radius: 5px; text-align: center; <?php echo $messageType == 'error' ? 'background: #ffebee; color: #c62828;' : 'background: #e8f5e9; color: #2e7d32;'; ?>">
                        <?php echo $message; ?>
                    </div>
                <?php endif; ?>
            </div>
            
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label class="form-label">আপনার নাম</label>
                    <input type="text" name="name" class="form-control" placeholder="আপনার সম্পূর্ণ নাম লিখুন" required>
                </div>

                <div class="form-group">
                    <label class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" class="form-control" placeholder="example@krishisheba.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">জাতীয় পরিচয়পত্র (NID) নম্বর</label>
                    <input type="text" name="nid" class="form-control" placeholder="আপনার ১০ বা ১৭ ডিজিটের NID নম্বর" required>
                </div>

                <div class="form-group">
                    <label class="form-label">আপনার ছবি</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" required style="padding: 9px 15px;">
                </div>
                
                <div class="form-group">
                    <label class="form-label">অ্যাকাউন্টের ধরন</label>
                    <select name="role" class="form-control" required style="cursor: pointer;">
                        <option value="" disabled selected>নির্বাচন করুন...</option>
                        <option value="farmer">কৃষক (পণ্য বিক্রি করতে চাই)</option>
                        <option value="buyer">ক্রেতা (পণ্য কিনতে চাই)</option>
                        <option value="expert">কৃষি বিশেষজ্ঞ (পরামর্শ দিতে চাই)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <div class="auth-actions">
                    <!-- Register Button -->
                    <button type="submit" name="register_submit" class="btn btn-primary btn-full">নিবন্ধন সম্পূর্ণ করুন</button>
                    
                    <div style="text-align: center; margin: 15px 0; font-size: 0.95rem;">
                        ইতিমধ্যে একটি অ্যাকাউন্ট আছে? 
                        <a href="login.php" style="font-weight: 600; text-decoration: underline;">লগইন করুন</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>

