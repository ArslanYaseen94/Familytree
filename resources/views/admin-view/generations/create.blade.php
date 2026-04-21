@extends('layouts.admin.app')

@section('content')
<div class="content-header justify-content-center">
    <h1>Create Generation</h1>
</div>

@if (session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif
<div class="content-body d-flex justify-content-center">
    <div class="component-section py-4 px-3 shadow-sm border rounded w-100" style="max-width: 800px; background-color: #fff;">
        <form action="{{ route('admin.generations.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $type->id ?? "" }}">
            <div class="form-group">
                <label for="subject">Name</label>
                <input type="text" name="name" class="form-control" value="{{ $type->name ?? "" }}" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <input type="checkbox" name="status" value="active" {{isset($type) ? $type->is_active == 1 ? 'checked' : '' :"" }}> Active
            </div>
            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>
@endsection