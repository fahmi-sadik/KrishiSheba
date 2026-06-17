<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>নিবন্ধন - কৃষিসেবা | KrishiSheba</title>
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
        <div class="auth-card" style="max-width: 500px;">
            <div class="auth-header">
                <div class="logo" style="justify-content: center; margin-bottom: 10px;">
                    <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
                </div>
                <h2 class="auth-title">নতুন অ্যাকাউন্ট তৈরি করুন</h2>
                <p style="color: var(--text-muted);">কৃষিসেবা পরিবারে আপনাকে স্বাগতম</p>
                
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
            
            <form action="{{ route('register.post') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">আপনার নাম</label>
                    <input type="text" name="name" class="form-control" placeholder="আপনার সম্পূর্ণ নাম লিখুন" required value="{{ old('name') }}">
                    @error('name') <small style="color: #c62828;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">ইমেইল ঠিকানা</label>
                    <input type="email" name="email" class="form-control" placeholder="example@krishisheba.com" required value="{{ old('email') }}">
                    @error('email') <small style="color: #c62828;">{{ $message }}</small> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">জাতীয় পরিচয়পত্র (NID) নম্বর</label>
                    <input type="text" name="nid" class="form-control" placeholder="আপনার ১০ বা ১৭ ডিজিটের NID নম্বর" required value="{{ old('nid') }}">
                    @error('nid') <small style="color: #c62828;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">আপনার ছবি</label>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" style="padding: 9px 15px;">
                    @error('profile_image') <small style="color: #c62828;">{{ $message }}</small> @enderror
                </div>
                
                <div class="form-group">
                    <label class="form-label">অ্যাকাউন্টের ধরন</label>
                    <select name="role" class="form-control" required style="cursor: pointer;">
                        <option value="" disabled selected>নির্বাচন করুন...</option>
                        <option value="farmer" {{ old('role') == 'farmer' ? 'selected' : '' }}>কৃষক (পণ্য বিক্রি করতে চাই)</option>
                        <option value="buyer" {{ old('role') == 'buyer' ? 'selected' : '' }}>ক্রেতা (পণ্য কিনতে চাই)</option>
                        <option value="expert" {{ old('role') == 'expert' ? 'selected' : '' }}>কৃষি বিশেষজ্ঞ (পরামর্শ দিতে চাই)</option>
                    </select>
                    @error('role') <small style="color: #c62828;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড</label>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                    @error('password') <small style="color: #c62828;">{{ $message }}</small> @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="••••••••" required>
                </div>
                
                <div class="auth-actions">
                    <!-- Register Button -->
                    <button type="submit" class="btn btn-primary btn-full">নিবন্ধন সম্পূর্ণ করুন</button>
                    
                    <div style="text-align: center; margin: 15px 0; font-size: 0.95rem;">
                        ইতিমধ্যে একটি অ্যাকাউন্ট আছে? 
                        <a href="{{ route('login') }}" style="font-weight: 600; text-decoration: underline;">লগইন করুন</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
