@extends('layouts.app')

@section('শিরোনাম', 'কৃষক ড্যাশবোর্ড')

@section('কন্টেন্ট')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-home"></i> কৃষক ড্যাশবোর্ড
    </h2>

    <!-- Stats -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">মোট পণ্য</p>
                        <p class="stat-number">{{ $totalProducts }}</p>
                    </div>
                    <i class="fas fa-box fa-3x text-primary opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">অনুমোদিত</p>
                        <p class="stat-number text-success">{{ $approvedProducts }}</p>
                    </div>
                    <i class="fas fa-check-circle fa-3x text-success opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">অপেক্ষমান</p>
                        <p class="stat-number text-warning">{{ $pendingProducts }}</p>
                    </div>
                    <i class="fas fa-clock fa-3x text-warning opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">প্রত্যাখ্যান</p>
                        <p class="stat-number text-danger">{{ $rejectedProducts }}</p>
                    </div>
                    <i class="fas fa-times-circle fa-3x text-danger opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5 class="mb-3">মোট বিক্রয়</h5>
                <p class="stat-number">{{ $totalSales }}</p>
                <p class="text-muted">সম্পন্ন অর্ডার</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-card">
                <h5 class="mb-3">মোট রাজস্ব</h5>
                <p class="stat-number text-success">৳{{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="dashboard-card">
                <h5 class="mb-3">দ্রুত অ্যাকশন</h5>
                <div class="btn-group" role="group">
                    <a href="{{ route('farmer.product.add.form') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> নতুন পণ্য যোগ করুন
                    </a>
                    <a href="{{ route('farmer.products') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list"></i> আমার পণ্য দেখুন
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
