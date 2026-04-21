@extends('layouts.user.app')
@section('content')
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="container">
                    <div class="card-header bg-primary text-white rounded-4">
                        <h4 class="mb-0 p-4"> {{ __('messages.Social Media') }}</h4>
                    </div>
                    <div class="card shadow rounded-4 mt-3">
                        <div class="card-body mt-3">
                            <form action="{{route("user.socialstores")}}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="facebook" class="form-label"> {{ __('messages.Facebook') }}</label>
                                        <input type="text" name="facebook" class="form-control"
                                            placeholder="{{ __('messages.Enter Facebook') }}" value="{{$socials->facebook ?? ""}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="twitter" class="form-label"> {{ __('messages.Twitter') }}</label>
                                        <input type="text" name="twitter" class="form-control"
                                            placeholder="{{ __('messages.Enter Twitter') }}" value="{{$socials->twitter ?? ""}}" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="linkedin" class="form-label"> {{ __('messages.Linkedin') }}</label>
                                        <input type="text" name="linkedin" class="form-control"
                                            placeholder="{{ __('messages.Enter Linkedin') }}" value="{{$socials->linkedin ?? ""}}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="instagram" class="form-label"> {{ __('messages.Instagram') }}</label>
                                        <input type="text" name="instagram" value="{{$socials->instagram ?? ""}}" class="form-control" required
                                            placeholder="{{ __('messages.Enter Instagram') }}">
                                    </div>
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
