@foreach($PlanEditInfo as $plan)
	  
		<div class="modal-body">      
            <div id="editplan-error" class="alert alert-danger light alert-dismissible fade show" style="display:none;"></div>
            <div id="editplan-success" class="alert alert-success light alert-dismissible fade show" style="display:none;"></div>                    
            <div class="mb-3">
                <label for="name" class="form-label">{{__("messages.Plan name")}} </label>
                <input type="text" class="form-control" id="edit_name" name="edit_name" placeholder="{{__('messages.Enter Plan Name')}}" value="{{ $plan->name }}">
            </div>
             <div class="mb-3">
                <label for="name" class="form-label">{{ __('messages.Plan name in Chinese') }} </label>
                <input type="text" class="form-control" id="chinese_name" name="chinese_name" placeholder="{{__('messages.Enter Plan Name in Chinese')}}" value="{{ $plan->chinese_name }}">
            </div>
             <div class="mb-3">
                <label for="name" class="form-label">{{ __('messages.Plan name in Korean') }} </label>
                <input type="text" class="form-control" id="korean_name" name="korean_name" placeholder="{{__('messages.Enter Plan Name in Korean')}}" value="{{ $plan->korean_name }}">
            </div>
            <div class="row">
              <div class="col-sm-6">
                <h4>{{__("messages.Monthly")}}</h4>
                <div class="mb-3">
                    <label for="code" class="form-label">{{__("messages.Price")}}</label>
                    <input type="text" class="form-control" id="edit_monthly_price" name="edit_monthly_price" placeholder="{{__('messages.Price')}}" value="{{ $plan->monthly_price }}">
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">{{__("messages.Famillies [n] / Unlimited")}}</label>
                    <input type="text" class="form-control" id="edit_monthly_famillies" name="edit_monthly_famillies" placeholder="{{__('messages.[n] / Unlimited')}}" value="{{ $plan->monthly_famillies }}">
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">{{__("messages.Members per family  [n] / Unlimited")}} </label>
                    <input type="text" class="form-control" id="edit_monthly_members" name="edit_monthly_members" placeholder="{{__('messages.[n] / Unlimited')}}" value="{{ $plan->monthly_members }}">
                </div>
                <div class="mb-3">
                    <!--<label for="code" class="form-label">{{__("messages.Private Family  [n] / Unlimited")}}</label>-->
                    <input type="hidden" class="form-control" id="edit_monthly_private" name="edit_monthly_private" placeholder="{{__('messages.[n] / Unlimited')}}" value="{{ $plan->monthly_private }}">
                </div>
              </div>
              <div class="col-sm-6">
                <h4>{{__("messages.Yearly")}} </h4>
                <div class="mb-3">
                    <label for="code" class="form-label">{{__("messages.Price")}}</label>
                    <input type="text" class="form-control" id="edit_yearly_price" name="edit_yearly_price" placeholder="{{__('messages.Price')}}" value="{{ $plan->yearly_price }}">
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">{{__("messages.Famillies [n] / Unlimited")}}</label>
                    <input type="text" class="form-control" id="edit_yearly_famillies" name="edit_yearly_famillies" placeholder="{{__('messages.[n] / Unlimited')}}" value="{{ $plan->yearly_famillies }}">
                </div>
                <div class="mb-3">
                    <label for="code" class="form-label">{{__("messages.Members per family  [n] / Unlimited")}}</label>
                    <input type="text" class="form-control" id="edit_yearly_members" name="edit_yearly_members" placeholder="{{__('messages.[n] / Unlimited')}}" value="{{ $plan->yearly_members }}">
                </div>
                <div class="mb-3">
                    <!--<label for="code" class="form-label">{{__("messages.Private Family  [n] / Unlimited")}}</label>-->
                    <input type="hidden" class="form-control" id="edit_yearly_private" name="edit_yearly_private" placeholder="{{__('messages.[n] / Unlimited')}}" value="{{ $plan->yearly_private }}">
                </div>
              </div>
              <div class="col-sm-8 row">
              <div class="col-sm-6">
                <div class="mb-3">
                    <div class="custom-control custom-switch">
                      <input type="hidden" class="custom-control-input" id="edit_pdfexport" name="edit_pdfexport" value="1" @checked($plan->pdfexport == '1')>
                      <!--<label class="custom-control-label" for="edit_pdfexport">{{__("messages.PDF Export")}} </label>-->
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-control custom-switch">
                      <input type="hidden" class="custom-control-input" id="edit_heritatefamilies" name="edit_heritatefamilies" value="1" @checked($plan->heritatefamilies == '1')>
                      <!--<label class="custom-control-label" for="edit_heritatefamilies">{{__("messages.Heritate families")}} </label>-->
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-control custom-switch">
                      <input type="hidden" class="custom-control-input" id="edit_support" name="edit_support" value="1" @checked($plan->support == '1')>
                      <!--<label class="custom-control-label" for="edit_support">{{__("messages.Support")}}</label>-->
                    </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="mb-3">
                    <div class="custom-control custom-switch">
                      <input type="hidden" class="custom-control-input" id="edit_showads" name="edit_showads" value="1" @checked($plan->showads == '1')>
                      <!--<label class="custom-control-label" for="edit_showads">{{__("messages.show ads")}}</label>-->
                    </div>
                </div>
                <div class="mb-3">
                    <div class="custom-control custom-switch">
                      <input type="hidden" class="custom-control-input" id="edit_createalbums" name="edit_createalbums" value="1" @checked($plan->createalbums == '1')>
                      <!--<label class="custom-control-label" for="edit_createalbums">{{__("messages.Create albums")}} </label>-->
                    </div>
                </div>
              </div>
              </div>
            </div>
            <input type="hidden" class="form-control" id="edit_id" name="edit_id" value="{{ $plan->id }}">
		</div>                   
        
@endforeach  