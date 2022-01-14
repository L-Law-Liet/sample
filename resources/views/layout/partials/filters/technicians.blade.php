<div>
    <button wire:click="filterToggle()" class="btn btn-info" id="filterSlideToggle"
            onclick="$('#filterSpinner').attr('hidden', false); this.disabled = true">
        <span id="filterSpinner" hidden class="spinner-border spinner-border-sm"></span>
        @lang('text.Filters')</button>
    <div id="filtersDiv" style="display: {{$filter}}">
        <div class="row">
            <div class="col-md-4">
                <x-forms.input id="idx" class="filters" onchange="loading()" wire:model.lazy="idx" name=""
                               value="" :label="__('text.ID')"/>
            </div>
            <div class="col-md-4">
                <x-forms.input id="name" class="filters" onchange="loading()" wire:model.lazy="name" name=""
                               value="" :label="__('text.Name')"/>
            </div>
            <div class="col-md-4">
                <x-forms.input id="dateStart" class="filters" onchange="loading()" wire:model.lazy="dateStart" name=""
                               value="" :label="__('text.DateStart')" type="date"/>
            </div>
            <div class="col-md-4">
                <x-forms.input id="dateEnd" class="filters" onchange="loading()" wire:model.lazy="dateEnd" name=""
                               value="" :label="__('text.DateEnd')" type="date"/>
            </div>
            <div class="col-md-4">
                <x-forms.input id="email" class="filters" onchange="loading()" wire:model.lazy="email" name=""
                               value="" :label="__('text.Email')"/>
            </div>
            <div class="col-md-4">
                <x-forms.select id="status" class="filters" onchange="loading()" wire:model.lazy="status" name=""
                               value="" :label="__('text.Status')" :items="$statuses"/>
            </div>
            @include('layout.partials.filters.reset')
        </div>
    </div>
</div>
