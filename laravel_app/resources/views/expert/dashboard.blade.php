<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বিশেষজ্ঞ ড্যাশবোর্ড - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="dashboard-body">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span></div>
        </div>
        <div class="sidebar-menu">
            <a href="#" class="menu-item active"><i class="fa-solid fa-stethoscope"></i> পরামর্শ দিন</a>
            <a href="{{ route('profile.settings') }}" class="menu-item"><i class="fa-solid fa-user-cog"></i> প্রোফাইল সেটিংস</a>
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

    <main class="main-content">
        <header class="topbar">
            <div class="search-bar"></div>
            <div class="topbar-right">
                <div style="text-align: right;">
                    <p style="margin: 0; font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                    <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">{{ Auth::user()->email }}</p>
                </div>
                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=3f51b5&color=fff' }}" style="width: 35px; height: 35px; border-radius: 50%; margin-left: 10px; object-fit: cover;">
            </div>
        </header>

        <div class="dashboard-content">
            @if(session('success'))
                <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <h2 class="page-title">কৃষকদের প্রশ্নসমূহ (অপেক্ষমান)</h2>

            <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-top: 20px;">
                @foreach($pendingRequests as $request)
                <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; border-bottom: 1px solid #eee; padding-bottom: 10px;">
                        <div>
                            <strong style="color: #2c3e50;"><i class="fa-solid fa-user"></i> {{ $request->farmer->name ?? 'অজানা কৃষক' }}</strong>
                        </div>
                        <span style="color: #888; font-size: 0.9rem;">{{ $request->created_at->diffForHumans() }}</span>
                    </div>
                    
                    <div style="margin-bottom: 20px;">
                        <h4 style="margin: 0 0 10px 0; color: #d32f2f;"><i class="fa-solid fa-circle-question"></i> প্রশ্ন:</h4>
                        <p style="margin: 0; font-size: 1.1rem; color: #333; line-height: 1.5;">{{ $request->question }}</p>
                    </div>

                    <form action="{{ route('expert.advice.answer', $request->id) }}" method="POST">
                        @csrf
                        <div style="margin-bottom: 15px;">
                            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #2e7d32;"><i class="fa-solid fa-comment-medical"></i> উত্তর দিন:</label>
                            <textarea name="answer" required rows="4" style="width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 8px; font-family: 'Hind Siliguri', sans-serif; font-size: 1rem; resize: vertical;" placeholder="আপনার বিশেষজ্ঞ মতামত এখানে লিখুন..."></textarea>
                        </div>
                        <button type="submit" style="background: #2e7d32; color: white; padding: 12px 25px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-family: 'Hind Siliguri', sans-serif; font-size: 1rem; transition: 0.3s;" onmouseover="this.style.background='#1b5e20'" onmouseout="this.style.background='#2e7d32'">
                            <i class="fa-solid fa-paper-plane"></i> উত্তর জমা দিন
                        </button>
                    </form>
                </div>
                @endforeach

                @if($pendingRequests->isEmpty())
                <div style="background: white; padding: 50px; border-radius: 15px; text-align: center; color: #888;">
                    <i class="fa-solid fa-check-double" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                    <p style="font-size: 1.2rem;">বর্তমানে নতুন কোনো প্রশ্ন নেই।</p>
                </div>
                @endif
            </div>

        </div>
    </main>
</body>
</html>
