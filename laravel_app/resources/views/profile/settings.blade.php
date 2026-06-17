<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>প্রোফাইল সেটিংস - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-family: 'Hind Siliguri', sans-serif; transition: border-color 0.3s; }
        .form-control:focus { border-color: #2e7d32; outline: none; }
        .submit-btn { background: #2e7d32; color: white; padding: 12px 30px; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; font-family: 'Hind Siliguri', sans-serif; font-size: 1.1rem; transition: background 0.3s; }
        .submit-btn:hover { background: #1b5e20; }
        .profile-header { background: white; padding: 30px; border-radius: 15px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 30px; }
        .profile-img-large { width: 120px; height: 120px; border-radius: 50%; object-fit: cover; border: 4px solid #e8f5e9; margin-bottom: 15px; }
    </style>
</head>
<body class="dashboard-body">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span></div>
        </div>
        <div class="sidebar-menu">
            <a href="{{ url()->previous() }}" class="menu-item"><i class="fa-solid fa-arrow-left"></i> ড্যাশবোর্ডে ফিরুন</a>
            <a href="#" class="menu-item active"><i class="fa-solid fa-user-cog"></i> প্রোফাইল সেটিংস</a>
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
                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=2e7d32&color=fff' }}" style="width: 35px; height: 35px; border-radius: 50%; margin-left: 10px; object-fit: cover;">
            </div>
        </header>

        <div class="dashboard-content">
            @if(session('success'))
                <div style="background: #e8f5e9; color: #2e7d32; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div style="background: #ffebee; color: #c62828; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <ul style="margin: 0; padding-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="profile-header">
                <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name).'&background=2e7d32&color=fff' }}" class="profile-img-large">
                <h2 style="margin: 0 0 5px 0;">{{ $user->name }}</h2>
                <p style="margin: 0; color: #666; text-transform: capitalize;">{{ $user->role }} Account</p>
            </div>

            <div style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
                <h3 style="margin-top: 0; margin-bottom: 25px; border-bottom: 2px solid #eee; padding-bottom: 10px;">ব্যক্তিগত তথ্য আপডেট করুন</h3>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label>নাম</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="form-group">
                            <label>ইমেইল ঠিকানা</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label>মোবাইল নম্বর</label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="যেমন: ০১৭XXXXXXXX">
                        </div>
                        <div class="form-group">
                            <label>প্রোফাইল ছবি পরিবর্তন করুন</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*" style="padding: 9px 12px;">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>যোগাযোগের ঠিকানা (Address)</label>
                        <textarea name="address" class="form-control" rows="3" placeholder="আপনার সম্পূর্ণ ঠিকানা লিখুন...">{{ old('address', $user->address) }}</textarea>
                    </div>

                    <h3 style="margin-top: 30px; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px; color: #d32f2f;">পাসওয়ার্ড পরিবর্তন (ঐচ্ছিক)</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div class="form-group">
                            <label>নতুন পাসওয়ার্ড</label>
                            <input type="password" name="password" class="form-control" placeholder="পরিবর্তন না চাইলে ফাঁকা রাখুন">
                        </div>
                        <div class="form-group">
                            <label>পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" name="password_confirmation" class="form-control" placeholder="নতুন পাসওয়ার্ডটি আবার লিখুন">
                        </div>
                    </div>

                    <div style="margin-top: 30px; text-align: right;">
                        <button type="submit" class="submit-btn"><i class="fa-solid fa-save"></i> পরিবর্তন সংরক্ষণ করুন</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
