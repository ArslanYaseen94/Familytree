@extends('layouts.admin.app')

@section('content')
<div class="content-header text-center my-4 justify-content-center">
    <h1 style="text-align:center !important">Create Type</h1>
</div>

@if (session('success'))
    <div class="alert alert-success text-center">
        {{ session('success') }}
    </div>
@endif

<div class="content-body d-flex justify-content-center">
    <div class="component-section py-4 px-3 shadow-sm border rounded w-100" style="max-width: 800px; background-color: #fff;">
        <form action="{{ route('admin.type.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $type->id ?? '' }}">
            
            <div class="form-group mb-3">
                <label for="subject" class="form-label">Name</label>
                <input type="text" name="name" id="subject" class="form-control" value="{{ $type->name ?? '' }}" required>
            </div>

            <div class="form-group form-check mb-3">
                <input type="checkbox" name="status" value="active" class="form-check-input" id="status"
                    {{ isset($type) && $type->is_active == 1 ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Active</label>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">{{ isset($type) ? 'Update' : 'Create' }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
