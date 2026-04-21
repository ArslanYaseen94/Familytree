$(function() {
    'use strict';
    $('#example1').DataTable();

    // Select2
    $('.dataTables_length select').select2({ minimumResultsForSearch: Infinity });
});

$(document).ready(function() {
    $(document).on('click', '.save-translation-btn', function() {
        var button = $(this);
        button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
        var key = $(this).closest('tr').find('.translation-input').data('key');
        var value = $(this).closest('tr').find('.translation-input').val();
        $.ajax({
            url: saveTranslationUrl,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                key: key,
                value: value
            },
            success: function(response) {
                button.prop('disabled', false).html('<i data-feather="save"></i>');
                feather.replace();
            },
            error: function(xhr, status, error) {
            }
        });
    });
});
