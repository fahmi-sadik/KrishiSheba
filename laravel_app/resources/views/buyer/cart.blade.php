@php
function enToBn($num) {
    return str_replace(range(0, 9), ['০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯'], (string) $num);
}
@endphp
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>আমার কার্ট - কৃষিসেবা | KrishiSheba</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cart-wrapper { display: grid; grid-template-columns: 1.8fr 1fr; gap: 30px; margin-top: 20px; }
        
        .cart-card { 
            background: #fff; border-radius: 15px; padding: 20px; margin-bottom: 15px; 
            display: flex; align-items: center; position: relative; border: 1px solid #eee; 
            box-shadow: 0 4px 10px rgba(0,0,0,0.02); justify-content: space-between;
        }

        .item-img-box { width: 100px; height: 100px; border-radius: 12px; overflow: hidden; margin-right: 20px; border: 1px solid #f0f0f0; flex-shrink: 0;}
        .item-img-box img { width: 100%; height: 100%; object-fit: cover; }
        
        .summary-box { 
            background: #ffffff;
            border-radius: 24px; padding: 35px; 
            position: sticky; top: 20px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            border: 1px solid #e0e0e0; 
        }

        .summary-box h3 { 
            margin-top: 0; font-size: 22px; margin-bottom: 25px; color: #2c3e50; 
            border-bottom: 2px solid #f0f0f0; padding-bottom: 15px;
        }

        .total-row { 
            border-top: 2px dashed #d4e4e1; 
            padding-top: 20px; margin-top: 20px; 
            font-size: 26px; font-weight: 700; color: #2e7d32; 
        }

        .checkout-btn { 
            width: 100%; background: #000; color: #fff; padding: 18px; 
            border-radius: 40px; border: none; font-weight: 700; cursor: pointer; 
            margin-top: 25px; font-family: 'Hind Siliguri'; font-size: 17px;
            transition: 0.3s;
        }
        
        .checkout-btn:hover { background: #333; transform: translateY(-2px); }

        .qty-box { display: flex; align-items: center; gap: 12px; margin-top: 10px; }
        .qty-btn { background: none; cursor: pointer; color: #666; border: 1px solid #ddd; padding: 2px 10px; border-radius: 5px; font-weight: bold; }
        .delete-icon { background: none; border: none; cursor: pointer; position: absolute; top: 15px; right: 15px; color: #ccc; font-size: 18px; }
    </style>
</head>
<body class="dashboard-body">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span></div>
        </div>
        <div class="sidebar-menu">
            <a href="{{ route('buyer.dashboard') }}" class="menu-item"><i class="fa-solid fa-store"></i> তাজা বাজার</a>
            <a href="{{ route('buyer.cart') }}" class="menu-item active"><i class="fa-solid fa-basket-shopping"></i> আমার কার্ট <span class="badge" style="position: static; margin-left: auto;">{{ enToBn($cartCount) }}</span></a>
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
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass" style="color: var(--text-muted);"></i>
                <input type="text" placeholder="সবজি, ফল বা বীজ খুঁজুন...">
            </div>
            <div class="topbar-right">
                <div class="profile-dropdown-container" id="profileBtn" style="position: relative; cursor: pointer;">
                    <div class="profile-dropdown" style="pointer-events: none;">
                        <div style="text-align: right;">
                            <p style="margin: 0; font-weight: 600; font-size: 0.9rem;">{{ Auth::user()->name }}</p>
                            <p style="margin: 0; font-size: 0.8rem; color: var(--text-muted);">{{ Auth::user()->email }}</p>
                        </div>
                        <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=fbc02d&color=000' }}" style="width: 35px; height: 35px; border-radius: 50%; margin-left: 10px; object-fit: cover;">
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

            <h1 style="font-size: 28px; margin-bottom: 5px;">কেনাকাটার তালিকা</h1>
            <p style="color: #888; margin-bottom: 25px;">হোম > কার্ট</p>

            <div class="cart-wrapper">
                <div class="cart-items">
                    @if($cartItems->count() > 0)
                        @foreach($cartItems as $item)
                        <div class="cart-card">
                            <div style="display: flex; align-items: center;">
                                <div class="item-img-box"><img src="{{ $item->image_url }}" alt="{{ $item->product_name }}"></div>
                                <div class="item-info">
                                    <h4 style="margin: 0; font-size: 1.1rem; margin-bottom: 5px;">{{ $item->product_name }}</h4>
                                    <p style="margin: 0; color: #666; font-size: 0.9rem;">৳ {{ enToBn(number_format($item->price, 2)) }} / কেজি</p>
                                    <div class="qty-box">
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="action" value="decrease">
                                            <button type="submit" class="qty-btn">-</button>
                                        </form>
                                        <span style="font-weight: 600;">{{ enToBn($item->quantity) }} টি</span>
                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" style="margin: 0;">
                                            @csrf
                                            <input type="hidden" name="action" value="increase">
                                            <button type="submit" class="qty-btn">+</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div style="font-size: 20px; font-weight: 700; color: #2e7d32;">
                                ৳ {{ enToBn(number_format($item->price * $item->quantity, 2)) }}
                            </div>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="delete-icon"><i class="fa-solid fa-xmark"></i></button>
                            </form>
                        </div>
                        @endforeach
                    @else
                        <div style="background: white; border-radius: 15px; padding: 50px; text-align: center; border: 1px dashed #ccc;">
                            <i class="fa-solid fa-cart-shopping" style="font-size: 3rem; color: #ddd; margin-bottom: 15px;"></i>
                            <p style="font-size: 1.1rem; color: #666;">আপনার কার্ট বর্তমানে খালি।</p>
                        </div>
                    @endif
                </div>

                <div class="summary-col">
                    <div class="summary-box">
                        <h3>অর্ডারের সারসংক্ষেপ</h3>
                        @php
                            $delivery_fee = $totalPrice > 0 ? 50 : 0;
                            $grand_total = $totalPrice + $delivery_fee;
                        @endphp
                        <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                            <span>উপ-মোট</span>
                            <span>৳ {{ enToBn(number_format($totalPrice, 2)) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin: 15px 0;">
                            <span>ডেলিভারি চার্জ</span>
                            <span>৳ {{ enToBn(number_format($delivery_fee, 2)) }}</span>
                        </div>
                        <div class="total-row" style="display: flex; justify-content: space-between;">
                            <span>সর্বমোট</span>
                            <span>৳ {{ enToBn(number_format($grand_total, 2)) }}</span>
                        </div>
                        <form action="{{ route('buyer.checkout') }}" method="POST">
                            @csrf
                            <button type="submit" class="checkout-btn" {{ $cartItems->isEmpty() ? 'disabled style="opacity:0.5; cursor:not-allowed;"' : '' }}>অর্ডার সম্পন্ন করুন</button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('buyer.dashboard') }}" style="background: #000; color: #fff; padding: 12px 30px; border-radius: 30px; text-decoration: none; font-weight: 600; display: inline-block;">আরও কেনাকাটা করুন</a>
            </div>
        </div>
    </main>
</body>
</html>
