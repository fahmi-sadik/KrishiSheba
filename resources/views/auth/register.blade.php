@extends('layouts.app')

@section('শিরোনাম', 'নিবন্ধন')

@section('কন্টেন্ট')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-user-plus"></i> নতুন অ্যাকাউন্ট তৈরি করুন
                    </h3>

                    <form action="{{ route('register.submit') }}" method="POST">
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
                            <label for="ফোন" class="form-label">ফোন নম্বর</label>
                            <input type="text" class="form-control @error('ফোন') is-invalid @enderror" 
                                   id="ফোন" name="ফোন" value="{{ old('ফোন') }}" required>
                            @error('ফোন')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ঠিকানা" class="form-label">ঠিকানা</label>
                            <textarea class="form-control @error('ঠিকানা') is-invalid @enderror" 
                                      id="ঠিকানা" name="ঠিকানা" rows="2" required>{{ old('ঠিকানা') }}</textarea>
                            @error('ঠিকানা')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="ভূমিকা" class="form-label">আপনার ভূমিকা নির্বাচন করুন</label>
                            <select class="form-select @error('ভূমিকা') is-invalid @enderror" 
                                    id="ভূমিকা" name="ভূমিকা" required>
                                <option value="">-- নির্বাচন করুন --</option>
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

                        <div class="mb-3">
                            <label for="পাসওয়ার্ড_নিশ্চিতকরণ" class="form-label">পাসওয়ার্ড নিশ্চিত করুন</label>
                            <input type="password" class="form-control" id="পাসওয়ার্ড_নিশ্চিতকরণ" 
                                   name="পাসওয়ার্ড_confirmation" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">নিবন্ধন করুন</button>
                        </div>
                    </form>

                    <hr>

                    <p class="text-center">
                        ইতিমধ্যে অ্যাকাউন্ট আছে? <a href="{{ route('login') }}">লগইন করুন</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
