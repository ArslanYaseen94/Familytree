@extends('layouts.admin.app')

@section('content')
 <div class="content-header">
         <div>
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                             {{ __('messages.Family Tree Builder') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('messages.Recaptcha') }}</li>
                 </ol>
             </nav>
         </div>
     </div>
<div class="container py-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col-sm mb-sm-0">
                <h1 class="page-header-title">
                    {{ __('messages.ReCaptcha Credentials Setup') }}
                </h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <div class="row pb-3">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body px-4 py-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">
                            <img src="https://foodyxpress.com/public/assets/admin/img/recapcha.png" alt="reCAPTCHA"
                                style="height: 30px;" class="me-2">
                            <strong>
                                {{ __('messages.Google ReCaptcha') }}
                            </strong>
                        </h5>
                        <button type="button" class="btn btn-sm btn-dark" data-bs-toggle="modal"
                            data-bs-target="#recaptchaModal">
                            <i class="tio-info-outlined me-1"></i>
                            {{ __('messages.Credentials Setup') }}
                        </button>
                    </div>

                    <form action="{{ route('recaptcha.update') }}" method="post">
                        @csrf
                        <div class="mb-4">
                            <label class="form-check me-4">
                                <input class="form-check-input" type="radio" name="status" value="1"
                                    {{ ($setting->status ?? 1) == 1 ? 'checked' : '' }}>
                                <span class="form-check-label ms-2">Active</span>
                            </label>
                            <label class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="0"
                                    {{ ($setting->status ?? 1) == 0 ? 'checked' : '' }}>
                                <span class="form-check-label ms-2">Inactive</span>
                            </label>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label text-capitalize">

                                {{ __('messages.Site Key') }}
                            </label>
                            <input type="text" class="form-control" name="site_key"
                                value="{{ old('site_key', $setting->site_key ?? '') }}"
                                placeholder="Enter your site key">
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label text-capitalize">

                                {{ __('messages.Secret Key') }}
                            </label>
                            <input type="text" class="form-control" name="secret_key"
                                value="{{ old('secret_key', $setting->secret_key ?? '') }}"
                                placeholder="Enter your secret key">
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 py-2">
                                {{ __('messages.Save') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- ReCaptcha Modal -->
<div class="modal fade" id="recaptchaModal" tabindex="-1" aria-labelledby="recaptchaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="recaptchaModalLabel">ReCaptcha Credential Setup Instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol class="ps-3">
                    <li>Go to the <a href="https://www.google.com/recaptcha/admin/create" target="_blank"
                            class="text-primary">ReCaptcha Admin Console</a></li>
                    <li>Add a <strong>Label</strong> (e.g., <code>Test Label</code>)</li>
                    <li>Select <strong>reCAPTCHA v2</strong> with subtype <strong>"I'm not a robot" Checkbox</strong>
                    </li>
                    <li>Enter your <strong>Domain</strong> (e.g., <code>yourdomain.com</code>)</li>
                    <li>Accept the <strong>reCAPTCHA Terms of Service</strong></li>
                    <li>Click <strong>Submit</strong></li>
                    <li>Copy your <strong>Site Key</strong> and <strong>Secret Key</strong>, paste them in the input
                        fields above, and click <strong>Save</strong></li>
                </ol>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection