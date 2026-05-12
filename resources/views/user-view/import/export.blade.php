@extends('layouts.user.app')

@section('content')
<div class="main-content right-chat-active">
    <div class="middle-sidebar-bottom">
        <div class="middle-sidebar-left pe-0">
            <div class="container py-5">
                <form method="POST" action="{{ route('export.members') }}">
                    @csrf
                    <div class="row g-3">
                        <!-- Export Scope -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <label>{{ __('messages.Export Scope') }}</label>
                            <select name="export_scope" id="export_scope" class="form-control" required>
                                <option value="one">{{ __('messages.One Family') }}</option>
                                <option value="all">{{ __('messages.All My Families') }}</option>
                            </select>
                        </div>

                        <!-- Family Selector -->
                        <div class="col-12 col-md-6 col-lg-4" id="family_selector">
                            <label>{{ __('messages.Select Family') }}</label>
                            <select name="family_tree_id" class="form-control">
                                <option value="">{{ __('messages.Select Family') }}</option>
                                @foreach(($families ?? []) as $family)
                                    <option value="{{ $family->id }}">{{ $family->familyid }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Filter Type -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <label>{{ __('messages.Filter Type') }}</label>
                            <select name="filter_type" id="filter_type" class="form-control" required>
                                <option value="">-- {{ __('messages.Select Filter') }} --</option>
                                <option value="id">{{ __('messages.ID Range') }}</option>
                                <option value="date">{{ __('messages.Date Range') }}</option>
                                <option value="all">{{ __('messages.All') }}</option>
                            </select>
                        </div>

                        <!-- From ID -->
                        <div class="col-12 col-md-6 col-lg-4 id-range" style="display:none;">
                            <label>{{ __('messages.From ID') }}</label>
                            <input type="number" name="from_id" class="form-control">
                        </div>

                        <!-- To ID -->
                        <div class="col-12 col-md-6 col-lg-4 id-range" style="display:none;">
                            <label>{{ __('messages.To ID') }}</label>
                            <input type="number" name="to_id" class="form-control">
                        </div>

                        <!-- From Date -->
                        <div class="col-12 col-md-6 col-lg-4 date-range" style="display:none;">
                            <label>{{ __('messages.From Date') }}</label>
                            <input type="date" name="from_date" class="form-control">
                        </div>

                        <!-- To Date -->
                        <div class="col-12 col-md-6 col-lg-4 date-range" style="display:none;">
                            <label>{{ __('messages.To Date') }}</label>
                            <input type="date" name="to_date" class="form-control">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 col-md-6 col-lg-4 align-self-end">
                            <button type="submit" class="btn btn-success w-100">
                                {{ __('messages.Export Members') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('export_scope').addEventListener('change', function() {
        const scope = this.value;
        const familySelector = document.getElementById('family_selector');
        if (!familySelector) return;
        familySelector.style.display = scope === 'one' ? 'block' : 'none';
    });

    document.getElementById('filter_type').addEventListener('change', function() {
        const type = this.value;
        document.querySelectorAll('.id-range, .date-range').forEach(el => el.style.display = 'none');
        if (type === 'id') {
            document.querySelectorAll('.id-range').forEach(el => el.style.display = 'block');
        } else if (type === 'date') {
            document.querySelectorAll('.date-range').forEach(el => el.style.display = 'block');
        }
    });
</script>
@endsection