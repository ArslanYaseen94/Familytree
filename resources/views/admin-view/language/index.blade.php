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
    <div class="component-section mt-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>{{__("messages.Languages Table")}}</h4>
            <button class="btn btn-primary" data-toggle="modal" data-target="#addLanguageModal">{{__("messages.Add New Language")}}</button>
        </div>
        <table id="example1" class="table">
            <thead>
                <tr>
                    <th class="wd-20p">{{__("messages.Name")}}</th>
                    <th class="wd-25p">{{__("messages.Code")}}</th>
                    <th class="wd-20p">{{__("messages.Action")}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($languages as $language)
                    <tr id="language-row-{{ $language->id }}">
                        <td class="language-name">{{ $language->LanguageName }}</td>
                        <td class="language-code">{{ $language->LanguageCode }}</td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i data-feather="settings"></i>
                                </button>
                                <div class="dropdown-menu tx-14" aria-labelledby="dropdownMenuButton">
                                    @if ($language->LanguageCode !== 'en')
                                    <a class="dropdown-item" data-id="{{ $language->id }}" data-name="{{ $language->LanguageName }}" data-code="{{ $language->LanguageCode }}" onclick="editLanguage(this)">Update</a>
                                    <a class="dropdown-item delete-language-btn" data-route-delete="{{ route('admin.language.delete', ['id' => $language->id]) }}" data-id="{{ $language->id }}" data-name="{{ $language->LanguageName }}" data-code="{{ $language->LanguageCode }}">Delete</a>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('admin.language.translate', ['language_code' => $language->LanguageCode]) }}">Translate</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach             
            </tbody>
        </table>
    </div><!-- component-section -->
</div><!-- content-body -->
</div><!-- content -->

<!-- Add Language Modal -->
<div class="modal fade" id="addLanguageModal" tabindex="-1" aria-labelledby="addLanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLanguageModalLabel">Add Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <form id="addLanguageForm" data-route-update="{{ route('admin.language.store') }}">
                <div class="modal-body">
                    <div id="language-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
                    <div id="language-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Language Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Language Name">
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Language Code</label>
                        <input type="text" class="form-control" id="code" name="code" placeholder="Enter Language Code">
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" id="Resetbutton" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="saveLanguageBtn">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Language Modal -->
<div class="modal fade" id="updateLanguageModal" tabindex="-1" aria-labelledby="updateLanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLanguageModalLabel">Update Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <form id="updateLanguageForm" data-route-update="{{ route('admin.language.update') }}">               
                <input type="hidden" id="edit-id" name="id">
                <div class="modal-body">
                    <div id="update-language-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
                    <div id="update-language-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>                    
                    <div class="mb-3">
                        <label for="edit-name" class="form-label">Language Name</label>
                        <input type="text" class="form-control" id="edit-name" name="name" placeholder="Enter Language Name">
                    </div>
                    <div class="mb-3">
                        <label for="edit-code" class="form-label">Language Code</label>
                        <input type="text" class="form-control" id="edit-code" name="code" placeholder="Enter Language Code">
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="updateLanguageBtn">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteLanguageModal" tabindex="-1" role="dialog" aria-labelledby="deleteLanguageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateLanguageModalLabel">Delete Language</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i data-feather="x"></i></span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div id="delete-language-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>      
                <form id="deleteLanguageForm">
                    <h4>Are you sure to delete this?</h4>
                    <p class="mb-4">You will not be able to revert this!</p>
                    <button type="button" class="btn btn-secondary" id="CloseDeleteBtn" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"  id="confirmDeleteBtn">Yes Delete it!</button>                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('assets/back-end/lib/admin/system-setup/language.js') }}"></script>
@endpush
