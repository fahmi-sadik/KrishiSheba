<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ক্রেতা ড্যাশবোর্ড - কৃষিসেবা | KrishiSheba</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .product-card { transition: all 0.3s ease; }
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
            <a href="{{ route('buyer.dashboard') }}" class="menu-item active">
                <i class="fa-solid fa-store"></i> তাজা বাজার
            </a>
            <a href="{{ route('buyer.cart') }}" class="menu-item">
                <i class="fa-solid fa-basket-shopping"></i> আমার কার্ট
                <span class="badge" style="position: static; margin-left: auto;">{{ collect($cartCount)->first() ?? 0 }}</span>
            </a>
            <a href="{{ route('profile.settings') }}" class="menu-item">
                <i class="fa-solid fa-user-cog"></i> প্রোফাইল সেটিংস
            </a>
        </div>
        
        <div style="padding: 20px; border-top: 1px solid #f0f0f0;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="menu-item" style="padding: 10px; color: #d32f2f; background: none; border: none; width: 100%; text-align: left; cursor: pointer; font-family: inherit; font-size: inherit;">
                    <i class="fa-solid fa-right-from-bracket"></i> লগআউট
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" placeholder="সবজি, ফল বা বীজ খুঁজুন...">
            </div>
            
            <div class="topbar-right">
                <a href="{{ route('buyer.cart') }}" class="icon-btn" style="margin-right: 15px; color: var(--primary-color); text-decoration: none;">
                    <i class="fa-solid fa-cart-shopping"></i>
                    <span class="badge" style="background: var(--accent-color); color: #000;">{{ collect($cartCount)->first() ?? 0 }}</span>
                </a>
                
                <div class="profile-dropdown-container" id="profileBtn" style="position: relative; cursor: pointer;">
                    <div class="profile-dropdown" style="pointer-events: none;">
                        <div style="text-align: right;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                            <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">{{ Auth::user()->email }}</p>
                        </div>
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fbc02d&color=000' }}" alt="Buyer">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            @if(session('success'))
                <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; border: 1px solid #c8e6c9;">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            <!-- Welcome Banner -->
            <div style="background: linear-gradient(135deg, var(--primary-color), var(--primary-light)); border-radius: 15px; padding: 30px; color: white; margin-bottom: 30px; box-shadow: var(--shadow-md); display: flex; align-items: center; justify-content: space-between; overflow: hidden; position: relative;">
                <div style="position: relative; z-index: 2; max-width: 60%;">
                    <h2 style="margin-bottom: 10px; font-size: 2rem;">আজকের তাজা সবজি!</h2>
                    <p style="opacity: 0.9; margin-bottom: 20px;">সরাসরি কৃষকের ক্ষেত থেকে আপনার রান্নাঘরে। আজ কিনলে ডেলিভারি ফ্রি!</p>
                    <a href="#products" class="btn btn-accent" style="border: none; padding: 10px 25px; border-radius: 25px; font-weight: 600; text-decoration: none; display: inline-block;">এখনই কিনুন</a>
                </div>
                <i class="fa-solid fa-basket-wheat" style="font-size: 150px; position: absolute; right: -20px; opacity: 0.2; transform: rotate(-15deg);"></i>
            </div>

            <h2 id="products" class="page-title" style="margin-bottom: 20px;">জনপ্রিয় পণ্য</h2>

            <div class="product-grid">
                @foreach($products as $product)
                <div class="product-card">
                    <div class="product-img-wrapper">
                        @if($loop->first)
                            <span class="product-badge">তাজা</span>
                        @endif
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-img" style="object-fit: cover; height: 220px; width: 100%;">
                    </div>
                    <div class="product-details">
                        <h3 class="product-title">{{ $product->name }}</h3>
                        <div style="font-size: 0.85rem; color: #666; margin-bottom: 10px;">
                            <i class="fa-solid fa-user-check"></i> কৃষক: {{ $product->farmer_id == 1 ? 'রহিম মিয়া' : 'অজানা কৃষক' }}
                        </div>
                        <div class="product-bottom">
                            <div class="product-price">৳ {{ rtrim(rtrim($product->price, '0'), '.') }} <span>/ কেজি</span></div>
                            <form action="{{ route('cart.add') }}" method="POST" style="margin: 0;">
                                @csrf
                                <input type="hidden" name="product_name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <input type="hidden" name="image_url" value="{{ $product->image_url }}">
                                <button type="submit" class="add-to-cart-btn" style="border: none; cursor: pointer; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-plus"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>

</body>
</html>
