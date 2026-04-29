<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ক্রেতা ড্যাশবোর্ড - কৃষিসেবা | KrishiSheba</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
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
                        <a href="#" class="dropdown-item"><i class="fa-regular fa-user"></i> প্রোফাইল</a>
                        <a href="#" class="dropdown-item"><i class="fa-solid fa-location-dot"></i> ডেলিভারি ঠিকানা</a>
                        <div style="border-top: 1px solid #f0f0f0; margin-top: 5px; padding-top: 5px;"></div>
                        <a href="index.php" class="dropdown-item" style="color: #d32f2f;"><i class="fa-solid fa-right-from-bracket"></i> লগআউট</a>
                    </div>
                </div>
            </div>
        </header>

        <!-- Dashboard Content -->
        <div class="dashboard-content">
            
            <!-- Welcome Banner -->
            <div style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-radius: 15px; padding: 30px; color: white; margin-bottom: 30px; box-shadow: var(--shadow-md); display: flex; align-items: center; justify-content: space-between; overflow: hidden; position: relative;">
                <div style="position: relative; z-index: 2; max-width: 60%;">
                    <h2 style="margin-bottom: 10px; font-size: 2rem;">আজকের তাজা সবজি!</h2>
                    <p style="opacity: 0.9; margin-bottom: 20px;">সরাসরি কৃষকের ক্ষেত থেকে আপনার রান্নাঘরে। আজ কিনলে ডেলিভারি ফ্রি!</p>
                    <button class="btn btn-accent" style="border: none;">এখনই কিনুন</button>
                </div>
                <i class="fa-solid fa-basket-wheat" style="font-size: 150px; position: absolute; right: -20px; opacity: 0.2; transform: rotate(-15deg);"></i>
            </div>

            <!-- Categories Filter -->
            <div style="display: flex; gap: 15px; margin-bottom: 25px; overflow-x: auto; padding-bottom: 10px;">
                <button class="btn" style="background: var(--primary-color); color: white;">সব আইটেম</button>
                <button class="btn" style="background: white; color: var(--text-dark); border: 1px solid #ddd;">তাজা সবজি</button>
                <button class="btn" style="background: white; color: var(--text-dark); border: 1px solid #ddd;">মৌসুমি ফল</button>
                <button class="btn" style="background: white; color: var(--text-dark); border: 1px solid #ddd;">শস্য ও ডাল</button>
                <button class="btn" style="background: white; color: var(--text-dark); border: 1px solid #ddd;">বীজ ও সার</button>
            </div>

            <h2 class="page-title" style="margin-bottom: 10px;">জনপ্রিয় পণ্য</h2>

            <!-- Product Grid -->
            <div class="product-grid">
                
                <!-- Product 1 -->
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <span class="product-badge">তাজা</span>
                        <!-- Unsplash placeholder for tomato -->
                        <img src="https://images.unsplash.com/photo-1592924357228-91a4daadcfea?w=500&auto=format&fit=crop&q=60" alt="টমেটো" class="product-img">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">দেশী লাল টমেটো</h3>
                        <div class="product-farmer">
                            <i class="fa-solid fa-user-check"></i> কৃষক: রহিম মিয়া (গাজীপুর)
                        </div>
                        <div class="product-bottom">
                            <div class="product-price">৳ ৪৫ <span>/ কেজি</span></div>
                            <button class="add-to-cart-btn" onclick="alert('পণ্যটি কার্টে যোগ করা হয়েছে!')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 2 -->
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <!-- Unsplash placeholder for Potato -->
                        <img src="https://images.unsplash.com/photo-1518977676601-b53f82aba655?w=500&auto=format&fit=crop&q=60" alt="আলু" class="product-img">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">ডায়মন্ড আলু</h3>
                        <div class="product-farmer">
                            <i class="fa-solid fa-user-check"></i> কৃষক: জলিল শেখ (বগুড়া)
                        </div>
                        <div class="product-bottom">
                            <div class="product-price">৳ ৩০ <span>/ কেজি</span></div>
                            <button class="add-to-cart-btn" onclick="alert('পণ্যটি কার্টে যোগ করা হয়েছে!')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 3 -->
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <span class="product-badge" style="background: #e65100; color: white;">বেস্ট সেলার</span>
                        <!-- Unsplash placeholder for Eggplant -->
                        <img src="https://images.unsplash.com/photo-1601648764658-cf37e8c89b70?w=500&auto=format&fit=crop&q=60" alt="বেগুন" class="product-img">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">ক্যাপসিকাম</h3>
                        <div class="product-farmer">
                            <i class="fa-solid fa-user-check"></i> কৃষক: আবুল কালাম (নরসিংদী)
                        </div>
                        <div class="product-bottom">
                            <div class="product-price">৳ ৫৫০ <span>/ কেজি</span></div>
                            <button class="add-to-cart-btn" onclick="alert('পণ্যটি কার্টে যোগ করা হয়েছে!')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product 4 -->
                <div class="product-card">
                    <div class="product-img-wrapper">
                        <!-- Unsplash placeholder for Mango -->
                        <img src="https://img.magnific.com/premium-photo/ripe-mango-isolated-white-background_38013-3722.jpg?w=2000" alt="আম" class="product-img">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">রাজশাহী ফজলি আম</h3>
                        <div class="product-farmer">
                            <i class="fa-solid fa-user-check"></i> কৃষক: আমজাদ হোসেন (রাজশাহী)
                        </div>
                        <div class="product-bottom">
                            <div class="product-price">৳ ১২০ <span>/ কেজি</span></div>
                            <button class="add-to-cart-btn" onclick="alert('পণ্যটি কার্টে যোগ করা হয়েছে!')">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                    </div>
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
