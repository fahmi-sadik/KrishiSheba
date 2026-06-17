<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>পণ্য অনুমোদন - কৃষিসেবা | KrishiSheba</title>
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
            <a href="{{ route('admin.dashboard') }}" class="menu-item">
                <i class="fa-solid fa-chart-line"></i> ড্যাশবোর্ড
            </a>
            <a href="{{ route('admin.users') }}" class="menu-item">
                <i class="fa-solid fa-users"></i> ব্যবহারকারী
            </a>
            <a href="{{ route('admin.products') }}" class="menu-item active">
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

            <div class="data-card" style="background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 20px;">
                <div class="data-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin: 0; font-size: 1.5rem;">সকল পণ্য</h3>
                </div>
                
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9f9f9; text-align: left;">
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">পণ্যের নাম</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">কৃষকের নাম</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">মূল্য (টাকা)</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">স্ট্যাটাস</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">অ্যাকশন</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px 15px;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ $product->image_url }}" alt="product" style="width: 35px; height: 35px; object-fit: cover; border-radius: 5px; margin-right: 12px;">
                                        <span style="font-weight: 500;">{{ $product->name }}</span>
                                    </div>
                                </td>
                                <td style="padding: 12px 15px; color: #555;">{{ $product->farmer->name ?? 'অজানা' }}</td>
                                <td style="padding: 12px 15px; font-weight: 600;">৳ {{ number_format((float)$product->price, 2) }}</td>
                                <td style="padding: 12px 15px;">
                                    @if($product->status == 'pending')
                                        <span class="status pending" style="background: #fff3e0; color: #e65100; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">অপেক্ষমান</span>
                                    @elseif($product->status == 'approved')
                                        <span class="status approved" style="background: #e8f5e9; color: #2e7d32; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">অনুমোদিত</span>
                                    @elseif($product->status == 'rejected')
                                        <span class="status rejected" style="background: #ffebee; color: #d32f2f; padding: 5px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">বাতিল</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 15px; display: flex; gap: 5px;">
                                    @if($product->status == 'pending')
                                        <form action="{{ route('admin.product.approve', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn approve" title="অনুমোদন করুন" style="border: none; cursor: pointer; background: #e8f5e9; color: #2e7d32; padding: 6px 12px; border-radius: 5px; font-size: 0.9rem;"><i class="fa-solid fa-check-circle"></i></button>
                                        </form>
                                        <form action="{{ route('admin.product.reject', $product->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="action-btn reject" title="বাতিল করুন" style="border: none; cursor: pointer; background: #ffebee; color: #d32f2f; padding: 6px 12px; border-radius: 5px; font-size: 0.9rem;"><i class="fa-solid fa-times-circle"></i></button>
                                        </form>
                                    @else
                                        <span style="color: #bbb; font-size: 0.85rem; font-style: italic;">সম্পন্ন</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($products->isEmpty())
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 30px; color: #888;">কোনো পণ্য পাওয়া যায়নি।</td>
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
