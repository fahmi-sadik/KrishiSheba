<!DOCTYPE html>
<html>
<head><title>Farmer Issue</title></head>
<body>
<h2>Submit Farming Issue</h2>
@if(session('status'))<div>{{ session('status') }}</div>@endif
<x-ad-banner />
<form method="POST" action="{{ route('farmer.issue.store') }}">
    @csrf
    <textarea name="question" placeholder="Describe your crop problem" required></textarea>
    <button type="submit">Submit</button>
</form>
</body>
</html>
