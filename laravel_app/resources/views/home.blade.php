@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <header class="hero" style="background-image: url('{{ asset('assets/images/hero.png') }}');">
        <div class="hero-content">
            <h1 class="hero-title">কৃষকের হাসি, <br>আমাদের প্রাপ্তি</h1>
            <p class="hero-subtitle">সরাসরি কৃষকের কাছ থেকে তাজা পণ্য কিনুন, কৃষি বিশেষজ্ঞের পরামর্শ নিন এবং আপনার প্রয়োজনীয় কৃষি উপকরণ সংগ্রহ করুন একই প্ল্যাটফর্মে।</p>
            <div class="hero-actions">
                <a href="#features" class="btn btn-primary">বিস্তারিত জানুন</a>
                <a href="{{ route('login') }}" class="btn btn-accent">শুরু করুন</a>
            </div>
        </div>
    </header>

    <!-- Features Section -->
    <section id="features" class="features">
        <div class="section-header">
            <h2 class="section-title">কেন কৃষিসেবা বেছে নেবেন?</h2>
            <p class="section-subtitle">আমরা কৃষক এবং ক্রেতার মধ্যে একটি সরাসরি যোগসূত্র তৈরি করি, যাতে সবাই লাভবান হয়।</p>
        </div>
        
        <div class="features-grid">
            <!-- Feature 1 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-basket-shopping"></i>
                </div>
                <h3 class="feature-title">সরাসরি পণ্য ক্রয়</h3>
                <p>কৃষকদের উৎপাদিত তাজা শাকসবজি, ফলমূল এবং ফসল মধ্যস্বত্বভোগী ছাড়া সরাসরি সাশ্রয়ী মূল্যে কিনুন।</p>
            </div>
            
            <!-- Feature 2 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-user-doctor"></i>
                </div>
                <h3 class="feature-title">বিশেষজ্ঞ পরামর্শ</h3>
                <p>ফসলের রোগবালাই, আধুনিক চাষাবাদ এবং উৎপাদন বাড়ানোর জন্য কৃষি বিশেষজ্ঞদের কাছ থেকে বিনামূল্যে পরামর্শ নিন।</p>
            </div>

            <!-- Feature 3 -->
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-seedling"></i>
                </div>
                <h3 class="feature-title">কৃষি উপকরণ</h3>
                <p>উন্নত মানের বীজ, সার এবং আধুনিক কৃষি যন্ত্রপাতি সহজে এবং দ্রুততম সময়ে সংগ্রহ করুন।</p>
            </div>
        </div>
    </section>
@endsection
