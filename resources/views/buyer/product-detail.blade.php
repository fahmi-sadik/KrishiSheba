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
                    <li class="breadcrumb-item"><a href="{{ route('buyer.browse') }}">পণ্য ব্রাউজ করুন</a></li>
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
                        <strong>মূল্য:</strong> <span class="h4 text-primary">৳{{ number_format($product->মূল্য, 2) }}</span> / {{ $product->এককরণ }}
                    </p>
                    <p class="mb-3">
                        <strong>উপলব্ধ পরিমাণ:</strong> {{ $product->পরিমাণ }} {{ $product->এককরণ }}
                    </p>
                    <p class="mb-3">
                        <strong>বিক্রেতা:</strong> 
                        {{ $product->farmer->নাম }}
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

            @if ($product->পরিমাণ > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">অর্ডার করুন</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('buyer.buy', $product->id) }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label for="পরিমাণ" class="form-label">পরিমাণ</label>
                                <input type="number" class="form-control @error('পরিমাণ') is-invalid @enderror" 
                                       id="পরিমাণ" name="পরিমাণ" min="1" max="{{ $product->পরিমাণ }}" 
                                       value="1" required>
                                <small class="text-muted">সর্বোচ্চ উপলব্ধ: {{ $product->পরিমাণ }} {{ $product->এককরণ }}</small>
                                @error('পরিমাণ')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="ডেলিভারি_ঠিকানা" class="form-label">ডেলিভারি ঠিকানা</label>
                                <textarea class="form-control @error('ডেলিভারি_ঠিকানা') is-invalid @enderror" 
                                          id="ডেলিভারি_ঠিকানা" name="ডেলিভারি_ঠিকানা" rows="3" required>{{ old('ডেলিভারি_ঠিকানা', auth()->user()->ঠিকানা) }}</textarea>
                                @error('ডেলিভারি_ঠিকানা')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="alert alert-info">
                                <p class="mb-0">
                                    <strong>মোট মূল্য:</strong> 
                                    <span id="totalPrice" class="h5">৳<span id="priceAmount">{{ $product->মূল্য }}</span></span>
                                </p>
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="fas fa-shopping-cart"></i> অর্ডার করুন
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> এই পণ্য বর্তমানে স্টকে নেই।
                </div>
            @endif

            <a href="{{ route('buyer.browse') }}" class="btn btn-secondary mt-3">ফিরে যান</a>
        </div>
    </div>
</div>

@section('জাভাস্ক্রিপ্ট')
<script>
    document.getElementById('পরিমাণ').addEventListener('change', function() {
        const quantity = parseInt(this.value) || 1;
        const price = {{ $product->মূল্য }};
        const total = quantity * price;
        document.getElementById('priceAmount').innerText = total.toFixed(2);
    });
</script>
@endsection

@endsection
