@extends('layouts.user.app')

@section('content')

<!-- main content -->
<div class="main-content theme-dark-bg right-chat-active">

    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left">
                <div class="container">
                <div class="card w-100 border-0 bg-white shadow-xs p-0 mb-4">
                    <div class="card-body p-4 w-100 bg-current border-0 d-flex rounded-3">
                        <a href="profile" class="d-inline-block mt-2"><i class="ti-arrow-left font-sm text-white"></i></a>
                        <h4 class="font-xs text-white fw-600 ms-4 mb-0 mt-2">{{ __('messages.Account Details') }}</h4>
                    </div>
                    <div class="card-body p-lg-5 p-4 w-100 border-0 ">
                        <form action="{{ route("user.profileupdate") }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-lg-4 text-center">
                                    <figure id="imageFigure" class="avatar ms-auto me-auto mb-0 mt-2 w100" onclick="document.getElementById('image').click();">
                                        @if(Auth::guard('web')->user()->profileImg !='')
                                        <img id="imagePreview11" src="{{ asset('assets/front-end/ProfileImgs/' . Auth::guard('web')->user()->profileImg) }}" alt="image" class="shadow-sm rounded-3 w-100" style="cursor: pointer;">
                                        @else
                                        <img id="imagePreview" src="{{ asset('assets/front-end/images/avtar.jpg') }}" alt="image" class="shadow-sm rounded-3 w-100" style="cursor: pointer;">
                                        @endif
                                    </figure>
                                    <input type="file" accept=".jpg,.jpeg,.png" name="image" id="image" class="p-3 alert-primary text-primary font-xsss fw-500 mt-2 rounded-3" style="background-color: white; display: none;">
                                </div>
                            </div>

                            <div id="login-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
                            <div id="login-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="form-group">
                                        <label class="mont-font fw-600 font-xsss"> {{ __('messages.Name') }}</label>
                                        <input type="text" value="{{ Auth::guard('web')->user()->name }}" name="name" id="name" class="form-control" placeholder="{{ __('messages.Enter Your Name') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="mont-font fw-600 font-xsss"> {{ __('messages.Phone') }}</label>
                                        <input type="text" value="{{ Auth::guard('web')->user()->phone }}" name="Phone" id="phone" class="form-control" placeholder="{{ __('messages.Enter Your Phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="mont-font fw-600 font-xsss"> {{ __('messages.Email') }}</label>
                                        <input type="text" value="{{ Auth::guard('web')->user()->email }}" name="email" id="email" class="form-control" placeholder="{{ __('messages.Enter Your Email') }}" required>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="mont-font fw-600 font-xsss"> {{ __('messages.Gender') }}r</label>
                                        <select type="text" name="gender" id="gender" class="form-control">
                                            <option value="Male" @if(Auth::guard('web')->user()->gender == 'Male') selected @endif class="form-control">{{ __('messages.Male') }}</option>
                                            <option value="Female" @if(Auth::guard('web')->user()->gender == 'Female') selected @endif class="form-control"> {{ __('messages.Female') }}</option>
                                            <option value="Other" @if(Auth::guard('web')->user()->gender == 'Other') selected @endif class="form-control"> {{ __('messages.Other') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-3">
                                    <div class="form-group">
                                        <label class="mont-font fw-600 font-xsss"> {{ __('messages.Birthday') }}</label>
                                        <input type="date" value="{{ Auth::guard('web')->user()->bday }}" name="bday" id="bday" class="form-control">
                                    </div>
                                </div>
                                <div class="col-lg-12 mb-3">
                                    <label class="mont-font fw-600 font-xsss"> {{ __('messages.Bio') }}</label>
                                    <textarea class="form-control mb-0 p-3 h100 bg-greylight lh-16" rows="5" name="bio" id="bio" placeholder="{{ __('messages.Write your Bio...') }}" spellcheck="false">{{ Auth::guard('web')->user()->bio }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 mb-0">
                                        <button type="submit" id="Update" class="bg-current text-center text-white font-xsss fw-600 p-3 w175 rounded-3 d-inline-block border-0"> {{ __('messages.Save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
        </div>
         
        </div>

    </div>
</div>
<!-- main content -->
@endsection
@section('scripts')
<script>
document.getElementById('image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview11').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
</script>

<script>
    $(document).ready(function() {
        $('#image').on('change', function(event) {
            var input = event.target;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        });

        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            $('#login-error').hide();
            $('#Update').prop('disabled', true);
            $('#Update').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

            var formData = new FormData(this);

            $.ajax({
                url: '{{ route("user.profileupdate") }}',
                method: 'POST',
                data: formData,
                processData: false, // Prevent jQuery from automatically transforming the data into a query string
                contentType: false, // Prevent jQuery from setting the Content-Type request header
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    $('#Update').prop('disabled', false);
                    $('#Update').html('Save');
                    $('#login-success').text(response.message).show();
                    setTimeout(function() {
                        $('#login-success').fadeOut();
                    }, 1000);
                },
                error: function(xhr) {
                    $('#Update').prop('disabled', false);
                    $('#Update').html('Save');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value + '</li>'; // Append each error as list item
                        });
                        errorHtml += '</ul>';

                        // Display errors in a specific element with id="login-error"
                        $('#login-error').html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display single error message
                        $('#login-error').text(xhr.responseJSON.message).show();
                    } else {
                        $('#login-error').text('An error occurred. Please try again.').show();
                    }
                }
            });
        });
    });
</script>
@endsection