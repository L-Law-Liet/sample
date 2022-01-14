<div>
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('text.Report')</h3>
            </div>
            <div>
                <a class="btn btn-success" href="{{route('admin.reports.download', ['data' => encrypt(json_encode($request))])}}">@lang('text.SaveAsPDF')</a>
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
                            <x-forms.select id="range" class="filters" onchange="loading()" wire:model.lazy="range" name="" value="" :label="__('text.Range')" :items="$ranges"/>
                        </div>
                        <div class="col-md-4">
                            <x-forms.select2 id="technician" class="filters" onchange="loading()"  wire:model.lazy="technician" :label="__('text.Technician')"
                                             name="technician" :value="$technician"
                                             :items="$technicians"/>
                        </div>
                        <div class="col-md-4">
                            <x-forms.select id="audited" class="filters" onchange="loading()" wire:model.lazy="audited" name="" value="" :label="__('text.Audited')" :items="$auditedList"/>
                        </div>
                        <div class="col-md-4">
                            <x-forms.input id="dateStart" class="filters" onchange="loading()" wire:model.lazy="dateStart" name="" value="" :label="__('text.DateStart')" type="date"/>
                        </div>
                        <div class="col-md-4">
                            <x-forms.input id="dateEnd" class="filters" onchange="loading()" wire:model.lazy="dateEnd" name="" value="" :label="__('text.DateEnd')" type="date"/>
                        </div>
                        @include('layout.partials.filters.reset')
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover dataTable" id="kt_datatable">
                    <thead>
                    <tr>
                        @foreach($ths as $th)
                            <th>{{$th}}</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user['name']}}</td>
                            @for($i = 1; $i < count($ths) - 1; $i++)
                                <td>{{$user['products'][$ths[$i]]['count'] ?? 0}}</td>
                            @endfor
                            <td>{{$user['products'][\App\Models\ProductStatus::REPAIRED_NAME()]['sum'] ?? 0}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
        $('.select2').change(function (e) {
        @this.set(e.target.name, e.target.value)
        });
    </script>
</div>
