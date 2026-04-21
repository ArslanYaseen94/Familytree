@extends('layouts.user.app')

 @section('content')

<div class="main-content bg-lightblue theme-dark-bg right-chat-active">
            
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left">
            <div class="middle-wrap">
                <div class="card w-100 border-0 bg-white shadow-xs p-0 mb-4">
                    <div class="card-body p-4 w-100 bg-current border-0 d-flex rounded-3">
                        <a href="settings" class="d-inline-block mt-2"><i class="ti-arrow-left font-sm text-white"></i></a>
                        <h4 class="font-xs text-white fw-600 ms-4 mb-0 mt-2">Change Password</h4>
                    </div>
                    <div class="card-body p-lg-5 p-4 w-100 border-0">
                        <form id="PasswordForm">
                            <div id="Password-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
                            <div id="Password-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>
                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="form-gorup">
                                        <label class="mont-font fw-600 font-xssss">Current Password</label>
                                        <input type="text" name="Old_Password" id="Old_Password" class="form-control">
                                    </div>        
                                </div>

                                <div class="col-lg-12 mb-3">
                                    <div class="form-gorup">
                                        <label class="mont-font fw-600 font-xssss">Change Password</label>
                                        <input type="text" name="New_password" id="New_password" class="form-control">
                                    </div>        
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 mb-3">
                                    <div class="form-gorup">
                                        <label class="mont-font fw-600 font-xssss">Confirm Change Password</label>
                                        <input type="text" name="Confirm_password" id="Confirm_password" class="form-control">
                                    </div>        
                                </div>                                     
                            </div>
                            <div class="row">
                                <div class="col-lg-12 mb-0">
                                    <button type="submit" class="bg-current text-center text-white font-xsss fw-600 p-3 w175 rounded-3 d-inline-block" id="ChangePassword">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <div class="card w-100 border-0 p-2"></div> -->
            </div>
        </div>
         
    </div>            
</div>
<!-- main content -->
@endsection
@section('scripts')
<script>
  $(document).ready(function () {
          $('#PasswordForm').on('submit', function (e) {
              e.preventDefault();
              $('#Password-error').hide();
              $('#ChangePassword').prop('disabled', true);
              $('#ChangePassword').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
              $.ajax({
                  url: '{{ route("user.Password") }}',
                  method: 'POST',
                  data: $(this).serialize(),
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function (response) {
                      $('#ChangePassword').prop('disabled', false);
                      $('#ChangePassword').html('Change Password');
                      $('#Password-success').text(response.message).show();
                      setTimeout(function() {
                          $('#Password-success').fadeOut();
                          $('#PasswordForm').trigger("reset");
                      }, 2000);
                  },
                  error: function(xhr) {
                      $('#ChangePassword').prop('disabled', false);
                      $('#ChangePassword').html('Change Password');

                          if (xhr.responseJSON && xhr.responseJSON.errors) {
                              var errors = xhr.responseJSON.errors;
                              var errorHtml = '<ul>';
                              $.each(errors, function(key, value) {
                                  errorHtml += '<li>' + value + '</li>'; // Append each error as list item
                              });
                              errorHtml += '</ul>';

                              // Display errors in a specific element with id="login-error"
                              $('#Password-error').html(errorHtml).show();
                          } else if (xhr.responseJSON && xhr.responseJSON.message) {
                              // Display single error message
                              $('#Password-error').text(xhr.responseJSON.message).show();
                          } else {
                              $('#Password-error').text('An error occurred. Please try again.').show();
                          }
                      }
                  
              });
          });
  });
</script>
@endsection