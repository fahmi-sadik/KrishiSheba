@extends('layouts.app')

@section('শিরোনাম', 'আমার অর্ডার')

@section('কন্টেন্ট')
<div class="container mt-4">
    <h2 class="mb-4">আমার অর্ডার</h2>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>পণ্য</th>
                        <th>বিক্রেতা</th>
                        <th>পরিমাণ</th>
                        <th>মোট মূল্য</th>
                        <th>অর্ডার তারিখ</th>
                        <th>অবস্থা</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td>
                                <strong>{{ $order->product->নাম }}</strong><br>
                                <small class="text-muted">{{ $order->product->বিভাগ }}</small>
                            </td>
                            <td>{{ $order->seller->নাম }}</td>
                            <td>{{ $order->পরিমাণ }} {{ $order->product->এককরণ }}</td>
                            <td><strong>৳{{ number_format($order->মোট_মূল্য, 2) }}</strong></td>
                            <td>{{ $order->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if ($order->অবস্থা === 'ডেলিভার_করা')
                                    <span class="badge bg-success">{{ $order->অবস্থা }}</span>
                                @elseif ($order->অবস্থা === 'অর্ডার_রাখা')
                                    <span class="badge bg-warning">{{ $order->অবস্থা }}</span>
                                @elseif ($order->অবস্থা === 'নিশ্চিত')
                                    <span class="badge bg-info">{{ $order->অবস্থা }}</span>
                                @else
                                    <span class="badge bg-danger">{{ $order->অবস্থা }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#detailsModal{{ $order->id }}">
                                        <i class="fas fa-eye"></i> বিস্তারিত
                                    </button>
                                    @if ($order->অবস্থা === 'অর্ডার_রাখা')
                                        <form action="{{ route('buyer.order.cancel', $order->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('বাতিল করতে চান?')">
                                                <i class="fas fa-times"></i> বাতিল
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Details Modal -->
                        <div class="modal fade" id="detailsModal{{ $order->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">অর্ডার বিস্তারিত</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>পণ্য:</strong> {{ $order->product->নাম }}</p>
                                        <p><strong>বিক্রেতা:</strong> {{ $order->seller->নাম }}</p>
                                        <p><strong>ডেলিভারি ঠিকানা:</strong> {{ $order->ডেলিভারি_ঠিকানা }}</p>
                                        <p><strong>পরিমাণ:</strong> {{ $order->পরিমাণ }} {{ $order->product->এককরণ }}</p>
                                        <p><strong>একক মূল্য:</strong> ৳{{ number_format($order->product->মূল্য, 2) }}</p>
                                        <p><strong>মোট মূল্য:</strong> ৳{{ number_format($order->মোট_মূল্য, 2) }}</p>
                                        <p><strong>অবস্থা:</strong> {{ $order->অবস্থা }}</p>
                                        <p><strong>অর্ডার তারিখ:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="fas fa-shopping-bag fa-3x mb-3"></i>
                                <p>এখনও কোনো অর্ডার করা হয়নি।</p>
                                <a href="{{ route('buyer.browse') }}" class="btn btn-primary btn-sm mt-3">পণ্য ব্রাউজ করুন</a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $orders->links('pagination::bootstrap-5') }}
</div>
@endsection
