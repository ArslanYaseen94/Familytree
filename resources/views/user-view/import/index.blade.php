@extends('layouts.user.app')

@section('content')
    <style>
        @media (min-width: 1200px) {
            .pricing-header {
                max-width: 100% !important;
            }
        }

        .pricing-features li {
            text-align: center
        }
    </style>
    <div class="main-content right-chat-active">
        <div class="middle-sidebar-bottom">
            <div class="middle-sidebar-left pe-0">
                <div class="container py-5">
                    <form action="{{ route('members.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="excel_file" class="form-label"> {{ __('messages.Import Members Excel') }}</label>
                            <input type="file" name="excel_file" id="excel_file" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary"> {{ __('messages.Import') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
