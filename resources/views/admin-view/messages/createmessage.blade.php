@extends('layouts.admin.app')

@section('content')
    <div class="content-header">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                            {{ __('messages.Family Tree Builder') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Messages To Members</li>
                </ol>
            </nav>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
     <div class="content-body">
    <div class="component-section py-2">
        <form action="{{ route('admin.messages.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="recipient_id">Select Member</label>
                <select name="recipient_id" class="form-control" required>
                    <option value="">-- Select Member --</option>
                    @foreach ($members as $member)
                        <option value="{{ $member->id }}">{{ $member->name }} ({{ $member->email }})</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="message">Message Body</label>
                <textarea name="message" class="form-control" rows="5" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Send Message</button>
        </form>
    </div></div>
@endsection
