@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 1000px; margin: 40px auto; display: flex; height: 600px; border: 1px solid #ddd; border-radius: 10px; overflow: hidden; background: white;">
    
    <!-- User List -->
    <div style="width: 300px; background: #f9f9f9; border-right: 1px solid #ddd; display: flex; flex-direction: column;">
        <div style="padding: 15px; border-bottom: 1px solid #ddd; background: var(--primary-color); color: white;">
            <h3 style="margin: 0; font-size: 1.1rem;"><i class="fa-solid fa-comments"></i> চ্যাট সিস্টেম</h3>
        </div>
        <div style="overflow-y: auto; flex: 1;">
            @foreach($users as $user)
                <a href="{{ route('chat.index', $user->id) }}" style="display: flex; align-items: center; padding: 15px; border-bottom: 1px solid #eee; text-decoration: none; color: inherit; background: {{ isset($activeUser) && $activeUser->id === $user->id ? '#e8f5e9' : 'transparent' }};">
                    <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name='.urlencode($user->name) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 15px;">
                    <div>
                        <div style="font-weight: 600;">{{ $user->name }}</div>
                        <div style="font-size: 0.8rem; color: #666;">
                            {{ $user->role === 'farmer' ? 'কৃষক' : 'বিশেষজ্ঞ' }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Chat Area -->
    <div style="flex: 1; display: flex; flex-direction: column;">
        @if($activeUser)
            <!-- Chat Header -->
            <div style="padding: 15px; border-bottom: 1px solid #ddd; display: flex; align-items: center; background: white;">
                <img src="{{ $activeUser->image ? asset('storage/' . $activeUser->image) : 'https://ui-avatars.com/api/?name='.urlencode($activeUser->name) }}" alt="Avatar" style="width: 40px; height: 40px; border-radius: 50%; margin-right: 15px;">
                <div>
                    <h4 style="margin: 0;">{{ $activeUser->name }}</h4>
                    <span style="font-size: 0.8rem; color: #666;">{{ $activeUser->role === 'farmer' ? 'কৃষক' : 'বিশেষজ্ঞ' }}</span>
                </div>
            </div>

            <!-- Messages -->
            <div style="flex: 1; padding: 20px; overflow-y: auto; background: #f5f5f5;" id="chatArea">
                @foreach($messages as $msg)
                    <div style="margin-bottom: 15px; display: flex; {{ $msg->sender_id === Auth::id() ? 'justify-content: flex-end;' : 'justify-content: flex-start;' }}">
                        <div style="max-width: 70%; padding: 10px 15px; border-radius: 15px; {{ $msg->sender_id === Auth::id() ? 'background: var(--primary-color); color: white; border-bottom-right-radius: 0;' : 'background: white; border: 1px solid #ddd; border-bottom-left-radius: 0;' }}">
                            {{ $msg->message }}
                            <div style="font-size: 0.7rem; margin-top: 5px; opacity: 0.8; {{ $msg->sender_id === Auth::id() ? 'text-align: right;' : '' }}">
                                {{ $msg->created_at->format('h:i A') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Input Area -->
            <div style="padding: 15px; border-top: 1px solid #ddd; background: white;">
                <form action="{{ route('chat.send') }}" method="POST" style="display: flex;">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $activeUser->id }}">
                    <input type="text" name="message" placeholder="আপনার বার্তা লিখুন..." required style="flex: 1; padding: 10px 15px; border: 1px solid #ddd; border-radius: 20px; outline: none;">
                    <button type="submit" style="background: var(--primary-color); color: white; border: none; width: 45px; height: 45px; border-radius: 50%; margin-left: 10px; cursor: pointer;">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>
            </div>
            
            <script>
                // Auto scroll to bottom
                const chatArea = document.getElementById('chatArea');
                chatArea.scrollTop = chatArea.scrollHeight;
            </script>
        @else
            <!-- No active chat -->
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: #999;">
                <i class="fa-regular fa-comments" style="font-size: 4rem; margin-bottom: 20px;"></i>
                <h3 style="margin: 0; font-weight: normal;">বার্তা পাঠাতে বাম দিক থেকে একজনকে নির্বাচন করুন</h3>
            </div>
        @endif
    </div>

</div>
@endsection
