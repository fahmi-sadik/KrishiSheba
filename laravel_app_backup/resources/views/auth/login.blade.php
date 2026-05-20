<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h2>Login</h2>
@if(session('status'))<div>{{ session('status') }}</div>@endif
@if($errors->any())<div>{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('login.perform') }}">
    @csrf
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>
</body>
</html>
