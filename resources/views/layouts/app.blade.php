<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('শিরোনাম') - KrishiSheba</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 24px;
            color: white !important;
        }
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            margin: 0 5px;
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            color: white !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
        }
        .card {
            border: none;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }
        .footer {
            background-color: #2c3e50;
            color: white;
            padding: 30px 0;
            margin-top: 50px;
        }
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 0;
            text-align: center;
        }
        .product-card {
            position: relative;
            overflow: hidden;
        }
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .badge-status {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .alert-custom {
            border-radius: 10px;
            border: none;
        }
    </style>
    @yield('বিশেষ_সিএসএস')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-leaf"></i> KrishiSheba
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @if (auth()->check())
                        @if (auth()->user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.dashboard') }}">ড্যাশবোর্ড</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users') }}">ব্যবহারকারী</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.sales.report') }}">বিক্রয় প্রতিবেদন</a>
                            </li>
                        @elseif (auth()->user()->isFarmer())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('farmer.dashboard') }}">ড্যাশবোর্ড</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('farmer.products') }}">আমার পণ্য</a>
                            </li>
                        @elseif (auth()->user()->isBuyer())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('buyer.dashboard') }}">ড্যাশবোর্ড</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('buyer.browse') }}">পণ্য ব্রাউজ করুন</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('buyer.orders') }}">আমার অর্ডার</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button class="nav-link btn btn-link" style="cursor: pointer; border: none; background: none;">
                                    লগআউট
                                </button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('guest.products') }}">পণ্য</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">লগইন</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">নিবন্ধন</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        @if ($errors->any())
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                <strong>ত্রুটি!</strong>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('সাফল্য'))
            <div class="alert alert-success alert-custom alert-dismissible fade show" role="alert">
                {{ session('সাফল্য') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('ত্রুটি'))
            <div class="alert alert-danger alert-custom alert-dismissible fade show" role="alert">
                {{ session('ত্রুটি') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    @yield('কন্টেন্ট')

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-leaf"></i> KrishiSheba</h5>
                    <p>কৃষি পণ্য বিক্রয়ের জন্য আমাদের প্ল্যাটফর্ম।</p>
                </div>
                <div class="col-md-4">
                    <h5>দ্রুত লিংক</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">হোম</a></li>
                        <li><a href="{{ route('guest.products') }}" class="text-white-50 text-decoration-none">পণ্য</a></li>
                        <li><a href="{{ route('login') }}" class="text-white-50 text-decoration-none">লগইন</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>যোগাযোগ করুন</h5>
                    <p class="text-white-50">ইমেইল: info@krishisheba.com<br>ফোন: +880-1XXXXXXXXX</p>
                </div>
            </div>
            <hr class="bg-white-50">
            <div class="text-center text-white-50">
                <p>&copy; 2024 KrishiSheba। সর্বাধিকার সংরক্ষিত।</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('জাভাস্ক্রিপ্ট')
</body>
</html>
