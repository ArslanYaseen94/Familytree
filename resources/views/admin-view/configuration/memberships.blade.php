@extends('layouts.admin.app')

@section('content')
    <style>
        @media (min-width: 1200px) {
            .pricing-header {
                max-width: 100% !important;
            }
        }

        .pricing-features li {
            text-align: center
        }
    </style>
     <div class="content-header">
         <div>
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                             {{ __('messages.Family Tree Builder') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('messages.Membership Plan') }}</li>
                 </ol>
             </nav>
         </div>
     </div>
    <div class="container py-5">
        <h2 class="text-center">{{ __('messages.Choose Your Pricing') }}</h2>
        <p class="text-center text-muted mb-5">{{ __('messages.Simple, flexible and predictable pricing.') }}</p>

        <div class="row justify-content-center g-4">
            @foreach ($plan as $membership)
                <div class="col-md-3">
                    <div class="pricing-card">
                        <div class="pricing-header text-center">${{$membership->monthly_price}}/month</div>
                        <div class="pricing-body text-center">
                            <div class="pricing-title">{{$membership->name}}</div>
                            <ul class="pricing-features text-start">
                                <li>Allow up to {{$membership->monthly_members}} Members</li>
                            </ul>
                            <div class="paypal-button">
                                <img src="https://www.paypalobjects.com/en_US/i/btn/btn_subscribeCC_LG.gif"
                                    alt="Subscribe with PayPal">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
