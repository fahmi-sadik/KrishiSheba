<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>সকল ব্যবহারকারী - কৃষিসেবা | KrishiSheba</title>
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
            <a href="{{ route('admin.users') }}" class="menu-item active">
                <i class="fa-solid fa-users"></i> ব্যবহারকারী
            </a>
            <a href="{{ route('admin.products') }}" class="menu-item">
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
            <div class="data-card" style="background: white; border-radius: 15px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 20px;">
                <div class="data-card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h3 style="margin: 0; font-size: 1.5rem;">সকল ব্যবহারকারী ({{ $users->count() }})</h3>
                </div>
                
                <div class="table-responsive">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="background: #f9f9f9; text-align: left;">
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">নাম</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">ইমেইল</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">ভূমিকা (Role)</th>
                                <th style="padding: 12px 15px; border-bottom: 2px solid #eee;">যোগদানের তারিখ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px 15px; font-weight: 500;">
                                    <div style="display: flex; align-items: center;">
                                        <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=random&color=fff' }}" style="width: 35px; height: 35px; border-radius: 50%; margin-right: 12px; object-fit: cover;">
                                        {{ $user->name }}
                                    </div>
                                </td>
                                <td style="padding: 12px 15px; color: #555;">{{ $user->email }}</td>
                                <td style="padding: 12px 15px;">
                                    @if($user->role === 'admin')
                                        <span style="background: #e3f2fd; color: #1565c0; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">অ্যাডমিন</span>
                                    @elseif($user->role === 'farmer')
                                        <span style="background: #e8f5e9; color: #2e7d32; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">কৃষক</span>
                                    @elseif($user->role === 'buyer')
                                        <span style="background: #fff8e1; color: #f57f17; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">ক্রেতা</span>
                                    @elseif($user->role === 'expert')
                                        <span style="background: #f3e5f5; color: #7b1fa2; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">বিশেষজ্ঞ</span>
                                    @else
                                        <span style="background: #eeeeee; color: #616161; padding: 4px 10px; border-radius: 20px; font-size: 0.8rem; font-weight: 600;">{{ $user->role }}</span>
                                    @endif
                                </td>
                                <td style="padding: 12px 15px; color: #777;">{{ $user->created_at->format('d M, Y') }}</td>
                            </tr>
                            @endforeach
                            
                            @if($users->isEmpty())
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 30px; color: #888;">কোনো ব্যবহারকারী পাওয়া যায়নি।</td>
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
