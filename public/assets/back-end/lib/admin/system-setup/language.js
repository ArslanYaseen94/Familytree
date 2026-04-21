
$(function() {
    'use strict';
    $('#example1').DataTable({
        language: {
            searchPlaceholder: 'Search...',
            sSearch: '',
        }
    });

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
});

$(document).ready(function () {
    $('#addLanguageForm').on('submit', function (e) {
        e.preventDefault();
        $('#language-error').hide();
        $('#saveLanguageBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $('#Resetbutton').hide();
        var storeRoute = $('#addLanguageForm').data('route-update');
        $.ajax({
            url: storeRoute,
            method: 'POST',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                $('#saveLanguageBtn').prop('disabled', false).html('Save');
                $('#Resetbutton').show();
                $('#language-success').text(response.message).show();
                setTimeout(function() { $('#language-success').fadeOut(); }, 2000);
                location.reload(); // Reload the page to see the new language in the table
            },
            error: function(xhr) {
                $('#saveLanguageBtn').prop('disabled', false).html('Save');
                $('#Resetbutton').show();
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#language-error').html(errorHtml).show();
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    $('#language-error').text(xhr.responseJSON.message).show();
                } else {
                    $('#language-error').text('An error occurred. Please try again.').show();
                }
            }
        });
    });

    $('#updateLanguageForm').on('submit', function (e) {
        e.preventDefault();
        $('#update-language-error').hide();
        $('#updateLanguageBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        var updateRoute = $('#updateLanguageForm').data('route-update');
        $.ajax({
            url: updateRoute,
            method: 'POST',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function (response) {
                $('#updateLanguageBtn').prop('disabled', false).html('Update');
                $('#update-language-success').text(response.message).show();
                setTimeout(function() { $('#update-language-success').fadeOut(); }, 2000);

                // Update the table row without refreshing the page
                var id = $('#edit-id').val();
                var name = $('#edit-name').val();
                var code = $('#edit-code').val();
                
                var row = $('#language-row-' + id);
                row.find('.language-name').text(name);
                row.find('.language-code').text(code);

                // Update data attributes
                row.find('.dropdown-item[data-id="' + id + '"]').data('name', name).data('code', code);
                
                $('#updateLanguageModal').modal('hide');
            },
            error: function(xhr) {
                $('#updateLanguageBtn').prop('disabled', false).html('Update');
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    var errors = xhr.responseJSON.errors;
                    var errorHtml = '<ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += '<li>' + value + '</li>';
                    });
                    errorHtml += '</ul>';
                    $('#update-language-error').html(errorHtml).show();
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    $('#update-language-error').text(xhr.responseJSON.message).show();
                } else {
                    $('#update-language-error').text('An error occurred. Please try again.').show();
                }
            }
        });
    });

    $('.delete-language-btn').click(function() {        
        var languageId = $(this).data('id');
        var deleteRoute = $(this).data('route-delete');
        $('#confirmDeleteBtn').attr('data-id', languageId);
        $('#confirmDeleteBtn').attr('data-route', deleteRoute);
        $('#deleteLanguageModal').modal('show');
    });

    $('#confirmDeleteBtn').click(function(e) {
        e.preventDefault();
        $('#confirmDeleteBtn').prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        $('#CloseDeleteBtn').hide();
        var languageId = $(this).data('id');
        var deleteRoute = $(this).data('route');
        $.ajax({
            url: deleteRoute,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('#confirmDeleteBtn').prop('disabled', false).html('Yes Delete it!');
                $('#CloseDeleteBtn').show();
                $('#delete-language-success').text(response.message).show();                
                $('#language-row-' + languageId).remove();
                setTimeout(function() { $('#deleteLanguageModal').modal('hide'); }, 2000);                
                setTimeout(function() { $('#delete-language-success').fadeOut(); }, 2000);
            },
            error: function(xhr) {
                $('#deleteLanguageModal').modal('hide');
            }
        });
    });
});

function editLanguage(element) {
    var id = $(element).data('id');
    var name = $(element).data('name');
    var code = $(element).data('code');

    $('#edit-id').val(id);
    $('#edit-name').val(name);
    $('#edit-code').val(code);

    $('#updateLanguageModal').modal('show');
}
