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

    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card shadow-xss w-100 d-block d-flex border-0 p-4 mb-3">
                            <div class="card-body d-flex align-items-center p-0">
                                <h2 class="fw-700 mb-0 mt-0 font-md text-grey-900"> {{ __('messages.Message') }}</h2>
                                <div class="search-form-2 ms-auto">
                                    <a href="{{ route('user.send.message') }}"
                                        class="d-none d-lg-block bg-success p-3 z-index-1 rounded-3 text-white font-xsssss text-uppercase fw-700 ls-3"
                                        style="z-index: 1;"> {{ __('messages.Send a Message') }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="container mt-4">
                            <!-- Table -->
                            <div class="table-responsive">
                                <table id="blogsTable" class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            
                                            <th> {{ __('messages.Subject') }}</th>
                                            <th> {{ __('messages.View') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($messages) && count($messages) > 0)
                                            @foreach ($messages as $blog)
                                                <tr>
                                                   
                                                    <td>
                                                        <strong>{{ $blog->subject }}</strong><br>
                                                        <small>{{ \Illuminate\Support\Str::words(strip_tags($blog->body), 20, '...') }}</small>
                                                    </td>

                                                    <td> <a href="{{ route('user.messages.show', $blog->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                             {{ __('messages.View') }}
                                                        </a></td>

                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8" class="text-center"> {{ __('messages.No Message found.') }}</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main content -->
@endsection
