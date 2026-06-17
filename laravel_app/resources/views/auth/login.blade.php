<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>লগইন - কৃষিসেবা | KrishiSheba</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Inter:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Back to home button floating -->
    <a href="{{ route('home') }}" style="position: absolute; top: 20px; left: 20px; font-weight: bold; font-size: 1.2rem; text-decoration: none;">
        <i class="fa-solid fa-arrow-left"></i> ফিরে যান
    </a>

    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo" style="justify-content: center; margin-bottom: 10px;">
                    <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
                </div>
                <h2 class="auth-title">স্বাগতম!</h2>
                <p style="color: var(--text-muted);">আপনার অ্যাকাউন্টে প্রবেশ করুন</p>
                
                @if (session('error'))
                    <div style="margin-top:15px; padding: 10px; border-radius: 5px; text-align: center; background: #ffebee; color: #c62828;">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div style="margin-top:15px; padding: 10px; border-radius: 5px; text-align: center; background: #e8f5e9; color: #2e7d32;">
                        {{ session('success') }}
                    </div>
                @endif
            </div>
            
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" class="form-control" placeholder="example@krishisheba.com" required value="{{ old('email') }}">
                    @error('email')
                        <small style="color: #c62828;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    @error('password')
                        <small style="color: #c62828;">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">লগইন ধরন</label>
                    <select name="role" class="form-control" style="cursor: pointer;" required>
                        <option value="admin">অ্যাডমিন (Admin)</option>
                        <option value="buyer">ক্রেতা (Buyer)</option>
                        <option value="farmer">কৃষক (Farmer)</option>
                        <option value="expert">বিশেষজ্ঞ (Expert)</option>
                    </select>
                </div>
                
                <div class="auth-actions">
                    <!-- Login Button -->
                    <button type="submit" class="btn btn-primary btn-full">লগইন করুন</button>
                    
                    <div style="text-align: center; margin: 10px 0; color: #999; font-size: 0.9rem;">অথবা</div>
                    
                    <!-- Registration Button -->
                    <a href="{{ route('register') }}" class="btn btn-outline btn-full">
                        নতুন ব্যবহারকারী নিবন্ধন
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
