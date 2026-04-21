<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Responsive Bootstrap 4 Dashboard and Admin Template">
    <meta name="author" content="ThemePixels">

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/front-end/images/nextcome_favicone.png') }}">

    <title>NEXTCOME - Family Tree Creator</title>

    <!-- vendor css -->
    <link href="{{ asset('assets/back-end/lib/%40fortawesome/fontawesome-free/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/back-end/lib/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
    <!-- template css -->
    <link rel="stylesheet" href="{{ asset('assets/back-end/assets/css/cassie.css') }}">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .container {
            margin-left: 30px;
        }

        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 1245px;
            }
        }
    </style>
</head>

<body>
    <div class="signin-panel">
        <svg-to-inline path="{{ asset('assets/back-end/svg/citywalk.svg') }}" class-name="svg-bg"></svg-to-inline>

        <div class="signin-sidebar">
            <div class="signin-sidebar-body">
                <a href="dashboard-one.html" class="sidebar-logo mg-b-40"><span><img
                            src="{{ asset('assets/front-end/images/nextcome_logo.png') }}" style="width:90%"></span></a>
                <h4 class="signin-title">Welcome back!</h4>
                <h5 class="signin-subtitle">Please signin to continue.</h5>
                <form id="loginForm">
                    @csrf
                    <div id="login-error" class="alert alert-danger light alert-dismissible fade show"
                        style="display:none;"></div>
                    <div class="signin-form">
                        <div class="form-group">
                            <label>Email address</label>
                            <input type="text" class="form-control" name="email"
                                placeholder="Enter your email address">
                        </div>

                        <div class="form-group">
                            <label class="d-flex justify-content-between">
                                <span>Password</span>
                                <a href="" class="tx-13">Forgot password?</a>
                            </label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Enter your password">
                        </div>
                        <button type="submit" class="btn btn-facebook btn-uppercase btn-block">Login</button>
                    </div>
                </form>
            </div><!-- signin-sidebar-body -->
        </div><!-- signin-sidebar -->
    </div><!-- signin-panel -->
    <script src="{{ asset('assets/back-end/lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/feather-icons/feather.min.js') }}"></script>
    <script src="{{ asset('assets/back-end/lib/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script>
        $(function() {

            'use strict'

            feather.replace();

            new PerfectScrollbar('.signin-sidebar', {
                suppressScrollX: true
            });

        })
    </script>
    <script>
        $(document).ready(function() {
            $('#loginForm').on('submit', function(e) {
                e.preventDefault();
                $('#login-error').hide();
                $.ajax({
                    url: '{{ route('admin.login-form') }}',
                    method: 'POST',
                    data: $(this).serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        window.location.href = '{{ route('admin.dashboard') }}';
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            var errors = xhr.responseJSON.errors;
                            var errorHtml = '<ul>';
                            $.each(errors, function(key, value) {
                                errorHtml += '<li>' + value +
                                '</li>'; // Append each error as list item
                            });
                            errorHtml += '</ul>';

                            // Display errors in a specific element with id="login-error"
                            $('#login-error').html(errorHtml).show();
                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                            // Display single error message
                            $('#login-error').text(xhr.responseJSON.message).show();
                        } else {
                            $('#login-error').text('An error occurred. Please try again.')
                            .show();
                        }
                    }

                });
            });
        });
    </script>
    <script src="{{ asset('assets/back-end/js/svg-inline.js') }}"></script>
</body>

</html>
