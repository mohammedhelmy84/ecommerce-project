@extends('layouts.admin')

@section('title', 'الاشعارات')

@section('content')
<div class="container">
    <h3>الإشعارات</h3>
    <ul class="list-group">
        @forelse($notifications as $notification)
            <li class="list-group-item">
                <strong>{{ $notification->data['title'] ?? 'إشعار' }}</strong>
                <p>{{ $notification->data['message'] ?? '' }}</p>
                <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
            </li>
        @empty
            <li class="list-group-item text-center text-muted">لا توجد إشعارات حالياً</li>
        @endforelse
    </ul>
</div>
@endsection
