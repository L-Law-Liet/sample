<div class="card card-custom">
    <div class="card-header flex-wrap border-0 pt-6 pb-0">
        <div class="card-title">
            <h3 class="card-label">@lang('text.Report')</h3>
        </div>
        <div>
            <a class="btn btn-success" href="{{route('technician.reports.download', ['data' => encrypt(json_encode($request))])}}">@lang('text.SaveAsPDF')</a>
        </div>
    </div>
    <div class="card-body">
        <div class="mb-2">
            <button wire:click="filterToggle()" class="btn btn-info" id="filterSlideToggle"
                    onclick="$('#filterSpinner').attr('hidden', false); this.disabled = true">
                <span id="filterSpinner" hidden class="spinner-border spinner-border-sm"></span>
                @lang('text.Filters')</button>
            <div id="filtersDiv" style="display: {{$filter}}">
                <div class="row">
                    <div class="col-md-4">
                        <x-forms.select id="range" class="filters" onchange="loading()" wire:model.lazy="range" name="" :value="$range" :label="__('text.Range')" :items="$ranges"/>
                    </div>
                    <div class="col-md-4">
                        <x-forms.select id="audited" class="filters" onchange="loading()" wire:model.lazy="audited" name="" :value="$audited" :label="__('text.Audited')" :items="$auditedList"/>
                    </div>
                    <div class="col-md-4">
                        <x-forms.input id="dateStart" class="filters" onchange="loading()" wire:model.lazy="dateStart" name="" :value="$dateStart" :label="__('text.DateStart')" type="date"/>
                    </div>
                    <div class="col-md-4">
                        <x-forms.input id="dateEnd" class="filters" onchange="loading()" wire:model.lazy="dateEnd" name="" :value="$dateEnd" :label="__('text.DateEnd')" type="date"/>
                    </div>
                    @include('layout.partials.filters.reset')
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover dataTable" id="kt_datatable">
                <thead>
                <tr>
                    <th>@lang('text.Category')</th>
                    <th>@lang('text.ProblemType')</th>
                    <th>@lang('text.Payout')</th>
                    <th>@lang('text.Status')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->category->name}}</td>
                        <td>{{$product->problem_type->name}}</td>
                        <td>{{$product->problem_type->payout}}</td>
                        <td>@include('layout.partials.show-status')</td>
                    </tr>
                @endforeach
                <tr>
                    <strong>
                        @lang('text.TotalPayout'): ${{$total}}
                    </strong>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
