<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল সেটিংস - কৃষিসেবা | KrishiSheba</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .settings-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
        }
        @media (max-width: 992px) {
            .settings-grid {
                grid-template-columns: 1fr;
            }
        }
        .profile-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: var(--shadow-sm);
        }
        .profile-picture-wrapper {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }
        .profile-picture {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #fff;
            box-shadow: var(--shadow-md);
        }
        .upload-btn {
            position: absolute;
            bottom: 5px;
            right: 5px;
            background: var(--primary-color);
            color: #fff;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            border: 3px solid #fff;
            transition: var(--transition);
        }
        .upload-btn:hover {
            background: var(--primary-dark);
            transform: scale(1.05);
        }
        .settings-form-card {
            background: #fff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: var(--shadow-sm);
        }
        .settings-form-card h3 {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            color: var(--primary-dark);
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
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
            <a href="admin_dashboard.php" class="menu-item">
                <i class="fa-solid fa-chart-line"></i> ড্যাশবোর্ড
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-users"></i> ব্যবহারকারী
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-box-open"></i> পণ্য অনুমোদন
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-cart-shopping"></i> অর্ডার সমূহ
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-seedling"></i> কৃষি উপকরণ
            </a>
            <a href="admin_settings.php" class="menu-item active">
                <i class="fa-solid fa-gear"></i> সেটিংস
            </a>
        </div>
        <div style="padding: 20px; border-top: 1px solid #f0f0f0;">
            <a href="../index.php" class="menu-item" style="padding: 10px; color: #d32f2f;">
                <i class="fa-solid fa-right-from-bracket"></i> লগআউট
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" placeholder="অনুসন্ধান করুন...">
            </div>
            <div class="topbar-right">
                <!-- Notifications -->
                <div class="notification-container" id="notificationBtn" style="position: relative; cursor: pointer;">
                    <button class="icon-btn" style="pointer-events: none;">
                        <i class="fa-regular fa-bell"></i>
                        <span class="badge">৩</span>
                    </button>
                    <!-- Notification Dropdown -->
                    <div class="dropdown-menu" id="notificationDropdown">
                        <div class="dropdown-header">নতুন নোটিফিকেশন (৩)</div>
                        <div class="dropdown-item notification-item">
                            <div class="notification-icon"><i class="fa-solid fa-box"></i></div>
                            <div class="notification-text">
                                <p>নতুন পণ্য অনুমোদনের জন্য অপেক্ষমান</p>
                                <small>৫ মিনিট আগে</small>
                            </div>
                        </div>
                        <div class="dropdown-item notification-item">
                            <div class="notification-icon" style="background: rgba(251, 192, 45, 0.1); color: #f9a825;"><i class="fa-solid fa-user-plus"></i></div>
                            <div class="notification-text">
                                <p>নতুন কৃষক নিবন্ধন করেছেন</p>
                                <small>২ ঘন্টা আগে</small>
                            </div>
                        </div>
                        <div style="text-align: center; padding: 10px;">
                            <a href="#" style="font-size: 0.85rem; font-weight: 600;">সবগুলো দেখুন</a>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="profile-dropdown-container" id="profileBtn" style="position: relative; cursor: pointer;">
                    <div class="profile-dropdown" style="pointer-events: none;">
                        <div style="text-align: right;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.9rem;">সিস্টেম অ্যাডমিন</p>
                            <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">admin@krishisheba.com</p>
                        </div>
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2e7d32&color=fff" alt="Admin">
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem; color: var(--text-muted);"></i>
                    </div>
                    <!-- Profile Dropdown -->
                    <div class="dropdown-menu" id="profileDropdown" style="width: 220px;">
                        <div class="dropdown-header">অ্যাডমিন অপশন</div>
                        <a href="admin_settings.php" class="dropdown-item"><i class="fa-regular fa-user"></i> আমার প্রোফাইল</a>
                        <a href="admin_settings.php" class="dropdown-item"><i class="fa-solid fa-gear"></i> সেটিংস</a>
                        <div style="border-top: 1px solid #f0f0f0; margin-top: 5px; padding-top: 5px;"></div>
                        <a href="../index.php" class="dropdown-item" style="color: #d32f2f;"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <h2 class="page-title">প্রোফাইল সেটিংস</h2>
            
            <div class="settings-grid">
                <!-- Left Column: Profile Picture -->
                <div class="profile-card">
                    <div class="profile-picture-wrapper">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2e7d32&color=fff&size=150" alt="Admin" class="profile-picture">
                        <label for="profileUpload" class="upload-btn" title="ছবি পরিবর্তন করুন">
                            <i class="fa-solid fa-camera"></i>
                        </label>
                        <input type="file" id="profileUpload" style="display: none;" accept="image/*">
                    </div>
                    <h3 style="margin-bottom: 5px;">সিস্টেম অ্যাডমিন</h3>
                    <p style="color: var(--text-muted); margin-bottom: 15px;">প্রধান নিয়ন্ত্রক</p>
                    <span class="status approved" style="display: inline-block;">অ্যাক্টিভ অ্যাকাউন্ট</span>
                </div>

                <!-- Right Column: Settings Form -->
                <div class="settings-form-card">
                    <h3>সাধারণ তথ্য পরিবর্তন</h3>
                    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('প্রোফাইল আপডেট করা হয়েছে!');">
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">পুরো নাম</label>
                                <input type="text" class="form-control" value="সিস্টেম অ্যাডমিন" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">ইমেইল ঠিকানা</label>
                                <input type="email" class="form-control" value="admin@krishisheba.com" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">ফোন নম্বর</label>
                                <input type="tel" class="form-control" value="+8801234567890">
                            </div>
                            <div class="form-group">
                                <label class="form-label">ঠিকানা</label>
                                <input type="text" class="form-control" value="ঢাকা, বাংলাদেশ">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">তথ্য সেভ করুন</button>
                    </form>

                    <h3 style="margin-top: 40px;">পাসওয়ার্ড পরিবর্তন</h3>
                    <form action="#" method="POST" onsubmit="event.preventDefault(); alert('পাসওয়ার্ড পরিবর্তন করা হয়েছে!');">
                        <div class="form-group">
                            <label class="form-label">বর্তমান পাসওয়ার্ড</label>
                            <input type="password" class="form-control" placeholder="বর্তমান পাসওয়ার্ড লিখুন">
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">নতুন পাসওয়ার্ড</label>
                                <input type="password" class="form-control" placeholder="নতুন পাসওয়ার্ড লিখুন">
                            </div>
                            <div class="form-group">
                                <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                                <input type="password" class="form-control" placeholder="আবার নতুন পাসওয়ার্ড লিখুন">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-accent">পাসওয়ার্ড পরিবর্তন করুন</button>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Dropdown Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notifBtn = document.getElementById('notificationBtn');
            const notifDrop = document.getElementById('notificationDropdown');
            const profBtn = document.getElementById('profileBtn');
            const profDrop = document.getElementById('profileDropdown');

            notifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notifDrop.classList.toggle('show');
                profDrop.classList.remove('show');
            });

            profBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                profDrop.classList.toggle('show');
                notifDrop.classList.remove('show');
            });

            document.addEventListener('click', function() {
                notifDrop.classList.remove('show');
                profDrop.classList.remove('show');
            });

            notifDrop.addEventListener('click', function(e) { e.stopPropagation(); });
            profDrop.addEventListener('click', function(e) { e.stopPropagation(); });
            
            // Image upload preview and persist effect
            const profileUpload = document.getElementById('profileUpload');
            const profilePicture = document.querySelector('.profile-picture');
            const topbarAvatar = document.querySelector('.profile-dropdown img');
            
            // Load saved image from localStorage on page load
            const savedImage = localStorage.getItem('krishisheba_admin_avatar');
            if (savedImage) {
                profilePicture.src = savedImage;
                if (topbarAvatar) topbarAvatar.src = savedImage;
            }
            
            profileUpload.addEventListener('change', function(e) {
                if(e.target.files && e.target.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgData = e.target.result;
                        profilePicture.src = imgData;
                        if (topbarAvatar) topbarAvatar.src = imgData;
                        
                        // Save to localStorage so it persists
                        try {
                            localStorage.setItem('krishisheba_admin_avatar', imgData);
                            alert('প্রোফাইল ছবি সফলভাবে আপডেট করা হয়েছে!');
                        } catch (err) {
                            console.warn('Image too large for localStorage');
                        }
                    }
                    reader.readAsDataURL(e.target.files[0]);
                }
            });
        });
    </script>
</body>
</html>

