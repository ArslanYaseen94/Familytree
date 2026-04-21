 @extends('layouts.admin.app')

 @section('content') 

     <div class="content-header">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard')}}">Family Tree Builder</a></li>
              <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
            </ol>
          </nav>
          <h4 class="content-title content-title-sm">Profile Settings</h4>
        </div>
      </div><!-- content-header -->
 
      <div class="content-body">
        <div class="row row-xs">
          <div class="col-md-4">
            <ul class="list-group list-group-settings">
              <li class="list-group-item list-group-item-action">
                <a href="#paneProfile" data-toggle="tab" class="media active">
                  <i data-feather="user"></i>
                  <div class="media-body">
                    <h6>Profile Information</h6>
                    <span>About your personal information</span>
                  </div>
                </a>
              </li>
              <li class="list-group-item list-group-item-action">
                <a href="#paneSecurity" data-toggle="tab" class="media">
                  <i data-feather="shield"></i>
                  <div class="media-body">
                    <h6>Security</h6>
                    <span>Manage your security information</span>
                  </div>
                </a>
              </li>
            </ul>
          </div><!-- col -->
          <div class="col-md-8">
            <div class="card card-body pd-sm-40 pd-md-30 pd-xl-y-35 pd-xl-x-40">
              <div class="tab-content">
                <div id="paneProfile" class="tab-pane active show">
                  <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Your Profile Information</h6>
                  <hr>
                  <form id="profileForm">
                  <div id="login-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
                  <div id="login-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>
                  <div class="form-settings">
                    <div class="form-group">
                      <label class="form-label">Full Name</label>
                      <input type="text" name="name" class="form-control" placeholder="Enter your fullname" value="{{ $adminUser->name }}">                     
                    </div><!-- form-group -->

                    <div class="form-group">
                      <label class="form-label">Your Bio</label>
                      <textarea class="form-control" name="bio" rows="3" placeholder="Write something about you">{{ $adminUser->bio }}</textarea>
                    </div><!-- form-group -->

                    <div class="form-group">
                      <label class="form-label">Mobile Number</label>
                      <input type="text" name="mobile_number" class="form-control" placeholder="Enter your mobile number" value="{{ $adminUser->phone }}">
                    </div><!-- form-group -->

                    <div class="form-group">
                      <label class="form-label">Email Address</label>
                      <input type="text" name="email" class="form-control" placeholder="Enter your email address" value="{{ $adminUser->email }}">
                    </div><!-- form-group -->                   

                    <hr class="op-0">
                    <button type="submit" id="Update" class="btn btn-brand-02">Update Profile</button>
                    <a href="{{ route('admin.profile') }}" id="Resetbutton" class="btn btn-white mg-l-2">Reset Changes</a>
                  </div>
                </form>
                </div><!-- tab-pane -->                
                <div id="paneSecurity" class="tab-pane">
                  <h6 class="tx-uppercase tx-semibold tx-color-01 mg-b-0">Security Settings</h6>
                  <hr>
                  <form id="PasswordForm">
                  <div id="Password-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
                  <div id="Password-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>
                  <div class="form-settings">
                    <div class="form-group">
                      <label class="form-label">Change Old Password</label>
                      <input type="password" name="Old_Password" class="form-control" placeholder="Enter your old password">
                      <input type="text" name="New_password" class="form-control mg-t-5" placeholder="New password">
                      <input type="password" name="Confirm_password" class="form-control mg-t-5" placeholder="Confirm new password">
                    </div><!-- form-group -->

                    <hr>

                    <div class="form-group">
                      <button type="submit" id="ChangePassword" class="btn btn-brand-02 tx-sm">Change Password</button>
                    </div><!-- form-group -->

                    <hr>

                  </div><!-- form-settings -->
                </form>
                </div><!-- tab-pane -->
              </div><!-- tab-content -->
            </div><!-- card -->
          </div><!-- col -->
        </div><!-- row -->
      </div><!-- content-body -->
    </div><!-- content -->

    @endsection
<script src="{{asset('assets/back-end/lib/jquery/jquery.min.js')}}"></script>
<script>
  $(document).ready(function () {
          $('#profileForm').on('submit', function (e) {
              e.preventDefault();
              $('#login-error').hide();
              $('#Update').prop('disabled', true);
              $('#Update').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
              $('#Resetbutton').hide();
              $.ajax({
                  url: '{{ route("admin.profile-form") }}',
                  method: 'POST',
                  data: $(this).serialize(),
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  success: function (response) {
                      $('#Update').prop('disabled', false);
                      $('#Update').html('Update Profile');
                      $('#Resetbutton').show();
                      $('#login-success').text(response.message).show();
                      setTimeout(function() {
                          $('#login-success').fadeOut();
                      }, 2000);
                  },
                  error: function(xhr) {
                      $('#Update').prop('disabled', false);
                      $('#Update').html('Update Profile');
                      $('#Resetbutton').show();

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

  $(document).ready(function () {
          $('#PasswordForm').on('submit', function (e) {
              e.preventDefault();
              $('#Password-error').hide();
              $('#ChangePassword').prop('disabled', true);
              $('#ChangePassword').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
              $.ajax({
                  url: '{{ route("admin.Password-form") }}',
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