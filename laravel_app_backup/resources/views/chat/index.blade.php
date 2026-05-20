<!DOCTYPE html>
<html>
<head><title>Chat</title></head>
<body>
<h2>Farmer / Expert Chat</h2>
@if(session('status'))<div>{{ session('status') }}</div>@endif
<x-ad-banner />
<form method="POST" action="{{ route('chat.send') }}">
    @csrf
    <select name="receiver_id" required>
        @foreach($expertList as $expert)
            <option value="{{ $expert->id }}">{{ $expert->name }} (Expert)</option>
        @endforeach
    </select>
    <textarea name="message" required></textarea>
    <button type="submit">Send</button>
</form>

<h3>Recent Messages</h3>
@foreach($messages as $msg)
    <p><strong>{{ $msg->sender_id }}</strong> to <strong>{{ $msg->receiver_id }}</strong>: {{ $msg->message }}</p>
@endforeach
</body>
</html>
