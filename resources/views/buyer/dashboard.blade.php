@extends('layouts.app')

@section('শিরোনাম', 'ক্রেতা ড্যাশবোর্ড')

@section('কন্টেন্ট')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-home"></i> ক্রেতা ড্যাশবোর্ড
    </h2>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">মোট ক্রয়</p>
                        <p class="stat-number">{{ $totalPurchases }}</p>
                    </div>
                    <i class="fas fa-shopping-bag fa-3x text-primary opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">মোট ব্যয়</p>
                        <p class="stat-number text-success">৳{{ number_format($totalSpent, 2) }}</p>
                    </div>
                    <i class="fas fa-money-bill fa-3x text-success opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">অপেক্ষমান</p>
                        <p class="stat-number text-warning">{{ $pendingOrders }}</p>
                    </div>
                    <i class="fas fa-hourglass fa-3x text-warning opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">ডেলিভারিকৃত</p>
                        <p class="stat-number text-info">{{ $deliveredOrders }}</p>
                    </div>
                    <i class="fas fa-check-circle fa-3x text-info opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <h5 class="mb-3">দ্রুত অ্যাকশন</h5>
                <div class="btn-group" role="group">
                    <a href="{{ route('buyer.browse') }}" class="btn btn-primary">
                        <i class="fas fa-store"></i> পণ্য ব্রাউজ করুন
                    </a>
                    <a href="{{ route('buyer.orders') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> আমার অর্ডার
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
