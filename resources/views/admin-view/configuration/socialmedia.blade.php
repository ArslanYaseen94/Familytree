@extends('layouts.admin.app')

@section('content')
 <div class="content-header">
         <div>
             <nav aria-label="breadcrumb">
                 <ol class="breadcrumb">
                     <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">
                             {{ __('messages.Family Tree Builder') }}</a></li>
                     <li class="breadcrumb-item active" aria-current="page">{{ __('messages.Social Media') }}</li>
                 </ol>
             </nav>
         </div>
     </div>
<div class="container py-4">

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5> {{ __('messages.Google') }}</h5>
                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                            data-bs-target="#googleCredentialsModal">
                            🎯 {{ __('messages.Credentials Setup') }}
                        </button>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="google_status" id="googleActive">
                        <label class="form-check-label" for="googleActive">Active</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="google_status" id="googleInactive" checked>
                        <label class="form-check-label" for="googleInactive">Inactive</label>
                    </div>

                    <label class="form-label fw-semibold"> {{ __('messages.Callback URI') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" readonly value="" id="googleCallback">
                        <button class="btn btn-secondary" onclick="copyToClipboard('googleCallback')">📋 {{ __('messages.Copy URI') }}</button>
                    </div>

                    <input type="text" class="form-control mb-3" placeholder="Client ID">
                    <input type="text" class="form-control mb-3" placeholder="Client Secret">

                    <button class="btn btn-primary w-100"> {{ __('messages.Save') }}</button>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5> {{ __('messages.Facebook') }}</h5>
                        <button class="btn btn-sm btn-dark" data-bs-toggle="modal"
                            data-bs-target="#facebookCredentialsModal">
                            🎯 {{ __('messages.Credentials Setup') }}
                        </button>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="facebook_status" id="facebookActive">
                        <label class="form-check-label" for="facebookActive">Active</label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="radio" name="facebook_status" id="facebookInactive">
                        <label class="form-check-label" for="facebookInactive">Inactive</label>
                    </div>

                    <label class="form-label fw-semibold"> {{ __('messages.Callback URI') }}</label>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" readonly value="" id="facebookCallback">
                        <button class="btn btn-secondary" onclick="copyToClipboard('facebookCallback')">📋 {{ __('messages.Copy URI') }}</button>
                    </div>

                    <input type="text" class="form-control mb-3" placeholder="App ID">
                    <input type="text" class="form-control mb-3" placeholder="App Secret">

                    <button class="btn btn-primary w-100"> {{ __('messages.Save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <h5 class="mb-3">🌐 {{ __('messages.Social Media') }}</h5>
        <form action="" method="POST">
            @csrf
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label"> {{ __('messages.Name') }}</label>
                        <select class="form-select">
                            <option selected>---Select Social Media---</option>
                            <option value="facebook">Facebook</option>
                            <option value="instagram">Instagram</option>
                            <option value="twitter">Twitter</option>
                            <option value="linkedin">LinkedIn</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"> {{ __('messages.Social media link') }}</label>
                        <input type="text" class="form-control" placeholder="Ex : facebook.com/your-page-name">
                    </div>
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button class="btn btn-light"> {{ __('messages.Reset') }}</button>
                        <button class="btn btn-primary"> {{ __('messages.Save') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="googleCredentialsModal" tabindex="-1" aria-labelledby="googleCredentialsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="googleCredentialsModalLabel">Google API Set up Instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol class="ps-3">
                    <li>
                        Go to the Credentials page
                        <a href="https://console.developers.google.com/apis/credentials" target="_blank"
                            class="text-primary">Click Here</a>
                    </li>
                    <li>Click <strong>Create credentials</strong> &gt; <strong>OAuth client ID</strong>.</li>
                    <li>Select the <strong>Web application</strong> type.</li>
                    <li>Name your OAuth 2.0 client.</li>
                    <li>Click <strong>ADD URI</strong> in <em>Authorized redirect URIs</em>, provide the Callback URI
                        shown on this page, and click <strong>Create</strong>.</li>
                    <li>Copy <strong>Client ID</strong> and <strong>Client Secret</strong>, paste them in the input
                        fields below, and click <strong>Save</strong>.</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- Facebook Credentials Modal -->
<div class="modal fade" id="facebookCredentialsModal" tabindex="-1" aria-labelledby="facebookCredentialsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">
            <div class="modal-header">
                <h5 class="modal-title" id="facebookCredentialsModalLabel">Facebook API Set up Instructions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ol class="ps-3">
                    <li>Go to the Facebook Developer page
                        <a href="https://developers.facebook.com/" target="_blank" class="text-primary">Click
                            here</a>
                    </li>
                    <li>Go to <strong>Get Started</strong> from the navbar</li>
                    <li>From the Register tab, press <strong>Continue</strong> (if needed)</li>
                    <li>Provide your primary email and press <strong>Confirm Email</strong> (if needed)</li>
                    <li>In the About section, select <strong>Other</strong> and press <strong>Complete
                            Registration</strong></li>
                    <li>Create App &gt; Select an app type and press <strong>Next</strong></li>
                    <li>Complete the app details form and press <strong>Create App</strong></li>
                    <li>From <strong>Facebook Login</strong>, press <strong>Set Up</strong></li>
                    <li>Select <strong>Web</strong></li>
                    <li>Provide your Site URL (e.g., <code>https://example.com</code>) and press <strong>Save</strong>
                    </li>
                    <li>Go to <strong>Facebook Login &gt; Settings</strong> (left sidebar)</li>
                    <li>Ensure <strong>Client OAuth Login</strong> is <strong>enabled</strong></li>
                    <li>Provide the <strong>Valid OAuth Redirect URI</strong> (see on screen) and click <strong>Save
                            Changes</strong></li>
                    <li>Now go to <strong>Settings &gt; Basic</strong> (left sidebar)</li>
                    <li>Fill out the form and press <strong>Save Changes</strong></li>
                    <li>Copy the <strong>Client ID</strong> and <strong>Client Secret</strong>, paste them into the
                        input fields, and press <strong>Save</strong></li>
                </ol>
            </div>
        </div>
    </div>
</div>

{{-- Copy to Clipboard Script --}}
<script>
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); // For mobile devices
        navigator.clipboard.writeText(copyText.value).then(function() {
            alert("Copied the URI: " + copyText.value);
        });
    }
</script>
@endsection