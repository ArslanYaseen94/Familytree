@extends('layouts.admin.app')

@section('content')
<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                        {{ __('messages.Family Tree Builder') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ __('messages.General Settings') }}</li>
            </ol>
        </nav>
    </div>
</div>
<div class="content-body">
    <div class="component-section mt-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>{{ __('messages.General Settings') }}</h4>
        </div>

        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="name" class="form-label">{{ __('messages.Name') }}</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name"
                        value="{{ $auth->name ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">
                        {{ __('messages.Email Address') }}
                    </label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Enter Email Address" value="{{ $auth->email ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="language" class="form-label">
                        {{ __('messages.Language') }}
                    </label>
                    <select id="language" class="form-select" name="language">
                        <option value="english" {{ $auth->language == 'english' ? 'selected' : '' }}>English</option>
                        <option value="chinese" {{ $auth->language == 'chinese' ? 'selected' : '' }}>Chinese</option>
                        <option value="spanish" {{ $auth->language == 'spanish' ? 'selected' : '' }}>Spanish</option>
                    </select>
                </div>

                <h4> {{ __('messages.About Your Company') }}</h4>

                <div class="col-md-6">
                    <label for="company_name" class="form-label"> {{ __('messages.Company Name') }}</label>
                    <input type="text" class="form-control" id="company_name" name="company_name"
                        placeholder="Enter Company name" value="{{ $auth->company_name ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="dba_name" class="form-label">{{ __('messages.DBA Name') }}</label>
                    <input type="text" class="form-control" id="dba_name" name="dba_name"
                        value="{{ $auth->dba_name ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="address1" class="form-label"> {{ __('messages.Address 1') }}</label>
                    <input type="text" class="form-control" id="address1" name="address1"
                        value="{{ $auth->address_1 ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="address2" class="form-label">{{ __('messages.Address 2') }}</label>
                    <input type="text" class="form-control" id="address2" name="address2"
                        value="{{ $auth->address_2 ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="zip_code" class="form-label"> {{ __('messages.Zip Code') }}</label>
                    <input type="text" class="form-control" id="zip_code" name="zip_code"
                        value="{{ $auth->zip_code ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="city" class="form-label"> {{ __('messages.City') }}</label>
                    <input type="text" class="form-control" id="city" name="city"
                        value="{{ $auth->city ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="state" class="form-label"> {{ __('messages.State') }}</label>
                    <input type="text" class="form-control" id="state" name="state"
                        value="{{ $auth->state ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="country" class="form-label"> {{ __('messages.Country') }}</label>
                    <input type="text" class="form-control" id="country" name="country"
                        value="{{ $auth->country ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="phone" class="form-label"> {{ __('messages.Phone') }}</label>
                    <input type="tel" class="form-control" id="phone" name="phone"
                        placeholder="Enter phone number" value="{{ $auth->phone ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="mobile_number" class="form-label"> {{ __('messages.Mobile Number') }}</label>
                    <input type="tel" class="form-control" id="mobile_number" name="mobile_number"
                        placeholder="Enter mobile number" value="{{ $auth->mobile_number ?? '' }}">
                </div>
                <div class="col-md-6">
                    <label for="fax" class="form-label"> {{ __('messages.Fax') }}</label>
                    <input type="tel" class="form-control" id="fax" name="fax"
                        placeholder="Enter fax number" value="{{ $auth->fax ?? '' }}">
                </div>
                <div class="col-12 mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary"> {{ __('messages.Submit') }}</button>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection