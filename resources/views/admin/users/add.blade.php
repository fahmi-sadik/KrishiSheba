@extends('layouts.app')

@section('শিরোনাম', 'নতুন ব্যবহারকারী যোগ করুন')

@section('কন্টেন্ট')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">নতুন ব্যবহারকারী যোগ করুন</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('admin.user.add') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="নাম" class="form-label">নাম</label>
                            <input type="text" class="form-control @error('নাম') is-invalid @enderror" 
                                   id="নাম" name="নাম" value="{{ old('নাম') }}" required>
                            @error('নাম')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ইমেইল" class="form-label">ইমেইল</label>
                            <input type="email" class="form-control @error('ইমেইল') is-invalid @enderror" 
                                   id="ইমেইল" name="ইমেইল" value="{{ old('ইমেইল') }}" required>
                            @error('ইমেইল')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ফোন" class="form-label">ফোন</label>
                            <input type="text" class="form-control @error('ফোন') is-invalid @enderror" 
                                   id="ফোন" name="ফোন" value="{{ old('ফোন') }}" required>
                            @error('ফোন')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ঠিকানা" class="form-label">ঠিকানা</label>
                            <textarea class="form-control @error('ঠিকানা') is-invalid @enderror" 
                                      id="ঠিকানা" name="ঠিকানা" rows="3" required>{{ old('ঠিকানা') }}</textarea>
                            @error('ঠিকানা')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ভূমিকা" class="form-label">ভূমিকা</label>
                            <select class="form-select @error('ভূমিকা') is-invalid @enderror" 
                                    id="ভূমিকা" name="ভূমিকা" required>
                                <option value="">-- নির্বাচন করুন --</option>
                                <option value="প্রশাসক" @selected(old('ভূমিকা') === 'প্রশাসক')>প্রশাসক</option>
                                <option value="কৃষক" @selected(old('ভূমিকা') === 'কৃষক')>কৃষক</option>
                                <option value="ক্রেতা" @selected(old('ভূমিকা') === 'ক্রেতা')>ক্রেতা</option>
                                <option value="বিশেষজ্ঞ" @selected(old('ভূমিকা') === 'বিশেষজ্ঞ')>বিশেষজ্ঞ</option>
                            </select>
                            @error('ভূমিকা')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="পাসওয়ার্ড" class="form-label">পাসওয়ার্ড</label>
                            <input type="password" class="form-control @error('পাসওয়ার্ড') is-invalid @enderror" 
                                   id="পাসওয়ার্ড" name="পাসওয়ার্ড" required>
                            @error('পাসওয়ার্ড')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">যোগ করুন</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
