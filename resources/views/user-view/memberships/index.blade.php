@extends('layouts.user.app')

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
<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="container py-5">
                <h2 class="text-center"> {{ __('messages.Choose Your Pricing') }}</h2>
                <p class="text-center text-muted mb-5"> {{ __('messages.Simple, flexible and predictable pricing.') }}</p>

                <div class="row justify-content-center g-4">

                    <!-- Free Trial -->
                    @foreach ($plan as $membership)
                    <div class="col-md-3">
                        <div class="pricing-card">
                            <div class="pricing-header text-center">${{ $membership->monthly_price }}/{{ __('messages.month') }}</div>
                            <div class="pricing-body text-center">
                                <div class="pricing-title">
                                    @php
                                    $locale = session('locale', app()->getLocale());
                                    @endphp

                                    @if ($locale === 'ch')
                                    {{ $membership->chinese_name }}
                                    @elseif ($locale === 'ko')
                                    {{ $membership->korean_name }}
                                    @else
                                    {{ $membership->name }}
                                    @endif
                                </div>
                                <ul class="pricing-features text-start">
                                    <li> {{ __('messages.Allow up to') }} {{ $membership->monthly_members }} {{ __('messages.members') }}</li>
                                </ul>
                                @php
                                    $paypalActive = $gateway && (string) $gateway->paypal_status === '1';
                                    $stripeActive = $gateway && (string) $gateway->stripe_status === '1';
                                @endphp

                                @if (!$paypalActive && !$stripeActive)
                                    <div class="alert alert-warning mt-3 mb-0">
                                        {{ __('messages.Payment method is not available right now.') }}
                                    </div>
                                @else
                                    <div class="d-grid mt-3">
                                        <button
                                            type="button"
                                            class="btn btn-primary js-open-payment-modal"
                                            data-plan-id="{{ $membership->id }}"
                                            data-plan-name="{{ $membership->name }}"
                                        >
                                            {{ __('messages.Subscribe') }}
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Payment method modal (no bootstrap JS dependency) --}}
@php
    $paypalActive = $gateway && (string) $gateway->paypal_status === '1';
    $stripeActive = $gateway && (string) $gateway->stripe_status === '1';
@endphp

<div id="paymentMethodModalBackdrop" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,.55); z-index:9998;"></div>
<div id="paymentMethodModal" style="display:none; position:fixed; inset:0; z-index:9999; overflow:auto;">
    <div class="d-flex align-items-center justify-content-center" style="min-height:100%; padding:24px;">
        <div class="bg-white rounded-4 shadow-lg" style="width:100%; max-width:520px;">
            <div class="p-4 border-bottom d-flex align-items-center justify-content-between">
                <div>
                    <div class="fw-semibold">{{ __('messages.Choose payment method') }}</div>
                    <div class="text-muted small" id="paymentMethodModalPlan"></div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-secondary js-close-payment-modal">×</button>
            </div>
            <div class="p-4">
                <div class="d-grid gap-2">
                    @if ($paypalActive)
                        <a id="paymentLinkPaypal" class="btn btn-outline-primary" href="#">
                            {{ __('messages.Subscribe') }} (PayPal)
                        </a>
                    @endif

                    @if ($stripeActive)
                        <a id="paymentLinkStripe" class="btn btn-primary" href="#">
                            {{ __('messages.Subscribe') }} (Stripe)
                        </a>
                    @endif
                </div>
                <div class="mt-3 text-muted small">
                    {{ __('messages.You will be redirected to the selected payment gateway.') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    (function () {
        const modal = document.getElementById('paymentMethodModal');
        const backdrop = document.getElementById('paymentMethodModalBackdrop');
        const planLabel = document.getElementById('paymentMethodModalPlan');

        const paypalLink = document.getElementById('paymentLinkPaypal');
        const stripeLink = document.getElementById('paymentLinkStripe');

        const paypalBase = @json(rtrim(route('paypal.subscribe', 0), '0'));
        const stripeBase = @json(rtrim(route('stripe.checkout', 0), '0'));

        function openModal(planId, planName) {
            if (planLabel) planLabel.textContent = planName ? (planName + ' (ID: ' + planId + ')') : ('Plan ID: ' + planId);

            if (paypalLink) paypalLink.href = paypalBase + planId;
            if (stripeLink) stripeLink.href = stripeBase + planId;

            modal.style.display = 'block';
            backdrop.style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        function closeModal() {
            modal.style.display = 'none';
            backdrop.style.display = 'none';
            document.body.style.overflow = '';
        }

        document.addEventListener('click', function (e) {
            const openBtn = e.target.closest('.js-open-payment-modal');
            if (openBtn) {
                e.preventDefault();
                openModal(openBtn.dataset.planId, openBtn.dataset.planName);
                return;
            }

            if (e.target.closest('.js-close-payment-modal')) {
                e.preventDefault();
                closeModal();
                return;
            }

            if (e.target === backdrop) {
                closeModal();
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeModal();
        });
    })();
</script>
@endsection