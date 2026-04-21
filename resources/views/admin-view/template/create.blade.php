@extends('layouts.admin.app')

@section('content')
<div class="content-header justify-content-center">
    <h1>Create Template</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="content-body d-flex justify-content-center">
    <div class="component-section py-4 px-3 shadow-sm border rounded w-100" style="max-width: 800px; background-color: #fff;">
        <form action="{{ route('admin.template.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $template->id ?? "" }}">
            <div class="form-group">
                <label for="subject">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $template->name ?? "" }}" required>
            </div>

            <div class="form-group">
                <label for="status">Image</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            @if (isset($template) && $template->image)
            <div class="form-group">
                <label>Current Image</label>
                <img src="{{ asset($template->image) }}" alt="Current Image" class="img-thumbnail" width="400">
            @endif
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection