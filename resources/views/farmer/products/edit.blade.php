@extends('layouts.app')

@section('শিরোনাম', 'পণ্য সম্পাদনা করুন')

@section('কন্টেন্ট')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">পণ্য সম্পাদনা করুন</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('farmer.product.edit', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="নাম" class="form-label">পণ্য নাম</label>
                            <input type="text" class="form-control @error('নাম') is-invalid @enderror" 
                                   id="নাম" name="নাম" value="{{ old('নাম', $product->নাম) }}" required>
                            @error('নাম')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="বর্ণনা" class="form-label">বর্ণনা</label>
                            <textarea class="form-control @error('বর্ণনা') is-invalid @enderror" 
                                      id="বর্ণনা" name="বর্ণনা" rows="4">{{ old('বর্ণনা', $product->বর্ণনা) }}</textarea>
                            @error('বর্ণনা')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="মূল্য" class="form-label">মূল্য (৳)</label>
                                    <input type="number" step="0.01" class="form-control @error('মূল্য') is-invalid @enderror" 
                                           id="মূল্য" name="মূল্য" value="{{ old('মূল্য', $product->মূল্য) }}" required>
                                    @error('মূল্য')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="পরিমাণ" class="form-label">পরিমাণ</label>
                                    <input type="number" class="form-control @error('পরিমাণ') is-invalid @enderror" 
                                           id="পরিমাণ" name="পরিমাণ" value="{{ old('পরিমাণ', $product->পরিমাণ) }}" required>
                                    @error('পরিমাণ')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="এককরণ" class="form-label">একক</label>
                                    <input type="text" class="form-control @error('এককরণ') is-invalid @enderror" 
                                           id="এককরণ" name="এককরণ" value="{{ old('এককরণ', $product->এককরণ) }}" required>
                                    @error('এককরণ')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="বিভাগ" class="form-label">বিভাগ</label>
                                    <select class="form-select @error('বিভাগ') is-invalid @enderror" 
                                            id="বিভাগ" name="বিভাগ" required>
                                        <option value="শাকসবজি" @selected(old('বিভাগ', $product->বিভাগ) === 'শাকসবজি')>শাকসবজি</option>
                                        <option value="ফল" @selected(old('বিভাগ', $product->বিভাগ) === 'ফল')>ফল</option>
                                        <option value="শস্য" @selected(old('বিভাগ', $product->বিভাগ) === 'শস্য')>শস্য</option>
                                        <option value="দুগ্ধ" @selected(old('বিভাগ', $product->বিভাগ) === 'দুগ্ধ')>দুগ্ধ</option>
                                        <option value="মাছ" @selected(old('বিভাগ', $product->বিভাগ) === 'মাছ')>মাছ</option>
                                        <option value="অন্যান্য" @selected(old('বিভাগ', $product->বিভাগ) === 'অন্যান্য')>অন্যান্য</option>
                                    </select>
                                    @error('বিভাগ')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="ছবি" class="form-label">পণ্য ছবি</label>
                            @if ($product->ছবি)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $product->ছবি) }}" width="100" class="rounded">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('ছবি') is-invalid @enderror" 
                                   id="ছবি" name="ছবি" accept="image/*">
                            <small class="text-muted">নতুন ছবি নির্বাচন করতে এই ক্ষেত্রে ব্যবহার করুন (ঐচ্ছিক)</small>
                            @error('ছবি')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">আপডেট করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
