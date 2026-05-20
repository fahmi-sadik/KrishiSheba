@extends('layouts.app')

@section('শিরোনাম', 'প্রশাসক ড্যাশবোর্ড')

@section('কন্টেন্ট')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-chart-line"></i> প্রশাসক ড্যাশবোর্ড
    </h2>

    <!-- Stats Row -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">মোট ব্যবহারকারী</p>
                        <p class="stat-number">{{ $totalUsers }}</p>
                    </div>
                    <i class="fas fa-users fa-3x text-primary opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">কৃষক</p>
                        <p class="stat-number">{{ $totalFarmers }}</p>
                    </div>
                    <i class="fas fa-tractor fa-3x text-success opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">ক্রেতা</p>
                        <p class="stat-number">{{ $totalBuyers }}</p>
                    </div>
                    <i class="fas fa-shopping-cart fa-3x text-info opacity-50"></i>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-muted mb-1">বিশেষজ্ঞ</p>
                        <p class="stat-number">{{ $totalExperts }}</p>
                    </div>
                    <i class="fas fa-user-tie fa-3x text-warning opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Stats -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="dashboard-card">
                <h5 class="mb-3">এই মাসের বিক্রয়</h5>
                <p class="stat-number text-success">৳{{ number_format($monthlyRevenue, 2) }}</p>
                <p class="text-muted">{{ $monthlyOrders }} অর্ডার</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="dashboard-card">
                <h5 class="mb-3">অপেক্ষমান অনুমোদন</h5>
                <div class="row">
                    <div class="col-6">
                        <p class="text-muted">অপেক্ষমান পণ্য</p>
                        <p class="stat-number text-warning">{{ $pendingProducts }}</p>
                    </div>
                    <div class="col-6">
                        <p class="text-muted">অপেক্ষমান ব্যবহারকারী</p>
                        <p class="stat-number text-warning">{{ $pendingUsers }}</p>
                    </div>
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
                    <a href="{{ route('admin.users') }}" class="btn btn-outline-primary">
                        <i class="fas fa-users"></i> ব্যবহারকারী পরিচালনা করুন
                    </a>
                    <a href="{{ route('admin.sales.report') }}" class="btn btn-outline-primary">
                        <i class="fas fa-chart-bar"></i> বিক্রয় প্রতিবেদন
                    </a>
                    <a href="{{ route('admin.user.add.form') }}" class="btn btn-outline-primary">
                        <i class="fas fa-user-plus"></i> ব্যবহারকারী যোগ করুন
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="row">
        <div class="col-12">
            <div class="dashboard-card">
                <h5 class="mb-4">মাসিক বিক্রয় প্রবণতা</h5>
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>
    </div>
</div>

@section('জাভাস্ক্রিপ্ট')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('monthlyChart').getContext('2d');
    const salesData = @json($salesByMonth);
    
    const labels = [];
    const data = [];
    
    for (let i = 1; i <= 12; i++) {
        labels.push(getMonthName(i));
        const monthData = salesData.find(item => item.month == i);
        data.push(monthData ? monthData.count : 0);
    }
    
    const chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'মাসিক অর্ডার',
                data: data,
                borderColor: '#667eea',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    
    function getMonthName(month) {
        const months = ['জানু', 'ফেব', 'মার্চ', 'এপ্রি', 'মে', 'জুন', 
                        'জুল', 'আগ', 'সেপ', 'অক্টো', 'নভে', 'ডিসে'];
        return months[month - 1];
    }
</script>
@endsection

@endsection
