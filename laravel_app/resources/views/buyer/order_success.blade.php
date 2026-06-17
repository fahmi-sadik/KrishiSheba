@extends('layouts.app')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; background: #f8fcf8;">
    <div style="background: white; padding: 50px; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); text-align: center; max-width: 500px; width: 100%;">
        <div style="width: 80px; height: 80px; background: #e8f5e9; color: #2e7d32; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 40px; margin: 0 auto 20px;">
            <i class="fa-solid fa-check"></i>
        </div>
        <h1 style="font-family: 'Hind Siliguri', sans-serif; font-size: 2rem; color: #2c3e50; margin-bottom: 15px;">অর্ডার সফল হয়েছে!</h1>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px; line-height: 1.6;">
            ধন্যবাদ! আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে। খুব শিগগিরই আমাদের প্রতিনিধি আপনার সাথে যোগাযোগ করবেন।
        </p>
        
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="{{ route('buyer.dashboard') }}" style="background: var(--primary-color); color: white; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 600; font-family: 'Hind Siliguri', sans-serif; transition: 0.3s;" onmouseover="this.style.background='#1b5e20'" onmouseout="this.style.background='var(--primary-color)'">
                <i class="fa-solid fa-store"></i> আরও কেনাকাটা করুন
            </a>
            <a href="{{ route('buyer.dashboard') }}" style="background: white; color: var(--text-dark); border: 1px solid #ddd; padding: 12px 25px; border-radius: 30px; text-decoration: none; font-weight: 600; font-family: 'Hind Siliguri', sans-serif; transition: 0.3s;" onmouseover="this.style.background='#f0f0f0'" onmouseout="this.style.background='white'">
                <i class="fa-solid fa-list-check"></i> ড্যাশবোর্ডে ফিরুন
            </a>
        </div>
    </div>
</div>
@endsection
