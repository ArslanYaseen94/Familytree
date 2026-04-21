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
                            <div id="Register-error" class="alert alert-danger light alert-dismissible fade show d-none"></div>
                            <div id="Register-success" class="alert alert-success light alert-dismissible fade show d-none"></div>

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
                                    placeholder="{{ __("messages." . ucfirst($field[0])) }}">
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
    <script src="{{ asset('assets/front-end/js/plugin.js') }}"></script>
    <script src="{{ asset('assets/front-end/js/scripts.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#RegisterForm').on('submit', function(e) {
                e.preventDefault();
                $('#Register-error').hide();
                $('#RegisterBtn').prop('disabled', true);
                $('#RegisterBtn').html(
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
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
                        $('#RegisterBtn').html('Save');
                        $('#Register-success').text(response.message).show();
                        setTimeout(function() {
                            $('#Register-success').fadeOut();
                            window.location.reload();
                        }, 1000);
                    },
                    error: function(xhr) {
                        $('#RegisterBtn').prop('disabled', false);
                        $('#RegisterBtn').html('Save');

                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value +
                                    '</li>'; // Append each error as list item
                            });
                            errorHtml += '</ul>';

                            // Display errors in a specific element with id="plan-error"
                            $('#Register-error').html(errorHtml).show();
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // Display single error message
                            $('#Register-error').text(xhr.responseJSON.message).show();
                        } else {
                            $('#Register-error').text('An error occurred. Please try again.')
                                .show();
                        }
                    }
                });
            });
        });
    </script>

</body>

</html>