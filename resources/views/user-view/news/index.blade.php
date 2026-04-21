@extends('layouts.user.app')

@section('content')
    <style>
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            /* Makes the modal vertically centered */
        }

        @media (min-width: 576px) {
            .modal {
                --bs-modal-margin: 5.75rem;
                --bs-modal-box-shadow: var(--bs-box-shadow);
            }
        }
    </style>
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
            <div class="row">
                <div class="col-xl-12">
                    <div class="card shadow-xss w-100 border-0 p-4 mb-3">
                        <div class="card-body d-flex align-items-center flex-wrap p-0">
                            <h2 class="fw-700 mb-0 font-md text-grey-900">{{ __('messages.News List') }}</h2>
                            <div class="ms-auto mt-3 mt-md-0">
                                <a href="{{ route('user.news.create') }}"
                                   class="btn btn-success text-white font-xssss fw-700 text-uppercase">
                                    {{ __('messages.Create a News') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-4">
                        <!-- Responsive Scrollable Table -->
                        <div class="table-responsive">
                            <table id="newsTable" class="table table-bordered table-striped nowrap w-100">
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
                                                          method="POST" class="d-inline delete-news-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                                class="btn btn-sm btn-outline-danger delete-news-button"
                                                                data-id="{{ $news->id }}">
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
                        </div> <!-- /.table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- main content -->
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
