<div>
    <button wire:click="filterToggle()" class="btn btn-info" id="filterSlideToggle"
            onclick="$('#filterSpinner').attr('hidden', false); this.disabled = true">
        <span id="filterSpinner" hidden class="spinner-border spinner-border-sm"></span>
        @lang('text.Filters')</button>
    <div id="filtersDiv" style="display: {{$filter}}">
        <div class="row">
            <div class="col-md-4">
                <x-forms.input id="idx" class="filters" onchange="loading()" wire:model.lazy="idx" name=""
                               :value="$idx" :label="__('text.ID')"/>
            </div>
            <div class="col-md-4">
                <x-forms.select2 id="categoryId" class="filters" style="width: 100%;" onchange="loading()"
                                 wire:model="categoryId" :label="__('text.Category')" name="categoryId"
                                 value=""
                                 :items="$categories"/>
            </div>
            <div class="col-md-4">
                <x-forms.select2 id="productStatusId" class="filters" style="width: 100%;" onchange="loading()"
                                 wire:model="productStatusId" :label="__('text.Status')" name="productStatusId"
                                 value=""
                                 :items="$statuses"/>
            </div>
            <div class="col-md-4">
                <x-forms.select2 id="problemTypeId" class="filters" style="width: 100%;" onchange="loading()"
                                 wire:model="problemTypeId" :label="__('text.ProblemType')" name="problemTypeId"
                                 value=""
                                 :items="$problems"/>
            </div>
            <div class="col-md-4">
                <x-forms.select2 id="clientId" class="filters" style="width: 100%;" onchange="loading()"
                                 wire:model="clientId" :label="__('text.Client')" name="clientId"
                                 value=""
                                 :items="$clients"/>
            </div>
            @include('layout.partials.filters.reset')
        </div>
    </div>
</div>
