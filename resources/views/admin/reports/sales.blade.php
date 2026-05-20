@extends('layouts.app')

@section('শিরোনাম', 'বিক্রয় প্রতিবেদন')

@section('কন্টেন্ট')
<div class="container mt-4">
    <h2 class="mb-4">
        <i class="fas fa-chart-bar"></i> বিক্রয় প্রতিবেদন
    </h2>

    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('admin.sales.report') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="থেকে_তারিখ" class="form-label">থেকে তারিখ</label>
                    <input type="date" class="form-control" id="থেকে_তারিখ" name="থেকে_তারিখ" 
                           value="{{ $fromDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-3">
                    <label for="পর্যন্ত_তারিখ" class="form-label">পর্যন্ত তারিখ</label>
                    <input type="date" class="form-control" id="পর্যন্ত_তারিখ" name="পর্যন্ত_তারিখ" 
                           value="{{ $toDate->format('Y-m-d') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">ফিল্টার করুন</button>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-secondary w-100" onclick="window.print()">
                        <i class="fas fa-print"></i> প্রিন্ট করুন
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="dashboard-card">
                <p class="text-muted mb-1">মোট রাজস্ব</p>
                <p class="stat-number text-success">৳{{ number_format($totalRevenue, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <p class="text-muted mb-1">মোট অর্ডার</p>
                <p class="stat-number">{{ $totalOrders }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="dashboard-card">
                <p class="text-muted mb-1">গড় অর্ডার মূল্য</p>
                <p class="stat-number">৳{{ $totalOrders > 0 ? number_format($totalRevenue / $totalOrders, 2) : '0.00' }}</p>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>তারিখ</th>
                        <th>পণ্য</th>
                        <th>বিক্রেতা</th>
                        <th>ক্রেতা</th>
                        <th>পরিমাণ</th>
                        <th>মূল্য</th>
                        <th>মোট</th>
                        <th>অবস্থা</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($sales as $sale)
                        <tr>
                            <td>{{ $sale->created_at->format('d/m/Y') }}</td>
                            <td>{{ $sale->product->নাম }}</td>
                            <td>{{ $sale->seller->নাম }}</td>
                            <td>{{ $sale->buyer->নাম }}</td>
                            <td>{{ $sale->পরিমাণ }} {{ $sale->product->এককরণ }}</td>
                            <td>৳{{ number_format($sale->product->মূল্য, 2) }}</td>
                            <td><strong>৳{{ number_format($sale->মোট_মূল্য, 2) }}</strong></td>
                            <td>
                                <span class="badge bg-success">{{ $sale->অবস্থা }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                এই সময়ে কোনো বিক্রয় পাওয়া যায়নি
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $sales->links('pagination::bootstrap-5') }}
</div>

@section('বিশেষ_সিএসএস')
<style>
    @media print {
        .navbar, footer, .btn, form { display: none; }
        .card { box-shadow: none; border: 1px solid #ddd; }
        table { font-size: 12px; }
    }
</style>
@endsection

@endsection
