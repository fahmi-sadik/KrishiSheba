@extends('layouts.app')

@section('শিরোনাম', 'ব্যবহারকারী বিস্তারিত')

@section('কন্টেন্ট')
<div class="container mt-4">
    <a href="{{ route('admin.users') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> ফিরে যান
    </a>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    @if ($user->প্রোফাইল_ছবি)
                        <img src="{{ asset('storage/' . $user->প্রোফাইল_ছবি) }}" class="rounded-circle mb-3" width="150" height="150" alt="{{ $user->নাম }}">
                    @else
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-5x text-muted"></i>
                        </div>
                    @endif
                    <h4>{{ $user->নাম }}</h4>
                    <p class="text-muted">{{ $user->ভূমিকা }}</p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">যোগাযোগ তথ্য</h5>
                </div>
                <div class="card-body">
                    <p class="mb-2">
                        <strong>ইমেইল:</strong><br>
                        {{ $user->ইমেইল }}
                    </p>
                    <p class="mb-2">
                        <strong>ফোন:</strong><br>
                        {{ $user->ফোন }}
                    </p>
                    <p>
                        <strong>ঠিকানা:</strong><br>
                        {{ $user->ঠিকানা }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">অ্যাকাউন্ট তথ্য</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>ভূমিকা:</strong><br>
                                <span class="badge bg-primary">{{ $user->ভূমিকা }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-3">
                                <strong>অনুমোদন:</strong><br>
                                @if ($user->অনুমোদিত)
                                    <span class="badge bg-success">অনুমোদিত</span>
                                @else
                                    <span class="badge bg-warning">অপেক্ষমান</span>
                                @endif
                            </p>
                        </div>
                    </div>
                    <p>
                        <strong>বায়ো:</strong><br>
                        {{ $user->বায়ো ?? 'কোনো বায়ো নেই' }}
                    </p>
                    @if ($user->ব্যবসার_নাম)
                        <p>
                            <strong>ব্যবসার নাম:</strong><br>
                            {{ $user->ব্যবসার_নাম }}
                        </p>
                    @endif
                </div>
            </div>

            @if ($user->isFarmer() && $products)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">পণ্য ({{ $products->total() }})</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>পণ্য নাম</th>
                                    <th>মূল্য</th>
                                    <th>পরিমাণ</th>
                                    <th>অবস্থা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $product->নাম }}</td>
                                        <td>৳{{ number_format($product->মূল্য, 2) }}</td>
                                        <td>{{ $product->পরিমাণ }} {{ $product->এককরণ }}</td>
                                        <td>
                                            <span class="badge bg-{{ $product->অবস্থা === 'অনুমোদিত' ? 'success' : 'warning' }}">
                                                {{ $product->অবস্থা }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">কোনো পণ্য নেই</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">বিক্রয় ({{ $sales->total() }})</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>পণ্য</th>
                                    <th>ক্রেতা</th>
                                    <th>পরিমাণ</th>
                                    <th>মোট</th>
                                    <th>অবস্থা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sales as $sale)
                                    <tr>
                                        <td>{{ $sale->product->নাম }}</td>
                                        <td>{{ $sale->buyer->নাম }}</td>
                                        <td>{{ $sale->পরিমাণ }}</td>
                                        <td>৳{{ number_format($sale->মোট_মূল্য, 2) }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $sale->অবস্থা }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">কোনো বিক্রয় নেই</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if ($user->isBuyer() && isset($purchases))
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">ক্রয় ({{ $purchases->total() }})</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>পণ্য</th>
                                    <th>বিক্রেতা</th>
                                    <th>পরিমাণ</th>
                                    <th>মোট</th>
                                    <th>অবস্থা</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->product->নাম }}</td>
                                        <td>{{ $purchase->seller->নাম }}</td>
                                        <td>{{ $purchase->পরিমাণ }}</td>
                                        <td>৳{{ number_format($purchase->মোট_মূল্য, 2) }}</td>
                                        <td>
                                            <span class="badge bg-info">{{ $purchase->অবস্থা }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted">কোনো ক্রয় নেই</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
