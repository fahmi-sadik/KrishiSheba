@extends('layouts.app')

@section('শিরোনাম', 'হোম')

@section('কন্টেন্ট')
<div class="hero">
    <div class="container">
        <h1 class="display-4 mb-4">
            <i class="fas fa-leaf"></i> KrishiSheba
        </h1>
        <p class="lead mb-4">কৃষকদের কাছ থেকে সরাসরি তাজা পণ্য কিনুন</p>
        <a href="{{ route('guest.products') }}" class="btn btn-light btn-lg">পণ্য ব্রাউজ করুন</a>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center mb-5">বৈশিষ্ট্য</h2>
    <div class="row mb-5">
        <div class="col-md-4">
            <div class="text-center">
                <i class="fas fa-tractor fa-3x text-primary mb-3"></i>
                <h5>কৃষকদের কাছ থেকে সরাসরি</h5>
                <p>আমাদের প্ল্যাটফর্ম থেকে কৃষকদের কাছ থেকে সরাসরি তাজা পণ্য পান।</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                <h5>নিরাপদ লেনদেন</h5>
                <p>আপনার সমস্ত লেনদেন সম্পূর্ণ নিরাপদ এবং সুরক্ষিত।</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="text-center">
                <i class="fas fa-shipping-fast fa-3x text-primary mb-3"></i>
                <h5>দ্রুত ডেলিভারি</h5>
                <p>আমরা দ্রুততম সময়ে আপনার দোরগোড়ায় পণ্য পৌঁছে দিই।</p>
            </div>
        </div>
    </div>

    <h2 class="text-center mb-5">বৈশিষ্ট্য পণ্যগুলি</h2>
    <div class="row">
        @forelse ($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card product-card">
                    @if ($product->ছবি)
                        <img src="{{ asset('storage/' . $product->ছবি) }}" class="card-img-top product-image" alt="{{ $product->নাম }}">
                    @else
                        <div class="product-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->নাম }}</h5>
                        <p class="card-text text-muted">{{ Str::limit($product->বর্ণনা, 50) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="h5 mb-0">৳{{ number_format($product->মূল্য, 2) }}</span>
                            <a href="{{ route('guest.product', $product->id) }}" class="btn btn-sm btn-primary">দেখুন</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">কোনো পণ্য পাওয়া যায়নি।</p>
            </div>
        @endforelse
    </div>

    <div class="row mt-5 mb-5">
        <div class="col-md-6">
            <h3>কেন KrishiSheba বেছে নিন?</h3>
            <ul class="list-unstyled">
                <li class="mb-3">
                    <i class="fas fa-check text-success"></i> সরাসরি কৃষকদের কাছ থেকে ক্রয় করুন
                </li>
                <li class="mb-3">
                    <i class="fas fa-check text-success"></i> সর্বোত্তম মূল্য গ্যারান্টিযুক্ত
                </li>
                <li class="mb-3">
                    <i class="fas fa-check text-success"></i> তাজা এবং জৈব পণ্য
                </li>
                <li class="mb-3">
                    <i class="fas fa-check text-success"></i> দ্রুত এবং নির্ভরযোগ্য ডেলিভারি
                </li>
                <li class="mb-3">
                    <i class="fas fa-check text-success"></i> ২৪/৭ গ্রাহক সহায়তা
                </li>
            </ul>
        </div>
        <div class="col-md-6">
            <div class="alert alert-info">
                <h5>আগ্রহী? এখনই যোগদান করুন!</h5>
                <p>একজন ক্রেতা, কৃষক বা বিশেষজ্ঞ হিসাবে যোগদান করুন এবং আমাদের বিশাল সম্প্রদায়ের অংশ হয়ে উঠুন।</p>
                <a href="{{ route('register') }}" class="btn btn-primary">এখনই নিবন্ধন করুন</a>
            </div>
        </div>
    </div>
</div>
@endsection
