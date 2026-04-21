@extends('layouts.user.app')

@section('content')
<style>
    .media-card {
        width: 100%;
        aspect-ratio: 1 / 1;
        object-fit: cover;
        border-radius: 0.5rem;
    }

    .media-wrapper {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .delete-photo-btn {
        z-index: 10;
    }
</style>

<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="container mt-4">
                <h4>{{ __('messages.Upload a Photo') }}</h4>
                <form action="{{ route('user.upload.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <input type="file" name="media[]" class="form-control" required multiple accept="image/*,video/*">
                    </div>
                    <button type="submit" class="btn btn-primary">{{ __('messages.Upload Media') }}</button>
                </form>

                @if (session('success'))
                    <div class="alert alert-success mt-3">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="container mt-4">
                <h4>{{ __('messages.Your Uploaded Photos') }}</h4>

                @if (count($photos))
                    <div class="row">
                        @foreach ($photos as $photo)
                            @php
                                $extension = strtolower(pathinfo($photo, PATHINFO_EXTENSION));
                                $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                $isVideo = in_array($extension, ['mp4', 'mov', 'webm', 'ogg']);
                            @endphp
                            <div class="col-md-3 mb-4">
                                <div class="card media-wrapper position-relative">
                                    @if ($isImage)
                                        <img src="{{ $photo }}" class="media-card" alt="User Photo or Video Thumbnail">
                                    @elseif ($isVideo)
                                        <video class="media-card" controls>
                                            <source src="{{ $photo }}" type="video/{{ $extension }}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @else
                                        <p class="text-center p-3">Unsupported file format.</p>
                                    @endif

                                    <button
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2 delete-photo-btn"
                                        data-photo="{{ $photo }}" title="Delete">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>No media uploaded yet.</p>
                @endif
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.delete-photo-btn').forEach(button => {
            button.addEventListener('click', function () {
                const photoUrl = this.getAttribute('data-photo');

                Swal.fire({
                    title: '{{ __("messages.Are you sure?") }}',
                    text: '{{ __("messages.This photo will be permanently deleted.") }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '{{ __("messages.Yes, delete it!") }}',
                    cancelButtonText: '{{ __("messages.Cancel") }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch("{{ route('user.photos.delete') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({ photo: photoUrl })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Deleted!', data.message, 'success')
                                    .then(() => location.reload());
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(() => {
                            Swal.fire('Error', 'Something went wrong.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>
@endsection
