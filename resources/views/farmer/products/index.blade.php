@extends('layouts.app')

@section('শিরোনাম', 'আমার পণ্য')

@section('কন্টেন্ট')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>আমার পণ্য</h2>
        <a href="{{ route('farmer.product.add.form') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> নতুন পণ্য যোগ করুন
        </a>
    </div>

    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if ($product->ছবি)
                        <img src="{{ asset('storage/' . $product->ছবি) }}" class="card-img-top product-image" alt="{{ $product->নাম }}">
                    @else
                        <div class="product-image bg-light d-flex align-items-center justify-content-center">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    @endif
                    <span class="badge {{ $product->অবস্থা === 'অনুমোদিত' ? 'bg-success' : ($product->অবস্থা === 'অপেক্ষমান' ? 'bg-warning' : 'bg-danger') }} badge-status">
                        {{ $product->অবস্থা }}
                    </span>
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->নাম }}</h5>
                        <p class="text-muted small">{{ Str::limit($product->বর্ণনা, 60) }}</p>
                        <div class="mb-3">
                            <p class="mb-2">
                                <strong>মূল্য:</strong> ৳{{ number_format($product->মূল্য, 2) }}
                            </p>
                            <p class="mb-2">
                                <strong>পরিমাণ:</strong> {{ $product->পরিমাণ }} {{ $product->এককরণ }}
                            </p>
                            <p class="mb-2">
                                <strong>বিভাগ:</strong> {{ $product->বিভাগ }}
                            </p>
                        </div>

                        @if ($product->অবস্থা === 'নিরস্ত করা')
                            <div class="alert alert-warning mb-3" role="alert">
                                <small><strong>প্রত্যাখ্যানের কারণ:</strong> {{ $product->প্রত্যাখ্যানের_কারণ }}</small>
                            </div>
                        @endif

                        <div class="btn-group w-100" role="group">
                            <a href="{{ route('farmer.product.edit.form', $product->id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> সম্পাদনা
                            </a>
                            <form action="{{ route('farmer.product.delete', $product->id) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('মুছে ফেলতে চান?')">
                                    <i class="fas fa-trash"></i> মুছুন
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <p class="mb-0">এখনও কোনো পণ্য যোগ করা হয়নি।</p>
                    <a href="{{ route('farmer.product.add.form') }}" class="btn btn-primary btn-sm mt-3">প্রথম পণ্য যোগ করুন</a>
                </div>
            </div>
        @endforelse
    </div>

    {{ $products->links('pagination::bootstrap-5') }}
</div>
@endsection
