@extends('layouts.user.app')

@section('content')
<style>
    @media (max-width: 767.98px) {
        .table-responsive {
            overflow-x: auto !important;
            -webkit-overflow-scrolling: touch;
        }
    }
</style>
<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="container mt-4">
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3">

                    <!-- Card 1 -->
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <h6 class="card-title">{{ __('messages.Total Members') }}</h6>
                                <p class="card-text display-6">{{ $member }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <h6 class="card-title">{{ __('messages.Messages') }}</h6>
                                <p class="card-text display-6">{{ $recipent }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <h6 class="card-title">{{ __('messages.Photos') }}</h6>
                                <p class="card-text display-6">{{ $fileCount }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <div class="card-body text-center d-flex flex-column justify-content-center">
                                <h6 class="card-title">{{ __('messages.News Articles') }}</h6>
                                <p class="card-text display-6">{{ $news }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <!-- News List -->
            <div class="row mt-4">
                <div class="col-xl-12">
                    <div class="card shadow-xss w-100 d-block border-0 p-4 mb-3">
                        <div class="card-body p-0">
                            <h2 class="fw-700 mb-3 font-md text-grey-900">{{ __('messages.News List') }}</h2>

                            <div class="table-responsive">
                                <table id="newsTable" class="table table-bordered table-striped nowrap" style="width:100%">
                                    <thead class="table-light">
                                        <tr>
                                            <th>{{ __('messages.Title') }}</th>
                                            <th>{{ __('messages.Slug') }}</th>
                                            <th>{{ __('messages.Category') }}</th>
                                            <th>{{ __('messages.Status') }}</th>
                                            <th>{{ __('messages.Published At') }}</th>
                                            <th>{{ __('messages.Image') }}</th>
                                            <th>{{ __('messages.Created At') }}</th>
                                            <th>{{ __('messages.Actions') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($newsList as $news)
                                        <tr>
                                            <td>{{ $news->title }}</td>
                                            <td>{{ $news->slug }}</td>
                                            <td>{{ $news->category->name ?? '—' }}</td>
                                            <td>
                                                @if ($news->status === 'published')
                                                <span class="badge bg-success">{{ __('messages.Published') }}</span>
                                                @elseif ($news->status === 'draft')
                                                <span class="badge bg-secondary">{{ __('messages.Draft') }}</span>
                                                @else
                                                <span class="badge bg-warning text-dark">{{ __('messages.Archived') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $news->published_at ? date('d-m-Y H:i', strtotime($news->published_at)) : '—' }}</td>
                                            <td>
                                                @if ($news->featured_image)
                                                <img src="{{ asset($news->featured_image) }}" alt="Image"
                                                    style="width: 60px; height: 40px; object-fit: cover;">
                                                @else
                                                <span class="text-muted">{{ __('messages.No image') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($news->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row gap-1">
                                                    <a href="{{ route('user.news.edit', $news->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> {{ __('messages.Edit') }}
                                                    </a>
                                                    <form action="{{ route('user.news.destroy', $news->id) }}"
                                                        method="POST" class="delete-news-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-outline-danger delete-news-button">
                                                            <i class="bi bi-trash"></i> {{ __('messages.Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="8" class="text-center">{{ __('messages.No news articles found.') }}</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div> <!-- middle-sidebar-left -->
    </div>
</div>


@endsection
@section('scripts')
<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.delete-news-button').forEach(button => {
            button.addEventListener('click', function() {
                const newsId = this.getAttribute('data-id');
                const form = document.getElementById(`delete-news-form-${newsId}`);

                Swal.fire({
                    title: "{{ __('messages.Are you sure?') }}",
                    text: "{{ __('messages.This news item will be permanently deleted.') }}'",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: "{{ __('messages.Yes, delete it!') }}",
                    cancelButtonText: "{{ __('messages.Cancel') }}",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>

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

    $(document).ready(function() {
        $('#familytree').on('submit', function(e) {
            e.preventDefault();
            $('#form-error').hide();
            $('#Save').prop('disabled', true);
            $('#Save').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );
            $.ajax({
                url: "{{ route('user.familytreeAdd') }}",
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
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
                            errorHtml += '<li>' + value +
                                '</li>'; // Append each error as list item
                        });
                        errorHtml += '</ul>';

                        // Display errors in a specific element with id="login-error"
                        $('#form-error').html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display single error message
                        $('#form-error').text(xhr.responseJSON.message).show();
                    } else {
                        $('#form-error').text('An error occurred. Please try again.')
                            .show();
                    }
                }
            });
        });

        $('#editfamilytree').on('submit', function(e) {
            e.preventDefault();
            $('#editform-error').hide();
            $('#editSave').prop('disabled', true);
            $('#editSave').html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...'
            );
            $.ajax({
                url: "{{ route('user.familytreeupdate') }}",
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
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
                            errorHtml += '<li>' + value +
                                '</li>'; // Append each error as list item
                        });
                        errorHtml += '</ul>';

                        // Display errors in a specific element with id="login-error"
                        $('#editform-error').html(errorHtml).show();
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Display single error message
                        $('#editform-error').text(xhr.responseJSON.message).show();
                    } else {
                        $('#editform-error').text('An error occurred. Please try again.')
                            .show();
                    }
                }
            });
        });

        $('#confirmDelete').on('click', function() {
            $('#confirmDelete').prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...'
            );

            $.ajax({
                url: "{{ route('user.familytreedelete') }}",
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
                    alert(
                        'An error occurred while deleting the family tree. Please try again.'
                    );
                    $('#confirmDelete').prop('disabled', false).html('Delete');
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#newsTable').DataTable({
            responsive: true,
            scrollX: true,
            paging: false,
            ordering: false,
            info: false
        });
    });
</script>

@endsection