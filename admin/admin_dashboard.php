<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন ড্যাশবোর্ড - কৃষিসেবা | KrishiSheba</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            <a href="#" class="menu-item active">
                <i class="fa-solid fa-chart-line"></i>
                ড্যাশবোর্ড
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-users"></i>
                ব্যবহারকারী
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-box-open"></i>
                পণ্য অনুমোদন
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-cart-shopping"></i>
                অর্ডার সমূহ
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-seedling"></i>
                কৃষি উপকরণ
            </a>
            <a href="admin_settings.php" class="menu-item">
                <i class="fa-solid fa-gear"></i>
                সেটিংস
            </a>
        </div>
        
        <div style="padding: 20px; border-top: 1px solid #f0f0f0;">
            <a href="../index.php" class="menu-item" style="padding: 10px; color: #d32f2f;">
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
                        <div class="dropdown-item notification-item">
                            <div class="notification-icon" style="background: rgba(211, 47, 47, 0.1); color: #d32f2f;"><i class="fa-solid fa-circle-exclamation"></i></div>
                            <div class="notification-text">
                                <p>একটি নতুন অভিযোগ জমা হয়েছে</p>
                                <small>১ দিন আগে</small>
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
                        <!-- Using a generic placeholder image for admin avatar -->
                        <img src="https://ui-avatars.com/api/?name=Admin&background=2e7d32&color=fff" alt="Admin">
                        <i class="fa-solid fa-chevron-down" style="font-size: 0.8rem; color: var(--text-muted);"></i>
                    </div>
                    <!-- Profile Dropdown -->
                    <div class="dropdown-menu" id="profileDropdown" style="width: 220px;">
                        <div class="dropdown-header">অ্যাডমিন অপশন</div>
                        <a href="admin_settings.php" class="dropdown-item"><i class="fa-regular fa-user"></i> আমার প্রোফাইল</a>
                        <a href="admin_settings.php" class="dropdown-item"><i class="fa-solid fa-gear"></i> সেটিংস</a>
                        <a href="#" class="dropdown-item"><i class="fa-solid fa-shield-halved"></i> নিরাপত্তা</a>
                        <div style="border-top: 1px solid #f0f0f0; margin-top: 5px; padding-top: 5px;"></div>
                        <a href="../index.php" class="dropdown-item" style="color: #d32f2f;"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            <h2 class="page-title">ওভারভিউ</h2>
            
            <!-- Statistics Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>১,২৪৫</h3>
                        <p>মোট ব্যবহারকারী</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <h3>১৮</h3>
                        <p>অপেক্ষমান পণ্য</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="stat-info">
                        <h3>৳ ৮৫,২০০</h3>
                        <p>আজকের বিক্রি</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon red">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <div class="stat-info">
                        <h3>৫</h3>
                        <p>নতুন অভিযোগ</p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Table -->
            <div class="data-card">
                <div class="data-card-header">
                    <h3>অপেক্ষমান পণ্য (অনুমোদনের জন্য)</h3>
                    <a href="#" class="btn btn-outline" style="padding: 8px 15px; font-size: 0.9rem;">সব দেখুন</a>
                </div>
                
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>পণ্যের নাম</th>
                                <th>কৃষকের নাম</th>
                                <th>মূল্য (টাকা)</th>
                                <th>তারিখ</th>
                                <th>স্ট্যাটাস</th>
                                <th>অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><i class="fa-solid fa-carrot" style="color: #e65100; margin-right: 8px;"></i> দেশী গাজর</td>
                                <td>রহিম মিয়া</td>
                                <td>৪০ / কেজি</td>
                                <td>২৮ এপ্রিল, ২০২৬</td>
                                <td><span class="status pending">অপেক্ষমান</span></td>
                                <td>
                                    <button class="action-btn approve" title="অনুমোদন করুন"><i class="fa-solid fa-check-circle"></i></button>
                                    <button class="action-btn reject" title="বাতিল করুন"><i class="fa-solid fa-times-circle"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-apple-whole" style="color: #d32f2f; margin-right: 8px;"></i> তাজা টমেটো</td>
                                <td>করিম শেখ</td>
                                <td>৩০ / কেজি</td>
                                <td>২৮ এপ্রিল, ২০২৬</td>
                                <td><span class="status pending">অপেক্ষমান</span></td>
                                <td>
                                    <button class="action-btn approve" title="অনুমোদন করুন"><i class="fa-solid fa-check-circle"></i></button>
                                    <button class="action-btn reject" title="বাতিল করুন"><i class="fa-solid fa-times-circle"></i></button>
                                </td>
                            </tr>
                            <tr>
                                <td><i class="fa-solid fa-leaf" style="color: #2e7d32; margin-right: 8px;"></i> লাল শাক</td>
                                <td>আব্দুল হালিম</td>
                                <td>১৫ / আঁটি</td>
                                <td>২৭ এপ্রিল, ২০২৬</td>
                                <td><span class="status pending">অপেক্ষমান</span></td>
                                <td>
                                    <button class="action-btn approve" title="অনুমোদন করুন"><i class="fa-solid fa-check-circle"></i></button>
                                    <button class="action-btn reject" title="বাতিল করুন"><i class="fa-solid fa-times-circle"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
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

            // Close dropdowns when clicking outside
            document.addEventListener('click', function() {
                notifDrop.classList.remove('show');
                profDrop.classList.remove('show');
            });

            // Prevent closing when clicking inside dropdown
            notifDrop.addEventListener('click', function(e) {
                e.stopPropagation();
            });
            profDrop.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            // Load saved avatar from localStorage
            const savedImage = localStorage.getItem('krishisheba_admin_avatar');
            const topbarAvatar = document.querySelector('.profile-dropdown img');
            if (savedImage && topbarAvatar) {
                topbarAvatar.src = savedImage;
            }
        });
    </script>
</body>
</html>

