@extends('layouts.app')

@section('শিরোনাম', $product->নাম)

@section('কন্টেন্ট')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-5">
            @if ($product->ছবি)
                <img src="{{ asset('storage/' . $product->ছবি) }}" class="img-fluid rounded" alt="{{ $product->নাম }}">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <i class="fas fa-image fa-5x text-muted"></i>
                </div>
            @endif
        </div>

        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('guest.products') }}">পণ্য</a></li>
                    <li class="breadcrumb-item active">{{ $product->নাম }}</li>
                </ol>
            </nav>

            <h2 class="mb-3">{{ $product->নাম }}</h2>
            
            <div class="mb-3">
                <span class="badge bg-success">{{ $product->বিভাগ }}</span>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <p class="mb-3">
                        <strong>মূল্য:</strong> <span class="h4 text-primary">৳{{ number_format($product->মূল্য, 2) }}</span>
                    </p>
                    <p class="mb-3">
                        <strong>উপলব্ধ পরিমাণ:</strong> {{ $product->পরিমাণ }} {{ $product->এককরণ }}
                    </p>
                    <p class="mb-3">
                        <strong>বিক্রেতা:</strong> 
                        <a href="#">{{ $product->farmer->নাম }}</a>
                        <br>
                        <small class="text-muted">{{ $product->farmer->ব্যবসার_নাম ?? $product->farmer->ঠিকানা }}</small>
                    </p>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">পণ্য বর্ণনা</h5>
                </div>
                <div class="card-body">
                    {{ $product->বর্ণনা ?? 'কোনো বর্ণনা নেই' }}
                </div>
            </div>

            <div class="alert alert-info">
                <p class="mb-0">
                    এই পণ্য কিনতে, অনুগ্রহ করে 
                    <a href="{{ route('login') }}" class="alert-link">লগইন করুন</a> বা 
                    <a href="{{ route('register') }}" class="alert-link">নিবন্ধন করুন</a>।
                </p>
            </div>

            <a href="{{ route('guest.products') }}" class="btn btn-secondary">ফিরে যান</a>
        </div>
    </div>
</div>
@endsection
