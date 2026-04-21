@extends('layouts.admin.app')

@section('content')
 <div class="content-header">
         <div>
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                             {{ __('messages.Family Tree Builder') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('messages.Payment Method') }}</li>
                 </ol>
             </nav>
         </div>
     </div>
    <div class="container py-4">
        <h4 class="mb-4"><i class="bi bi-credit-card-2-front-fill me-2"></i>  {{ __('messages.Payment Method') }}</h4>

        <div class="row g-4">
            {{-- Cash on Delivery --}}
            <div class="col-md-6">
                <form action="{{ route('admin.gateway.update.cod') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-3">{{ __('messages.Payment Method') }}</h6>
                            <h5 class="fw-semibold">{{ __('messages.Cash on Delivery') }}</h5>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="cod_status" value="on"
                                    {{ $gateway->cod_status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="codActive">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="cod_status" value="off"
                                    {{ $gateway->cod_status == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="codInactive">Inactive</label>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100">{{ __('messages.Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Digital Payment --}}
            <div class="col-md-6">
                <form action="{{ route('admin.gateway.update.digital') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h6 class="text-uppercase mb-3">{{ __('messages.Payment Method') }}</h6>
                            <h5 class="fw-semibold"> {{ __('messages.Digital Payment') }}</h5>
                            <div class="form-check form-check-inline mt-3">
                                <input class="form-check-input" type="radio" name="digital_status" value="on"
                                    {{ $gateway->digital_status == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="digitalActive">Active</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="digital_status" value="off"
                                    {{ $gateway->digital_status == '0' ? 'checked' : '' }}>
                                <label class="form-check-label" for="digitalInactive">Inactive</label>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-primary w-100">{{ __('messages.Submit') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- PayPal --}}
            <div class="col-md-6">
                <form action="{{ route('admin.gateway.update.paypal') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-semibold">{{ __('messages.Paypal') }}</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="paypal_status" id="paypalToggle"
                                        {{ $gateway->paypal_status == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label text-primary" for="paypalToggle">ON</label>
                                </div>
                            </div>
                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg"
                                width="90" class="mb-3">
                            <input type="text" name="paypal_client_id" class="form-control mb-3"
                                placeholder="Paypal Client Id" value="{{ $gateway->paypal_client_id }}">
                            <input type="text" name="paypal_secret" class="form-control mb-3" placeholder="Paypal Secret"
                                value="{{ $gateway->paypal_secret }}">
                            <button class="btn btn-primary w-100">{{ __('messages.Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Stripe --}}
            <div class="col-md-6">
                <form action="{{ route('admin.gateway.update.stripe') }}" method="POST">
                    @csrf
                    <div class="card shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-semibold"> {{ __('messages.Stripe') }}</h5>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="stripe_status" id="stripeToggle"
                                        {{ $gateway->stripe_status == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label text-primary" for="stripeToggle">ON</label>
                                </div>
                            </div>
                            <img src="{{ asset('assets/back-end/assets/img/stripe.png') }}" width="90" class="mb-3">
                            <input type="text" name="stripe_publish_key" class="form-control mb-3"
                                placeholder="Publish Key" value="{{ $gateway->stripe_publish_key }}">
                            <input type="text" name="stripe_api_key" class="form-control mb-3" placeholder="API Key"
                                value="{{ $gateway->stripe_api_key }}">
                            <button class="btn btn-primary w-100">{{ __('messages.Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
