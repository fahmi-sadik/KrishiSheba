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
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Back to home button floating -->
    <a href="index.php" style="position: absolute; top: 20px; left: 20px; font-weight: bold; font-size: 1.2rem;">
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
            </div>
            
            <form action="login.php" method="POST">
                <div class="form-group">
                    <label class="form-label">আপনার নাম</label>
                    <input type="text" class="form-control" placeholder="আপনার সম্পূর্ণ নাম লিখুন" required>
                </div>

                <div class="form-group">
                    <label class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" class="form-control" placeholder="example@krishisheba.com" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label">জাতীয় পরিচয়পত্র (NID) নম্বর</label>
                    <input type="number" class="form-control" placeholder="আপনার ১০ বা ১৭ ডিজিটের NID নম্বর" required>
                </div>

                <div class="form-group">
                    <label class="form-label">আপনার ছবি</label>
                    <input type="file" class="form-control" accept="image/*" required style="padding: 9px 15px;">
                </div>
                
                <div class="form-group">
                    <label class="form-label">অ্যাকাউন্টের ধরন</label>
                    <select class="form-control" required style="cursor: pointer;">
                        <option value="" disabled selected>নির্বাচন করুন...</option>
                        <option value="farmer">কৃষক (পণ্য বিক্রি করতে চাই)</option>
                        <option value="buyer">ক্রেতা (পণ্য কিনতে চাই)</option>
                        <option value="expert">কৃষি বিশেষজ্ঞ (পরামর্শ দিতে চাই)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" class="form-control" placeholder="••••••••" required>
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <input type="password" class="form-control" placeholder="••••••••" required>
                </div>
                
                <div class="auth-actions">
                    <!-- Register Button -->
                    <button type="submit" class="btn btn-primary btn-full">নিবন্ধন সম্পূর্ণ করুন</button>
                    
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
