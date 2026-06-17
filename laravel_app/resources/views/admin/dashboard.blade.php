<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>অ্যাডমিন ড্যাশবোর্ড - কৃষিসেবা | KrishiSheba</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
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
            <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                <i class="fa-solid fa-chart-line"></i> ড্যাশবোর্ড
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-users"></i> ব্যবহারকারী
            </a>
            <a href="#" class="menu-item">
                <i class="fa-solid fa-box-open"></i> পণ্য অনুমোদন
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
                <input type="text" placeholder="অনুসন্ধান করুন...">
            </div>
            
            <div class="topbar-right">
                <div class="profile-dropdown-container" id="profileBtn" style="position: relative; cursor: pointer;">
                    <div class="profile-dropdown" style="pointer-events: none;">
                        <div style="text-align: right;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                            <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">{{ Auth::user()->email }}</p>
                        </div>
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2e7d32&color=fff' }}" alt="Admin">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            @if(session('success'))
                <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            
            <h2 class="page-title">ওভারভিউ (অ্যাডমিন)</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $usersCount }}</h3>
                        <p>মোট ব্যবহারকারী</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon yellow">
                        <i class="fa-solid fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <h3>{{ $pendingProducts->count() }}</h3>
                        <p>অপেক্ষমান পণ্য</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fa-solid fa-sack-dollar"></i>
                    </div>
                    <div class="stat-info">
                        <h3>৳ {{ number_format($todaySales, 2) }}</h3>
                        <p>আজকের বিক্রি</p>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity Table -->
            <div class="data-card" style="margin-top: 30px; background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 20px;">
                <div class="data-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin: 0;">অপেক্ষমান পণ্য (অনুমোদনের জন্য)</h3>
                </div>
                
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9f9f9; text-align: left;">
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">পণ্যের নাম</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">কৃষকের নাম</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">মূল্য (টাকা)</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">তারিখ</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">স্ট্যাটাস</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingProducts as $product)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px 15px;">
                                    <img src="{{ $product->image_url }}" alt="product" style="width: 30px; height: 30px; object-fit: cover; border-radius: 5px; margin-right: 8px; vertical-align: middle;">
                                    {{ $product->name }}
                                </td>
                                <td style="padding: 12px 15px;">{{ $product->farmer->name ?? 'অজানা' }}</td>
                                <td style="padding: 12px 15px;">{{ $product->price }} / কেজি</td>
                                <td style="padding: 12px 15px;">{{ $product->created_at->format('d M, Y') }}</td>
                                <td style="padding: 12px 15px;"><span class="status pending" style="background: #fff3e0; color: #e65100; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem;">অপেক্ষমান</span></td>
                                <td style="padding: 12px 15px; display: flex; gap: 5px;">
                                    <form action="{{ route('admin.product.approve', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="action-btn approve" title="অনুমোদন করুন" style="border: none; cursor: pointer; background: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 5px;"><i class="fa-solid fa-check-circle"></i></button>
                                    </form>
                                    <form action="{{ route('admin.product.reject', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="action-btn reject" title="বাতিল করুন" style="border: none; cursor: pointer; background: #ffebee; color: #d32f2f; padding: 5px 10px; border-radius: 5px;"><i class="fa-solid fa-times-circle"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($pendingProducts->isEmpty())
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 30px; color: #888;">কোনো অপেক্ষমান পণ্য নেই।</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
