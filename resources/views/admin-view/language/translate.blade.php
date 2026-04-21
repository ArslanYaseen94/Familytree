@extends('layouts.admin.app')

@section('content') 
<div class="content-header">
    <div>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">{{__("messages.Family Tree Builder")}}</a></li>
                <li class="breadcrumb-item">{{__("messages.System Setup")}}</li>
                <li class="breadcrumb-item active" aria-current="page">{{__("messages.Language")}}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="content-body">
    <div class="component-section">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>{{__("messages.Language Content Table")}}</h4>
        </div>
        <div class="table-responsive m-t-40">
            <table id="example1" class="table">
                <thead>
                    <tr>
                        <th class="wd-20p">{{__("messages.Key")}}</th>
                        <th class="wd-25p">{{__("messages.Value")}}</th>
                        <th class="wd-20p">{{__("messages.Update")}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $translations = include resource_path("lang/{$language_code}/messages.php");
                    @endphp
                    @foreach ($translations as $key => $translation)
                        <tr>
                            <td>{{ $key }}</td>
                            <td><input type="text" class="form-control translation-input" data-key="{{ $key }}" value="{{ $translation }}"></td>                            
                            <td><button type="button" class="btn btn-primary save-translation-btn"><i data-feather="save"></i></button> </td>
                        </tr>
                    @endforeach
                           
                </tbody>
            </table>
        </div>
    </div><!-- component-section -->
</div><!-- content-body -->
</div><!-- content -->
@endsection
@push('script')
<script src="{{ asset('assets/back-end/lib/admin/system-setup/translate.js') }}"></script>
<script>
    const saveTranslationUrl = "{{ route('admin.translate.save', ['language_code' => $language_code]) }}";
</script>
@endpush