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
                    <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                        <div class="card-body d-flex align-items-center flex-wrap p-0">
                            <h2 class="fw-700 mb-0 font-md text-grey-900">{{ __('messages.Blogs List') }}</h2>
                            <div class="ms-auto mt-3 mt-md-0">
                                <a href="{{ route('user.blog.create') }}"
                                    class="btn btn-success text-white font-xssss fw-700 text-uppercase">
                                    {{ __('messages.Create a Blog') }}
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="container mt-4">
                        <!-- Table -->
                        <div class="table-responsive">
                            <table id="blogsTable" class="table table-bordered table-striped nowrap w-100">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('messages.Title') }}</th>
                                        <th>{{ __('messages.Slug') }}</th>
                                        <th>{{ __('messages.Status') }}</th>
                                        <th>{{ __('messages.Published At') }}</th>
                                        <th>{{ __('messages.Featured Image') }}</th>
                                        <th>{{ __('messages.Created At') }}</th>
                                        <th>{{ __('messages.Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($blogs as $blog)
                                        <tr>
                                            <td>{{ $blog->title }}</td>
                                            <td>{{ $blog->slug }}</td>
                                            <td>
                                                @if ($blog->status === 'published')
                                                    <span class="badge bg-success">{{ __('messages.Published') }}</span>
                                                @elseif ($blog->status === 'draft')
                                                    <span class="badge bg-secondary">{{ __('messages.Draft') }}</span>
                                                @else
                                                    <span class="badge bg-warning text-dark">{{ __('messages.Archived') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $blog->published_at ? date('d-m-Y H:i', strtotime($blog->published_at)) : '—' }}</td>
                                            <td>
                                                @if ($blog->featured_image)
                                                    <img src="{{ asset($blog->featured_image) }}" alt="Image" style="width: 60px; height: 40px; object-fit: cover;">
                                                @else
                                                    <span class="text-muted">{{ __('messages.No image') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($blog->created_at)) }}</td>
                                            <td>
                                                <div class="d-flex flex-column flex-md-row gap-1">
                                                    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-pencil"></i> {{ __('messages.Edit') }}
                                                    </a>
                                                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" class="delete-blog-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger delete-button">
                                                            <i class="bi bi-trash"></i> {{ __('messages.Delete') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">{{ __('messages.No blogs found.') }}</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div> <!-- end table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- main content -->
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-button').forEach(button => {
                button.addEventListener('click', function() {
                    const blogId = this.getAttribute('data-id');
                    const form = document.getElementById(`delete-form-${blogId}`);

                    Swal.fire({
                        title: "{{ __('messages.Are you sure?') }}",
                        text: " {{ __('messages.This blog will be deleted permanently.') }}",
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
        $('#blogsTable').DataTable({
            responsive: true,
            scrollX: true,
            paging: false,
            ordering: false,
            info: false
        });
    });
</script>
@endsection
