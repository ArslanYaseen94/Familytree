<!-- resources/views/auth/forgot-password.blade.php -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.Forgot Password') }} - NEXTCOME</title>

    <link rel="stylesheet" href="{{ asset('assets/front-end/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/feather.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/front-end/images/nextcome_favicone.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/front-end/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-group.icon-input input {
            padding-left: 76px !important;
        }
    </style>
</head>
@php
$locale = Session::get('locale', 'en');
$language = DB::table('tbl_language')->where('LanguageCode', $locale)->value('LanguageName');
if (!$language) {
$language = 'English';
}
$languages = DB::table('tbl_language')->get();
@endphp

<body class="color-theme-blue">
    <div class="main-wrap container-fluid px-0">
        <!-- Header -->
        <div class="main-wrap container-fluid px-0">
            <!-- Navbar -->
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
                <!-- Image Section: visible on all screen sizes -->
                <div class="col-12 col-xl-5 p-0">
                    <div class="w-100 h-100 d-flex align-items-center justify-content-center"
                        style="background-image: url({{ asset('assets/front-end/images/login-bg.png') }}); background-size: cover; background-position: center; min-height: 250px;">
                    </div>
                </div>

                <!-- Forgot Password Form -->
                <div class="col-12 col-xl-7 d-flex align-items-center justify-content-center bg-white p-4" style="min-height: 100vh;">
                    <div class="card shadow-none border-0 w-100" style="max-width: 420px;">
                        <div class="card-body text-left">
                            <h2 class="fw-bold display-6 mb-4">{{ __('messages.Forgot Your Password?') }}</h2>

                            <form id="ForgotPasswordForm">
                                <div id="forgot-error" class="alert alert-danger light d-none"></div>
                                <div id="forgot-success" class="alert alert-success light d-none"></div>

                                <div class="form-group icon-input mb-3 position-relative">
                                    <i class="font-sm ti-email text-grey-500 position-absolute top-50 translate-middle-y ps-3"></i>
                                    <input type="email" class="style2-input ps-5 form-control" name="email" id="email"
                                        placeholder="{{ __('messages.Your Email') }}" required>
                                </div>

                                <div class="form-group mb-3">
                                    <button type="submit" id="ForgotBtn"
                                        class="btn btn-dark w-100 fw-semibold">{{ __('messages.Send Reset Link') }}</button>
                                </div>

                                <div class="text-center">
                                    <h6 class="text-muted fw-normal">
                                        <a href="/" class="fw-bold">{{ __('messages.Back to Login') }}</a>
                                    </h6>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#ForgotPasswordForm').on('submit', function(e) {
                    e.preventDefault();
                    $('#forgot-error').hide();
                    $('#forgot-success').hide();
                    $('#ForgotBtn').prop('disabled', true).text('Sending...');

                    $.ajax({
                        url: "{{ route('password.email') }}",
                        method: 'POST',
                        data: $(this).serialize(),
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            $('#ForgotBtn').prop('disabled', false).text('Send Reset Link');
                            $('#forgot-success').text(response.message || 'Reset link sent to your email.').show();
                        },
                        error: function(xhr) {
                            $('#ForgotBtn').prop('disabled', false).text('Send Reset Link');
                            let msg = 'Something went wrong. Please try again.';
                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                msg = xhr.responseJSON.message;
                            }
                            $('#forgot-error').text(msg).show();
                        }
                    });
                });
            });
        </script>
</body>

</html>