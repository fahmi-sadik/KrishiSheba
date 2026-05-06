<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল সেটিংস - কৃষিসেবা | KrishiSheba</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        .settings-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 20px; }
        .settings-card { background: white; border-radius: 10px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; color: var(--text-dark); font-weight: 500; }
        .form-control { width: 100%; padding: 10px 15px; border: 1px solid #ddd; border-radius: 5px; font-family: 'Hind Siliguri', sans-serif; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .avatar-circle { width: 130px; height: 130px; background-color: #fbc02d; color: #000; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 45px; font-weight: bold; margin: 0 auto 20px auto; position: relative; }
        .camera-icon { position: absolute; bottom: 5px; right: 5px; background: #2e7d32; color: white; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; font-size: 16px; border: 2px solid white; }
        .badge-active { background: #e8f5e9; color: #2e7d32; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem; font-weight: 600; display: inline-block; margin-top: 10px; }
        @media (max-width: 768px) { .settings-grid { grid-template-columns: 1fr; } .form-row { grid-template-columns: 1fr; } }
    </style>
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <a href="buyer_dashboard.php" class="menu-item">
                <i class="fa-solid fa-store"></i>
                তাজা বাজার
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-basket-shopping"></i>
                আমার কার্ট <span class="badge" style="position: static; margin-left: auto;">২</span>
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-clock-rotate-left"></i>
                অর্ডার ইতিহাস
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-heart"></i>
                পছন্দের তালিকা
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-user-doctor"></i>
                বিশেষজ্ঞের পরামর্শ
            </a>
            <!-- সেটিংস এখন অ্যাক্টিভ -->
            <a href="buyer_settings.php" class="menu-item active">
                <i class="fa-solid fa-gear"></i>
                সেটিংস
            </a>
        </div>
        
        <div style="padding: 20px; border-top: 1px solid #f0f0f0;">
            <a href="index.php" class="menu-item" style="padding: 10px; color: #d32f2f;">
                <i class="fa-solid fa-right-from-bracket"></i>
                লগআউট
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" placeholder="সবজি, ফল বা বীজ খুঁজুন...">
            </div>
            
            <div class="topbar-right">
                <!-- Shopping Cart Icon -->
                <button class="icon-btn" style="margin-right: 15px; color: var(--primary-color);">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge" style="background: var(--accent-color); color: #000;">২</span>
                </button>

                <!-- Profile -->
                <div class="profile-dropdown-container" id="profileBtn" style="position: relative; cursor: pointer;">
                    <div class="profile-dropdown" style="pointer-events: none;">
                        <div style="text-align: right;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.9rem;">সাধারণ ক্রেতা</p>
                            <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">buyer@krishisheba.com</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Buyer&background=fbc02d&color=000" alt="Buyer">
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem; color: var(--text-muted);"></i>
                    </div>
                    <!-- Profile Dropdown -->
                    <div class="dropdown-menu" id="profileDropdown" style="width: 220px;">
                        <div class="dropdown-header">অ্যাকাউন্ট অপশন</div>
                        <a href="buyer_settings.php" class="dropdown-item"><i class="fa-regular fa-user"></i> প্রোফাইল</a>
                        <a href="#" class="dropdown-item"><i class="fa-solid fa-location-dot"></i> ডেলিভারি ঠিকানা</a>
                        <div style="border-top: 1px solid #f0f0f0; margin-top: 5px; padding-top: 5px;"></div>
                        <a href="index.php" class="dropdown-item" style="color: #d32f2f;"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <h2 class="page-title" style="margin-bottom: 20px;">প্রোফাইল সেটিংস</h2>
            
            <div class="settings-grid">
                <!-- Left Column: Avatar & Quick Info -->
                <div class="settings-card" style="text-align: center; height: fit-content;">
                    <div class="avatar-circle">
                        BU
                        <div class="camera-icon">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                    </div>
                    <h3 style="font-size: 1.2rem; margin-bottom: 5px;">সাধারণ ক্রেতা</h3>
                    <p style="color: var(--text-muted); font-size: 0.9rem;">নিয়মিত ক্রেতা</p>
                    <span class="badge-active">অ্যাক্টিভ অ্যাকাউন্ট</span>
                </div>

                <!-- Right Column: Forms -->
                <div class="settings-card">
                    <h3 style="color: var(--primary-color); margin-bottom: 20px; font-size: 1.1rem;">সাধারণ তথ্য পরিবর্তন</h3>
                    
                    <form action="#" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label>পুরো নাম</label>
                                <input type="text" class="form-control" value="সাধারণ ক্রেতা">
                            </div>
                            <div class="form-group">
                                <label>ইমেইল ঠিকানা</label>
                                <input type="email" class="form-control" value="buyer@krishisheba.com" readonly style="background: #f9f9f9;">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>ফোন নম্বর</label>
                                <input type="text" class="form-control" value="+8801234567890">
                            </div>
                            <div class="form-group">
                                <label>ঠিকানা</label>
                                <input type="text" class="form-control" value="ঢাকা, বাংলাদেশ">
                            </div>
                        </div>
                        <button type="submit" class="btn" style="background: var(--primary-color); color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px;">তথ্য সেভ করুন</button>
                    </form>

                    <div style="border-top: 1px solid #eee; margin: 30px 0;"></div>

                    <h3 style="color: var(--primary-color); margin-bottom: 20px; font-size: 1.1rem;">পাসওয়ার্ড পরিবর্তন</h3>
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label>বর্তমান পাসওয়ার্ড</label>
                            <input type="password" class="form-control" placeholder="বর্তমান পাসওয়ার্ড লিখুন">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>নতুন পাসওয়ার্ড</label>
                                <input type="password" class="form-control" placeholder="নতুন পাসওয়ার্ড লিখুন">
                            </div>
                            <div class="form-group">
                                <label>পাসওয়ার্ড নিশ্চিত করুন</label>
                                <input type="password" class="form-control" placeholder="আবার নতুন পাসওয়ার্ড লিখুন">
                            </div>
                        </div>
                        <button type="submit" class="btn" style="background: #ffb300; color: #000; font-weight: 600; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-top: 10px;">পাসওয়ার্ড পরিবর্তন করুন</button>
                    </form>
                </div>
            </div>
            
        </div>
    </main>

    <!-- Dropdown Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const profBtn = document.getElementById('profileBtn');
            const profDrop = document.getElementById('profileDropdown');

            profBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profDrop.classList.toggle('show');
            });

            document.addEventListener('click', function() {
                profDrop.classList.remove('show');
            });

            profDrop.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    </script>
</body>
</html>