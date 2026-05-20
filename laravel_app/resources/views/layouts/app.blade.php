<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>কৃষিসেবা - KrishiSheba | কৃষকের সরাসরি বাজার</title>
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

    <!-- Navbar -->
    <nav class="navbar">
        <div class="logo">
            <a href="{{ route('home') }}" style="text-decoration: none; color: inherit;">
                <i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span>
            </a>
        </div>
        <div class="nav-links">
            <a href="{{ route('home') }}">হোম</a>
            <a href="{{ route('home') }}#features">আমাদের সেবাসমূহ</a>
            <a href="#">পণ্য</a>
            
            @guest
                <a href="{{ route('login') }}" class="btn btn-outline">লগইন</a>
                <a href="{{ route('register') }}" class="btn btn-primary">নিবন্ধন করুন</a>
            @else
                <a href="#" class="btn btn-outline">{{ Auth::user()->name }}</a>
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">লগআউট</button>
                </form>
            @endguest
        </div>
    </nav>

    @if (session('success'))
        <div style="margin: 20px auto; max-width: 800px; padding: 15px; border-radius: 5px; text-align: center; background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9;">
            {{ session('success') }}
        </div>
    @endif

    @yield('content')

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 কৃষিসেবা (KrishiSheba). সর্বস্বত্ব সংরক্ষিত।</p>
    </footer>

</body>
</html>
