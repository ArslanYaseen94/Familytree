@extends('layouts.admin.app')

@section('content')
<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.messages.create') }}">Messages</a></li>
                <li class="breadcrumb-item active" aria-current="page">View Ticket</li>
            </ol>
        </nav>
    </div>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card mb-4">
    <div class="card-header">
        <h4>{{ $message->subject }}</h4>
    </div>
    <div class="card-body">
        <p><strong>From:</strong> {{ $message->sender ? $message->sender->name : 'Admin' }}</p>
        <p><strong>To:</strong> {{ $message->recipient ? $message->recipient->name : 'User' }}</p>
        <hr>
        <p>{!! nl2br(e($message->body)) !!}</p>
    </div>
</div>

@if ($message->replies && $message->replies->count() > 0)
    <div class="card mb-4">
        <div class="card-header">
            <h5>Conversation</h5>
        </div>
        <div class="card-body">
            @foreach ($message->replies as $reply)
                <div class="d-flex mb-4 {{ $reply->sender_id == 0 ? 'justify-content-end' : '' }}">
                    <div class="p-3 rounded shadow-sm {{ $reply->sender_id == 0 ? 'bg-primary text-white text-end' : 'bg-light text-dark' }}" style="max-width: 75%;">
                        <p class="mb-1">
                            <strong>{{ $reply->sender_id == 0 ? 'Admin' : ($reply->sender->name ?? 'User') }}</strong>
                            <br>
                            <small class="text-muted">{{ $reply->created_at->format('d M Y, h:i A') }}</small>
                        </p>
                        <p class="mb-0">{!! nl2br(e($reply->body)) !!}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif


<div class="card">
    <div class="card-header">
        <h5>Send a Reply</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.messages.reply', $message->id) }}">
            @csrf
            <div class="form-group mb-3">
                <textarea name="reply_body" class="form-control" rows="5" placeholder="Type your reply here..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Send Reply</button>
        </form>
    </div>
</div>
@endsection
