@extends('layouts.user.app')
@section('content')
<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="container">
                <div class="card-header bg-primary text-white rounded-4">
                    <h4 class="mb-0 p-4"> {{ __('messages.Templates') }}</h4>
                </div>
                <div class="card shadow rounded-4 mt-3">
                    <div class="card-body mt-3">
                        <form action="{{ route('user.templates.store') }}" method="POST">
                            @csrf
                            <div class="row mb-3">
                                <label class="form-label"> {{ __('messages.Choose Template') }}</label>
                                @foreach ($templates as $template)


                                <div class="col-md-6 text-center">
                                    <label>
                                        <div class="d-flex align-items-center justify-content-center" style="gap: 2rem">
                                            <input type="radio" name="template" value="{{$template->name}}"
                                                {{ auth()->user()->template == 'horizontal' ? 'checked' : '' }}
                                                required>
                                            <div> {{ $template->name }}</div>
                                        </div>
                                        <img src="{{ asset($template->image) }}"
                                            alt="Horizontal Template" class="img-fluid border rounded mt-2"
                                            style="max-width: 100%;height:385px">
                                    </label>
                                </div>
                                @endforeach
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="contains_user_image" {{ auth()->user()->has_image == '1' ? 'checked' : '' }} class="form-check-input" id="containsUserImage">
                                <label class="form-check-label" for="containsUserImage"> {{ __('messages.Contains User Image') }}</label>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success px-4"> {{ __('messages.Submit') }}</button>
                                <a href="{{ url()->previous() }}" class="btn btn-secondary px-4"> {{ __('messages.Cancel') }}</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection