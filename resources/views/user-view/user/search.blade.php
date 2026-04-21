@extends('layouts.user.app')

 @section('content')
<style>
    .modal-dialog-centered {
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* Makes the modal vertically centered */
}
</style>

<div class="main-content right-chat-active">       
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                        <div class="card-body d-flex align-items-center p-0">
                            <div class="search-form-2 ms-auto" style="width: 100%;">
                                <i class="ti-search font-xss"></i>
                                <input type="text" class="form-control text-grey-500 mb-0 bg-greylight theme-dark-bg border-0" placeholder="Search here.">
                            </div>
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </div>            
</div>
<!-- main content -->
@endsection
<div class="modal fade" id="addnewtree" tabindex="-1" role="dialog" aria-labelledby="addnewtreeLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="fw-700 mb-0 mt-0 font-md text-grey-900" id="addnewtreeLabel">Create FamilyTree</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="familytree">
            <div id="form-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
            <div id="form-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label class="mont-font fw-600 font-xsss">Family ID:</label>
                        <input type="text" class="form-control" id="familyid" name="familyid" placeholder="Family ID:">
                    </div>        
                </div>
                <div class="col-lg-12">
                    <button type="submit" id="Save" class="bg-current text-center text-white font-xsss fw-600 p-3 w175 rounded-3 d-inline-block">Save</a>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="editnewtree" tabindex="-1" role="dialog" aria-labelledby="addnewtreeLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="fw-700 mb-0 mt-0 font-md text-grey-900" id="addnewtreeLabel">Update FamilyTree</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editfamilytree">
            <input type="hidden" id="editid" name="editid">
            <div id="editform-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
            <div id="editform-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <div class="form-group">
                        <label class="mont-font fw-600 font-xsss">Family ID:</label>
                        <input type="text" class="form-control" id="editfamilyid" name="editfamilyid" placeholder="Family ID:">
                    </div>        
                </div>
                <div class="col-lg-12">
                    <button type="submit" id="editSave" class="bg-current text-center text-white font-xsss fw-600 p-3 w175 rounded-3 d-inline-block">Save</button>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true" style="display:none">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="fw-700 mb-0 mt-0 font-md text-grey-900" id="deleteConfirmationModalLabel">Delete FamilyTree</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this family tree?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" id="confirmDelete" class="btn btn-danger">Delete</button>
      </div>
    </div>
  </div>
</div>

@section('scripts')
<script>
    // Move the setDeleteId function to the top
    var deleteId = '';

    function setDeleteId(element) {
        deleteId = $(element).data('id');
    }

    function editfamilytree(element) {
        var id = $(element).data('id');
        var name = $(element).data('name');

        $('#editid').val(id);
        $('#editfamilyid').val(name);
    }

    $(document).ready(function () {
        $('#familytree').on('submit', function (e) {
            e.preventDefault();
            $('#form-error').hide();
            $('#Save').prop('disabled', true);
            $('#Save').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $.ajax({
                url: '{{ route("user.familytreeAdd") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#form-success').text(response.message).show();
                    setTimeout(function() {
                        $('#Save').prop('disabled', false);
                        $('#Save').html('Save');
                        $('#form-success').fadeOut();
                        window.location.reload();
                    }, 2000);
                },
                error: function(xhr) {
                    $('#Save').prop('disabled', false);
                    $('#Save').html('Save');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value + '</li>'; // Append each error as list item
                        });
                        errorHtml += '</ul>';

                        // Display errors in a specific element with id="login-error"
                        $('#form-error').html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display single error message
                        $('#form-error').text(xhr.responseJSON.message).show();
                    } else {
                        $('#form-error').text('An error occurred. Please try again.').show();
                    }
                }
            });
        });

        $('#editfamilytree').on('submit', function (e) {
            e.preventDefault();
            $('#editform-error').hide();
            $('#editSave').prop('disabled', true);
            $('#editSave').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $.ajax({
                url: '{{ route("user.familytreeupdate") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    $('#editform-success').text(response.message).show();
                    setTimeout(function() {
                        $('#editSave').prop('disabled', false);
                        $('#editSave').html('Save');
                        $('#editform-success').fadeOut();
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    $('#editSave').prop('disabled', false);
                    $('#editSave').html('Save');

                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        var errors = xhr.responseJSON.errors;
                        var errorHtml = '<ul>';
                        $.each(errors, function(key, value) {
                            errorHtml += '<li>' + value + '</li>'; // Append each error as list item
                        });
                        errorHtml += '</ul>';

                        // Display errors in a specific element with id="login-error"
                        $('#editform-error').html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display single error message
                        $('#editform-error').text(xhr.responseJSON.message).show();
                    } else {
                        $('#editform-error').text('An error occurred. Please try again.').show();
                    }
                }
            });
        });

        $('#confirmDelete').on('click', function() {
            $('#confirmDelete').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');
            
            $.ajax({
                url: '{{ route("user.familytreedelete") }}', // Add the correct route
                method: 'POST',
                data: {
                    id: deleteId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    $('#deleteConfirmationModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    alert('An error occurred while deleting the family tree. Please try again.');
                    $('#confirmDelete').prop('disabled', false).html('Delete');
                }
            });
        });
    });
</script>
@endsection
