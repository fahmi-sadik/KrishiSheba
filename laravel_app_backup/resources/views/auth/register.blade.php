<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h2>Register</h2>
@if($errors->any())<div>{{ $errors->first() }}</div>@endif
<form method="POST" action="{{ route('register.perform') }}" enctype="multipart/form-data">
    @csrf
    <input name="name" placeholder="Name" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <input name="password_confirmation" type="password" placeholder="Confirm Password" required>
    <select name="role" required>
        <option value="buyer">Buyer</option>
        <option value="farmer">Farmer</option>
        <option value="expert">Expert (কৃষি বিশেষজ্ঞ)</option>
    </select>
    <textarea name="delivery_address" placeholder="Delivery address"></textarea>
    <input name="experience_years" type="number" placeholder="Experience years (expert)">
    <label>Academic Certificate</label><input type="file" name="certificate_file">
    <label>Paperwork</label><input type="file" name="paperwork_file">
    <button type="submit">Register</button>
</form>
</body>
</html>
