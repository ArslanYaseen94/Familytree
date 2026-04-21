@extends('layouts.user.app')
@section('content')
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="container">
                    <div class="card-header bg-primary text-white rounded-4">
                        <h4 class="mb-0 p-4">General Details</h4>
                    </div>
                    <div class="card shadow rounded-4 mt-3">
                        <div class="card-body mt-3">
                            <form action="{{ route('user.general.update') }}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Site Url</label>
                                        <input type="text" name="name" value="{{$user->site_url}}" class="form-control"
                                             required>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-success px-4">Update</button>
                                    <a href="{{ url()->previous() }}" class="btn btn-secondary px-4">Cancel</a>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
