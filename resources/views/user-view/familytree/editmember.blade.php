<!-- Modal HTML -->
 @php
  $types = \App\Models\Types::where(['is_active' => 1])->get();
  $generations = \App\Models\Generations::where(['is_active' => 1])->get();
 @endphp
<div class="modal fade" id="editMemberModal" tabindex="-1" role="dialog" aria-labelledby="editMemberModalLabel"
    aria-hidden="true" style="display:none;">
    <div class="modal-dialog" role="document" style="max-width: 45%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="fw-700 mb-0 mt-0 font-md text-grey-900" id="editMemberModalLabel"> {{ __('messages.Edit Member') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editMemberForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div id="form-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;">
                </div>
                <div id="form-success" class="alert alert-success light alert-dismissible fade show"
                    style="display:none;"></div>
                <div class="modal-body">
                    <div class="">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                    data-bs-target="#homeEdit" type="button" role="tab" aria-controls="home"
                                    aria-selected="true"> {{ __('messages.Personal') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                    data-bs-target="#profileEdit" type="button" role="tab" aria-controls="profile"
                                    aria-selected="false"> {{ __('messages.Contact') }}</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="bio-tab" data-bs-toggle="tab"
                                    data-bs-target="#messagesEdit" type="button" role="tab"
                                    aria-controls="messages" aria-selected="false"> {{ __('messages.Biographical') }}</button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <br>
                            <div role="tabpanel" class="tab-pane active" id="homeEdit">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.First Name:') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('messages.Enter First Name') }}"
                                            name="firstname" value="{{ old('firstname', $member->firstname) }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.Last Name:') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('messages.Enter Last Name') }}"
                                            name="lastname" value="{{ old('lastname', $member->lastname) }}" />
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.Email:') }}</label>
                                        <input type="text" class="form-control" placeholder="{{ __('messages.Enter Email') }}"
                                            name="email" value="{{ old('email', $member->email) }}" />
                                    </div>
                                    <div class="col-md-4 mt-2">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.Relation Type:') }}</label>
                                        <select class="form-control" name="type">
                                            @foreach ($types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                      <div class="col-md-4 mt-2">
                                        <label class="form-label mont-font fw-600 font-xsss"> {{ __('messages.Relation Type:') }}</label>
                                        <select class="form-control" name="type">
                                            @foreach ($generations as $generation)
                                            <option value="{{ $generation->id }}">{{ $generation->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div><br>
                                <div class="row">
                                    <div class="col">
                                        <input class="choice" id="cb1Edit" value="1" name="gender"
                                            type="radio" {{ $member->gender == 1 ? 'checked' : '' }} />
                                        <label class="tgl-btn mr-2" for="cb1Edit"> {{ __('messages.Female') }}</label>
                                        <input class="choice" id="cb2Edit" value="2" name="gender"
                                            type="radio" {{ $member->gender == 2 ? 'checked' : '' }} />
                                        <label class="tgl-btn" for="cb2Edit"> {{ __('messages.Male') }}</label>
                                    </div>
                                    <div class="col">
                                        <div class="form-group mb-0">
                                            <input class="tgl tgl-light" id="cbs1Edit" value="1"
                                                name="death" type="checkbox"
                                                {{ $member->death ? 'checked' : '' }} />
                                            <label class="tgl-btn mt-3" for="cbs1Edit"></label>
                                            <label class="form-label"> {{ __('messages.This person is alive') }}</label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="form-label"> {{ __('messages.Village:') }}</label>
                                    <input type="text" name="village" placeholder="{{ __('messages.Enter Village') }}"
                                        class="form-control datepicker-here"
                                        value="{{ old('village', $member->village) }}" />
                                </div><br>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="form-label"> {{ __('messages.Birth Date:') }}</label>
                                        <input type="date" name="birthdate"
                                            class="form-control datepicker-here"
                                            value="{{ old('birthdate', $member->birthdate) }}"
                                            data-position='top left' />
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label"> {{ __('messages.Marriage Date:') }}</label>
                                        <input type="date" name="marriagedate"
                                            class="form-control datepicker-here"
                                            value="{{ old('marriagedate', $member->marriagedate) }}"
                                            data-position='top left' />
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-label"> {{ __('messages.Death Date:') }}</label>
                                        <input type="date" name="deathdate"
                                            class="form-control datepicker-here"
                                            value="{{ old('deathdate', $member->deathdate) }}"
                                            data-position='top left' />
                                    </div>
                                </div><br>
                                <label class="form-label"> {{ __('messages.Link this member to a user:') }}</label>
                                <input type="text" class="form-control" name="user"
                                    value="{{ old('user', $member->user) }}" />
                                
                                <div class="form-avatar">
                                    
                                    <div class="form-inline">
                                        @for ($i = 1; $i <= 18; $i++)
                                            <div class="form-group">
                                            <input type="radio" name="avatar" value="{{ $i }}"
                                                id="sradioeEdit{{ $i }}" class="choice image"
                                                {{ $member->avatar == $i ? 'checked' : '' }}>
                                            <label for="sradioeEdit{{ $i }}"><b><img
                                                        src="{{ asset('assets/front-end/avatar/' . $i . '.jpg') }}" /></b></label>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="profileEdit">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Facebook:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Facebook') }}"
                                        name="facebook" value="{{ old('facebook', $member->facebook) }}" />
                                </div>
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Twitter:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Twitter') }}"
                                        name="twitter" value="{{ old('twitter', $member->twitter) }}" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Instagram:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Instagram') }}"
                                        name="instagram" value="{{ old('instagram', $member->instagram) }}" />
                                </div>

                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Home Tel:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Home Tel') }}"
                                        name="tel" value="{{ old('tel', $member->tel) }}" />
                                </div>
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Mobile:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Mobile') }}"
                                        name="mobile" value="{{ old('mobile', $member->mobile) }}" />
                                </div>
                            </div>
                            <label class="form-label mt-2"> {{ __('messages.Website:') }}</label>
                            <input type="text" class="form-control" placeholder="{{ __('messages.Enter Website') }}"
                                name="site" value="{{ old('site', $member->site) }}" />
                        </div>
                        <div role="tabpanel" class="tab-pane" id="messagesEdit">
                            <div class="row">
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Birthplace:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Birth Place') }}"
                                        name="birthplace" value="{{ old('birthplace', $member->birthplace) }}" />
                                </div>
                                <div class="col">
                                    <label class="form-label"> {{ __('messages.Deathplace:') }}</label>
                                    <input type="text" class="form-control" placeholder="{{ __('messages.Enter Death Place') }}"
                                        name="deathplace" value="{{ old('deathplace', $member->deathplace) }}" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                    <div class="col">
                                        <label class="form-label"> {{ __('messages.Home Town:') }}</label>
                                        <input class="form-control" type="text" placeholder="{{ __('messages.Enter Home Town') }}"
                                            name="home_town" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label"> {{ __('messages.School:') }}</label>
                                        <input class="form-control" type="text" placeholder="{{ __('messages.Enter School') }}"
                                            name="school" />
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col">
                                        <label class="form-label"> {{ __('messages.Background:') }}</label>
                                        <input class="form-control" type="text"
                                            placeholder="{{ __("messages.Enter Background Details") }}" name="background_details" />
                                    </div>
                                    <div class="col">
                                        <label class="form-label"> {{ __('messages.Business Info:') }}</label>
                                        <input class="form-control" type="text" placeholder="{{ __('messages.Enter Business Info') }}"
                                            name="business_info" />
                                    </div>
                                </div>
                            <label class="form-label mt-2"> {{ __('messages.Profession:') }}</label>
                            <textarea class="form-control" name="profession" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                 placeholder="{{ __("messages.Enter Profession") }}">{{ old('profession', $member->profession) }}</textarea>
                            <label class="form-label mt-2"> {{ __('messages.Company:') }}</label>
                            <textarea class="form-control" name="company" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Company") }}">{{ old('company', $member->company) }}</textarea>
                            <label class="form-label mt-2"> {{ __('messages.Interests:') }}</label>
                            <textarea class="form-control" name="interests" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Interests") }}">{{ old('interests', $member->interests) }}</textarea>
                            <label class="form-label mt-2"> {{ __('messages.Bio Notes:') }}</label>
                            <textarea class="form-control" name="bio" style="min-height: calc(2.5em + 0.75rem + 50px);"
                                placeholder="{{ __("messages.Enter Bio Notes") }}">{{ old('bio', $member->bio) }}</textarea>
                        </div>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">{{ __('messages.Save') }}</button>
        </div>
        </form>
    </div>
</div>
</div>
@section('scripts')
<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
<script src="https://d3js.org/d3.v6.min.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
@endsection