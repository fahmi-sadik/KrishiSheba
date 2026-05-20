<!DOCTYPE html>
<html>
<head><title>Admin Dashboard</title></head>
<body>
<h2>Admin Dashboard - Expert Approval</h2>
@if(session('status'))<div>{{ session('status') }}</div>@endif
<x-ad-banner />

<h3>Pending Experts</h3>
@forelse($pendingExperts as $expert)
    <div style="border:1px solid #ccc;padding:10px;margin:8px 0;">
        <p><strong>{{ $expert->name }}</strong> ({{ $expert->email }})</p>
        <p>Experience: {{ $expert->experience_years ?? 0 }} years</p>
        <p>Certificate: {{ $expert->expertDocument?->certificate_path ?? 'N/A' }}</p>
        <p>Paperwork: {{ $expert->expertDocument?->paperwork_path ?? 'N/A' }}</p>
        <form method="POST" action="{{ route('admin.expert.approve', $expert) }}">
            @csrf
            <button type="submit">Approve</button>
        </form>
    </div>
@empty
    <p>No pending experts.</p>
@endforelse

<h3>Create Advertisement</h3>
<form method="POST" action="{{ route('admin.ad.store') }}">
    @csrf
    <input name="title" placeholder="Ad title" required>
    <input name="content" placeholder="Ad content" required>
    <input name="target_url" placeholder="Target URL">
    <button type="submit">Publish Ad</button>
</form>
</body>
</html>
