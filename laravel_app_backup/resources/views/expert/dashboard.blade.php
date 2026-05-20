<!DOCTYPE html>
<html>
<head><title>Expert Dashboard</title></head>
<body>
<h2>Expert Dashboard</h2>
@if(session('status'))<div>{{ session('status') }}</div>@endif
<x-ad-banner />
<p>Total answered issues: {{ $answeredCount }}</p>
<p>Total earnings (from ad-backed payout): {{ number_format($earnings, 2) }} BDT</p>

<h3>Pending Farmer Issues</h3>
@forelse($pendingIssues as $issue)
    <div style="border:1px solid #ddd;padding:10px;margin:10px 0;">
        <p>{{ $issue->question }}</p>
        <form method="POST" action="{{ route('expert.issue.answer', $issue) }}">
            @csrf
            <textarea name="answer" placeholder="Suggest solution" required></textarea>
            <button type="submit">Submit Solution</button>
        </form>
    </div>
@empty
    <p>No pending issues right now.</p>
@endforelse

<h3>Upload Farming Guide</h3>
<form method="POST" action="{{ route('expert.guide.store') }}">
    @csrf
    <input name="title" placeholder="Guide title" required>
    <textarea name="body" required></textarea>
    <button type="submit">Upload Guide</button>
</form>

<h3>Publish Agricultural Article</h3>
<form method="POST" action="{{ route('expert.article.store') }}">
    @csrf
    <input name="title" placeholder="Article title" required>
    <textarea name="body" required></textarea>
    <button type="submit">Publish Article</button>
</form>
</body>
</html>
