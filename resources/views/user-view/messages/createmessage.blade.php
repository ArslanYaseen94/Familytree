@extends('layouts.user.app')
@section('content')
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="container">
                    <div class="card-header bg-primary text-white rounded-4">
                        <h4 class="mb-0 p-4"> {{ __('messages.Create a Message') }}</h4>
                    </div>
                    <div class="card shadow rounded-4 mt-3">
                        <div class="card-body mt-3">
                            <form action="{{ route('user.message.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="category_id" class="form-label"> {{ __('messages.Members') }}</label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">--  {{ __('messages.Select Member') }} --</option>
                                        @foreach ($members as $member)
                                            <option value="{{ $member->id }}">{{ $member->firstname }}
                                                {{ $member->lastname }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label"> {{ __('messages.Subject') }}</label>
                                    <input name="subject" class="form-control" required placeholder="{{ __('messages.Subject') }}" />
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label"> {{ __('messages.Message') }}</label>
                                    <textarea name="message" class="form-control" rows="7" placeholder="{{ __('messages.Message') }}"></textarea>
                                </div>
                                <div class="d-flex align-items-center justify-content-end"> 
                                    <button type="submit" class="btn btn-success"> {{ __('messages.Submit') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
