<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>NEXTCOME - Family Tree Creator</title>

    <link rel="stylesheet" href="{{ asset('assets/front-end/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/feather.css') }}">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/front-end/images/nextcome_favicone.png') }}">
    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/style.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .display1-size {
        font-size: 22px !important;
    }

    .form-group.icon-input input {
        padding-left: 76px !important;
    }
</style>
@php
$locale = Session::get('locale', 'en');
$language = DB::table('tbl_language')->where('LanguageCode', $locale)->value('LanguageName');
if (!$language) {
$language = 'English';
}
$languages = DB::table('tbl_language')->get();
@endphp

<body class="color-theme-blue">

    <div class="preloader"></div>

    <div class="main-wrap container-fluid px-0">
        <!-- Header -->
        <div class="nav-header bg-transparent shadow-none border-0">
            <div class="nav-top w-100 d-flex justify-content-between align-items-center px-3 py-2">
                <a href="/" class="d-flex align-items-center">
                    <img src="{{ asset('assets/front-end/images/nextcome_logo.png') }}" style="width: 100px;" alt="Logo">
                </a>

                <div class="dropdown">
                    <a style="line-height: 33px !important;
    width: 118px !important;" href="#" class="p-2 text-center menu-icon" id="dropdownMenuLanguage" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="feather-globe font-xl text-current"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end p-3 rounded-3 shadow-lg"
                        aria-labelledby="dropdownMenuLanguage">
                        @foreach ($languages as $lang)
                        <a style="line-height: 33px !important;
    width: 118px !important;" class="dropdown-item {{ $lang->LanguageCode == $locale ? 'active' : '' }}"
                            href="{{ route('setLanguage', ['locale' => $lang->LanguageCode]) }}">
                            {{ $lang->LanguageName }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="row gx-0">
            <!-- Background image section (visible on all screens) -->
            <div class="col-12 col-xl-5 p-0">
                <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                    style="background-image: url('{{ asset('assets/front-end/images/login-bg.png') }}'); background-size: cover; background-position: center; min-height: 250px;">
                </div>
            </div>

            <!-- Form section -->
            <div class="col-12 col-xl-7 d-flex align-items-center justify-content-center bg-white p-4" style="min-height: 100vh;">
                <div class="card shadow-none border-0 w-100" style="max-width: 500px;">
                    <div class="card-body text-left">
                        <h2 class="fw-bold display-6 mb-4">{{ __("messages.Create Your Account") }}</h2>

                        <form id="RegisterForm">

                            @foreach ([
                            ['name', 'ti-user'],
                            ['email', 'ti-email'],
                            ['password', 'ti-lock', 'password'],
                            ['familyId', 'ti-id-badge'],
                            ['country', 'ti-world'],
                            ['state', 'ti-map-alt'],
                            ['city', 'ti-location-pin'],
                            ['phone', 'ti-mobile']
                            ] as $field)
                            @php
                            $type = $field[2] ?? 'text';
                            @endphp
                            <div class="form-group icon-input mb-3 position-relative">
                                <i class="font-sm {{ $field[1] }} text-grey-500 position-absolute top-50 translate-middle-y ps-3"></i>
                                <input type="{{ $type }}"
                                    class="style2-input ps-5 form-control text-grey-900 font-xss ls-3"
                                    name="{{ $field[0] }}"
                                    id="{{ $field[0] }}"
                                    @if($field[0] === 'familyId')
                                        placeholder="12345-1234567-1"
                                        inputmode="numeric"
                                        maxlength="15"
                                        pattern="^\d{5}-\d{7}-\d{1}$"
                                    @else
                                        placeholder="{{ __("messages." . ucfirst($field[0])) }}"
                                    @endif
                                >
                            </div>
                            @endforeach

                            <div class="form-group mb-3">
                                <button type="submit" id="RegisterBtn"
                                    class="btn btn-dark w-100 fw-semibold">{{ __("messages.Register") }}</button>
                            </div>

                            <div class="text-center">
                                <h6 class="text-muted fw-normal">
                                    {{ __("messages.Already Have Account") }}
                                    <a href="/" class="fw-bold ms-1">{{ __("messages.Login") }}</a>
                                </h6>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('assets/front-end/js/plugin.js') }}"></script>
    <script src="{{ asset('assets/front-end/js/scripts.js') }}"></script>

    <script>
        $(document).ready(function() {
            // CNIC input formatter for familyId: 12345-1234567-1
            (function() {
                const el = document.getElementById('familyId');
                if (!el) return;

                function formatCNIC(value) {
                    const digits = (value || '').replace(/\D/g, '').slice(0, 13);
                    const p1 = digits.slice(0, 5);
                    const p2 = digits.slice(5, 12);
                    const p3 = digits.slice(12, 13);
                    let out = p1;
                    if (p2.length) out += '-' + p2;
                    if (p3.length) out += '-' + p3;
                    return out;
                }

                el.addEventListener('input', () => {
                    const start = el.selectionStart;
                    const before = el.value;
                    el.value = formatCNIC(el.value);
                    const delta = el.value.length - before.length;
                    if (typeof start === 'number') el.setSelectionRange(start + delta, start + delta);
                });
            })();

            $('#RegisterForm').on('submit', function(e) {
                e.preventDefault();
                $('#RegisterBtn').prop('disabled', true);
                $('#RegisterBtn').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> {{ __("messages.Loading...") }}'
                );
                $.ajax({
                    url: "{{ route('user.register') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {

                        $('#RegisterBtn').prop('disabled', false);
                        $('#RegisterBtn').html('{{ __("messages.Register") }}');
                        toastr.success(response.message, '{{ __("messages.Success") }}');
                        setTimeout(function() {
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#RegisterBtn').prop('disabled', false);
                        $('#RegisterBtn').html('{{ __("messages.Register") }}');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                toastr.error(value, '{{ __("messages.Error") }}');
                            });
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // Display single error message
                            toastr.error(xhr.responseJSON.message, '{{ __("messages.Error") }}');
                        } else {
                            toastr.error('An error occurred. Please try again.', '{{ __("messages.Error") }}');
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>