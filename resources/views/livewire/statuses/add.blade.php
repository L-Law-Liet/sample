<div>
    <form wire:submit.prevent="submit">
        <x-forms.input wire:model="name" :label="__('text.Name')" name="name" value=""/>
        <button onclick="$('#saveSpinner').attr('hidden', false)" wire:loading.attr="disabled"
                type="submit" class="btn btn-success">
            <span id="saveSpinner" hidden class="spinner-border spinner-border-sm"></span>
            @lang('text.Save')
        </button>
    </form>
</div>
