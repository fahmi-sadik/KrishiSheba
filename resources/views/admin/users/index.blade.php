@extends('layouts.app')

@section('শিরোনাম', 'ব্যবহারকারী পরিচালনা')

@section('কন্টেন্ট')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>ব্যবহারকারী পরিচালনা</h2>
        <a href="{{ route('admin.user.add.form') }}" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> নতুন ব্যবহারকারী যোগ করুন
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>নাম</th>
                        <th>ইমেইল</th>
                        <th>ফোন</th>
                        <th>ভূমিকা</th>
                        <th>অনুমোদন</th>
                        <th>অ্যাকশন</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>
                                <strong>{{ $user->নাম }}</strong>
                            </td>
                            <td>{{ $user->ইমেইল }}</td>
                            <td>{{ $user->ফোন }}</td>
                            <td>
                                <span class="badge bg-info">{{ $user->ভূমিকা }}</span>
                            </td>
                            <td>
                                @if ($user->অনুমোদিত)
                                    <span class="badge bg-success">অনুমোদিত</span>
                                @else
                                    <span class="badge bg-warning">অপেক্ষমান</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.user.view', $user->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i> দেখুন
                                </a>
                                @if (!$user->অনুমোদিত && $user->ভূমিকা !== 'প্রশাসক')
                                    <form action="{{ route('admin.user.approve', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('অনুমোদন করতে চান?')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">কোনো ব্যবহারকারী পাওয়া যায়নি</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $users->links('pagination::bootstrap-5') }}
</div>
@endsection
