@extends('layouts.user.app')
@section('content')
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="container">
                    <div class="card-header bg-primary text-white rounded-4">
                        <h4 class="mb-0 p-4"> {{ __('messages.Security Details') }}</h4>
                    </div>
                    <div class="card shadow rounded-4 mt-3">
                        <div class="card-body mt-3">
                            <form action="{{route('user.profile.update')}}" method="POST">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label"> {{ __('messages.Full Name') }}</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name', $user->name) }}" required placeholder="{{ __('messages.Enter Your Name') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label"> {{ __('messages.Email Address') }}</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $user->email) }}" required placeholder="{{ __('messages.Enter Your Email') }}">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label"> {{ __('messages.Phone Number') }}</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone', $user->phone) }}" placeholder="{{ __('messages.Enter Your Phone') }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="dob" class="form-label"> {{ __('messages.Date of Birth') }}</label>
                                        <input type="date" name="dob" class="form-control"
                                            value="{{ old('dob', $user->bday) }}">
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h5> {{ __('messages.Change Password (optional)') }}</h5>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="current_password" class="form-label"> {{ __('messages.Current Password') }}</label>
                                        <input type="password" name="current_password" class="form-control" placeholder="{{ __('messages.Enter Current Password') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="new_password" class="form-label"> {{ __('messages.New Password') }}</label>
                                        <input type="password" name="new_password" class="form-control" placeholder="{{ __('messages.New Password') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="new_password_confirmation" class="form-label"> {{ __('messages.Confirm New Password') }}</label>
                                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="{{ __('messages.Confirm New Password') }}">
                                    </div>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-success px-4"> {{ __('messages.Update Profile') }}</button>
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
