<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>কৃষক ড্যাশবোর্ড - কৃষিসেবা</title>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: 500; }
        .form-group input { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Hind Siliguri', sans-serif;}
        .submit-btn { background: #2e7d32; color: white; padding: 12px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: bold; width: 100%; font-family: 'Hind Siliguri', sans-serif; font-size: 1rem; transition: 0.3s;}
        .submit-btn:hover { background: #1b5e20; }
    </style>
</head>
<body class="dashboard-body">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo"><i class="fa-solid fa-leaf"></i> কৃষি<span>সেবা</span></div>
        </div>
        <div class="sidebar-menu">
            <a href="#" class="menu-item active"><i class="fa-solid fa-chart-line"></i> ড্যাশবোর্ড</a>
            <a href="#products" class="menu-item"><i class="fa-solid fa-box"></i> আমার পণ্য</a>
            <a href="#advice" class="menu-item"><i class="fa-solid fa-stethoscope"></i> বিশেষজ্ঞের পরামর্শ</a>
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
                <img src="{{ Auth::user()->image ? asset('storage/' . Auth::user()->image) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=4caf50&color=fff' }}" style="width: 35px; height: 35px; border-radius: 50%; margin-left: 10px; object-fit: cover;">
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

            <h2 class="page-title" id="products">কৃষক ড্যাশবোর্ড</h2>

            <!-- Add Product & Product List Section -->
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-top: 20px;">
                <!-- Add Product Form -->
                <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                    <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">নতুন পণ্য যোগ করুন</h3>
                    <form action="{{ route('farmer.product.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>পণ্যের নাম</label>
                            <input type="text" name="name" required placeholder="যেমন: দেশী আলু">
                        </div>
                        <div class="form-group">
                            <label>মূল্য (প্রতি কেজি/পিস)</label>
                            <input type="number" name="price" required placeholder="যেমন: ৪০">
                        </div>
                        <div class="form-group">
                            <label>মজুদ পরিমাণ</label>
                            <input type="number" name="stock_quantity" required placeholder="যেমন: ১০০">
                        </div>
                        <div class="form-group">
                            <label>ছবির ইউআরএল</label>
                            <input type="url" name="image_url" required placeholder="https://example.com/image.jpg">
                        </div>
                        <button type="submit" class="submit-btn"><i class="fa-solid fa-plus"></i> যোগ করুন</button>
                    </form>
                </div>

                <!-- Product List -->
                <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                    <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">আমার পণ্যসমূহ</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px;">
                        @foreach($products as $product)
                        <div style="border: 1px solid #eee; border-radius: 10px; overflow: hidden; position: relative;">
                            <img src="{{ $product->image_url }}" style="width: 100%; height: 120px; object-fit: cover;">
                            @if($product->status == 'pending')
                                <span style="position: absolute; top: 10px; right: 10px; background: #ff9800; color: white; padding: 3px 8px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">অপেক্ষমান</span>
                            @elseif($product->status == 'approved')
                                <span style="position: absolute; top: 10px; right: 10px; background: #4caf50; color: white; padding: 3px 8px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">অনুমোদিত</span>
                            @else
                                <span style="position: absolute; top: 10px; right: 10px; background: #f44336; color: white; padding: 3px 8px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">বাতিল</span>
                            @endif
                            <div style="padding: 10px;">
                                <h4 style="margin: 0 0 5px 0;">{{ $product->name }}</h4>
                                <p style="margin: 0; color: #666; font-weight: bold;">৳ {{ $product->price }}</p>
                            </div>
                            <!-- Add Delete Button -->
                            <form action="{{ route('farmer.product.destroy', $product->id) }}" method="POST" style="position: absolute; bottom: 10px; right: 10px;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('আপনি কি নিশ্চিত যে আপনি এই পণ্যটি মুছে ফেলতে চান?')" style="background: #ffebee; color: #d32f2f; border: none; padding: 5px 10px; border-radius: 5px; cursor: pointer; transition: 0.3s;" title="মুছে ফেলুন">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                        @if($products->isEmpty())
                            <p style="color: #888; grid-column: 1 / -1;">আপনি এখনো কোনো পণ্য যোগ করেননি।</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Advice & Payment Section -->
            <div style="margin-top: 40px;" id="advice">
                <h2 class="page-title">বিশেষজ্ঞের পরামর্শ ও প্রশ্নোত্তর</h2>
                
                <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 30px; margin-top: 20px;">
                    <!-- Ask Form -->
                    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                        <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">নতুন প্রশ্ন করুন</h3>
                        
                        <div style="background: #e3f2fd; padding: 15px; border-radius: 8px; margin-bottom: 20px; font-size: 0.9rem; color: #1565c0; border: 1px solid #bbdefb;">
                            <i class="fa-solid fa-circle-info"></i> প্রতি প্রশ্নের জন্য ফি ১০০ টাকা। ফি পরিশোধ করে Transaction ID প্রদান করুন। (bKash/Nagad: 017XXXXXXXX)
                        </div>

                        <form action="{{ route('farmer.advice.ask') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>বিশেষজ্ঞ নির্বাচন করুন</label>
                                <select name="expert_id" required class="form-control" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Hind Siliguri', sans-serif;">
                                    <option value="" disabled selected>নির্বাচন করুন...</option>
                                    @foreach($experts as $expert)
                                        <option value="{{ $expert->id }}">{{ $expert->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>আপনার প্রশ্ন বা সমস্যা</label>
                                <textarea name="question" required rows="4" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Hind Siliguri', sans-serif; resize: vertical;" placeholder="যেমন: ধানের পাতায় বাদামী দাগ দেখা যাচ্ছে..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>ট্রানজ্যাকশন আইডি (TrxID)</label>
                                <input type="text" name="trx_id" required placeholder="bKash/Nagad TrxID (e.g. 9F5A2X7Z)" style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-family: 'Hind Siliguri', sans-serif;">
                            </div>
                            <button type="submit" class="submit-btn" style="background: #0277bd;" onmouseover="this.style.background='#01579b'" onmouseout="this.style.background='#0277bd'"><i class="fa-solid fa-paper-plane"></i> পেমেন্ট ও সাবমিট করুন</button>
                        </form>
                    </div>

                    <!-- History -->
                    <div style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 10px rgba(0,0,0,0.02);">
                        <h3 style="margin-top: 0; margin-bottom: 20px; border-bottom: 2px solid #eee; padding-bottom: 10px;">আমার প্রশ্নোত্তর ইতিহাস</h3>
                        
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            @foreach($pastQuestions as $q)
                            <div style="border: 1px solid #eee; border-radius: 10px; padding: 15px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                                    <span style="font-weight: 600; color: #2e7d32;"><i class="fa-solid fa-user-md"></i> {{ $q->expert->name ?? 'বিশেষজ্ঞ' }}</span>
                                    @if($q->status == 'answered')
                                        <span style="background: #e8f5e9; color: #2e7d32; padding: 3px 8px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">উত্তরিত</span>
                                    @else
                                        <span style="background: #fff3e0; color: #e65100; padding: 3px 8px; border-radius: 5px; font-size: 0.8rem; font-weight: bold;">অপেক্ষমান</span>
                                    @endif
                                </div>
                                <p style="margin: 0 0 10px 0; font-size: 1.05rem;"><strong>প্র:</strong> {{ $q->question }}</p>
                                @if($q->answer)
                                    <div style="background: #f9f9f9; padding: 10px; border-left: 3px solid #2e7d32; border-radius: 0 5px 5px 0;">
                                        <p style="margin: 0; color: #444;"><strong>উ:</strong> {{ $q->answer }}</p>
                                    </div>
                                @endif
                                <div style="margin-top: 10px; font-size: 0.8rem; color: #999;">
                                    <i class="fa-solid fa-clock"></i> {{ $q->created_at->format('d M, Y') }} | <i class="fa-solid fa-check"></i> পেমেন্ট: সফল (৳ ১০০)
                                </div>
                            </div>
                            @endforeach
                            
                            @if($pastQuestions->isEmpty())
                                <p style="color: #888; text-align: center; padding: 20px;">আপনি এখনো কোনো প্রশ্ন করেননি।</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
