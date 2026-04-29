@extends('layouts.app')

@section('শিরোনাম', 'পণ্য ব্রাউজ করুন')

@section('কন্টেন্ট')
<div class="container mt-4">
    <h2 class="mb-4">পণ্য ব্রাউজ করুন</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <form action="{{ route('buyer.browse') }}" method="GET">
                <div class="mb-3">
                    <label for="বিভাগ" class="form-label">বিভাগ</label>
                    <select class="form-select" id="বিভাগ" name="বিভাগ">
                        <option value="">সব বিভাগ</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category }}" @selected(request('বিভাগ') === $category)>
                                {{ $category }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="অনুসন্ধান" class="form-label">অনুসন্ধান</label>
                    <input type="text" class="form-control" id="অনুসন্ধান" name="অনুসন্ধান" 
                           placeholder="পণ্য অনুসন্ধান করুন..." value="{{ request('অনুসন্ধান') }}">
                </div>
                <button type="submit" class="btn btn-primary w-100">ফিল্টার করুন</button>
            </form>
        </div>

        <div class="col-md-9">
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card h-100">
                            @if ($product->ছবি)
                                <img src="{{ asset('storage/' . $product->ছবি) }}" class="card-img-top product-image" alt="{{ $product->নাম }}">
                            @else
                                <div class="product-image bg-light d-flex align-items-center justify-content-center">
                                    <i class="fas fa-image fa-4x text-muted"></i>
                                </div>
                            @endif
                            <span class="badge bg-success badge-status">{{ $product->বিভাগ }}</span>
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->নাম }}</h5>
                                <p class="card-text text-muted small">{{ Str::limit($product->বর্ণনা, 60) }}</p>
                                <p class="mb-2">
                                    <strong>মূল্য:</strong> ৳{{ number_format($product->মূল্য, 2) }}
                                </p>
                                <p class="mb-2">
                                    <strong>উপলব্ধ:</strong> {{ $product->পরিমাণ }} {{ $product->এককরণ }}
                                </p>
                                <p class="mb-3 small text-muted">
                                    <strong>বিক্রেতা:</strong> {{ $product->farmer->নাম }}
                                </p>
                                <a href="{{ route('buyer.product', $product->id) }}" class="btn btn-sm btn-primary w-100">
                                    বিস্তারিত দেখুন
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-search fa-2x mb-3"></i>
                            <p class="mb-0">আপনার অনুসন্ধানের সাথে মেলে এমন কোনো পণ্য পাওয়া যায়নি।</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
