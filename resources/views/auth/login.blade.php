@extends('layouts.app')

@section('শিরোনাম', 'লগইন')

@section('কন্টেন্ট')
<div class="container">
    <div class="row justify-content-center mt-5">
        <div class="col-md-5">
            <div class="card">
                <div class="card-body p-5">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-sign-in-alt"></i> লগইন করুন
                    </h3>

                    <form action="{{ route('login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="ইমেইল" class="form-label">ইমেইল</label>
                            <input type="email" class="form-control @error('ইমেইল') is-invalid @enderror" 
                                   id="ইমেইল" name="ইমেইল" value="{{ old('ইমেইল') }}" required>
                            @error('ইমেইল')
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
                            <button type="submit" class="btn btn-primary btn-lg">লগইন করুন</button>
                        </div>
                    </form>

                    <hr>

                    <p class="text-center">
                        এখনও অ্যাকাউন্ট নেই? <a href="{{ route('register') }}">নিবন্ধন করুন</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
