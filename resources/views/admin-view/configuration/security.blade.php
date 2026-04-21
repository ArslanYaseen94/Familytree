@extends('layouts.admin.app')

@section('content')
 <div class="content-header">
         <div>
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                             {{ __('messages.Family Tree Builder') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('messages.Security') }}</li>
                 </ol>
             </nav>
         </div>
     </div>
<div class="content-body">
    <div class="component-section mt-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>{{ __('messages.Security') }}</h3>
        </div>
        <form id="passwordUpdateForm">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="password" class="form-label"> {{ __('messages.Password') }}</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                </div>
                <div class="col-md-6">
                    <label for="retypepassword" class="form-label"> {{ __('messages.Retype Password') }}</label>
                    <input type="password" class="form-control" id="retypepassword" name="retypepassword"
                        placeholder="Retype Password">
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6 text-end">
                    <button type="submit" class="btn btn-primary"> {{ __('messages.Update') }}</button>
                </div>
            </div>
        </form>

        <script>
            $('#passwordUpdateForm').on('submit', function(e) {
                e.preventDefault();

                const password = $('#password').val();
                const retype = $('#retypepassword').val();

                if (password !== retype) {
                    toastr.error('Passwords do not match.');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.password.update') }}",
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#password').val('');
                            $('#retypepassword').val('');
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (const key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        } else {
                            toastr.error('An error occurred while updating the password.');
                        }
                    }
                });
            });
        </script>

        <div class="row g-3">
            <h4> {{ __('messages.Administrator') }}</h4>

            <div class="col-md-6">
                <label for="email" class="form-label"> {{ __('messages.User Name') }}</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email"
                    value="{{ $auth->email ?? '' }}">
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label"> {{ __('messages.Password') }}</label>
                <input type="password" class="form-control" id="password" name="password"
                    value="{{ $auth->password ?? '' }}">
            </div>

            <div class="col-12 mt-3 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#configAdminModal">
                     {{ __('messages.Retype Password') }}
                </button>
            </div>
        </div>

        <div class="modal fade" id="configAdminModal" tabindex="-1" aria-labelledby="configAdminModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="configAdminModalLabel">{{ __('messages.Config Admin') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <form id="configAdminForm">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="adminEmail" class="form-label">{{ __('messages.User Name') }}</label>
                                <input type="text" class="form-control" id="adminEmail" value="{{ $auth->email ?? '' }}"
                                    readonly>
                            </div>
                            <div class="mb-3">
                                <label for="oldPassword" class="form-label">{{ __('messages.Old Password') }}</label>
                                <input type="password" class="form-control" id="oldPassword" name="old_password">
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">{{ __('messages.New Password') }}</label>
                                <input type="password" class="form-control" id="newPassword" name="password">
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">{{ __('messages.Retype Password') }}</label>
                                <input type="password" class="form-control" id="confirmPassword" name="retypepassword">
                            </div>
                        </form>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="submitAdminConfig()"> {{ __('messages.CONFIG ADMIN') }}</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> {{ __('messages.CANCEL') }}</button>
                    </div>

                </div>
            </div>
        </div>

        <script>
            function submitAdminConfig() {
                const password = $('#newPassword').val();
                const confirmPassword = $('#confirmPassword').val();

                if (password !== confirmPassword) {
                    toastr.error('Passwords do not match.');
                    return;
                }

                $.ajax({
                    url: "{{ route('admin.password.update') }}",
                    method: 'POST',
                    data: $('#configAdminForm').serialize(),
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                            $('#configAdminModal').modal('hide');
                            $('#configAdminForm')[0].reset();
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value[0]);
                            });
                        } else {
                            toastr.error('Something went wrong.');
                        }
                    }
                });
            }
        </script>

    </div>
</div>
@endsection
