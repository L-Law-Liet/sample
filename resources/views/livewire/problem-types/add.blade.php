<div>
    <form>
        <x-forms.input wire:model.lazy="name" :label="__('text.Name')" name="name" value=""/>
        <x-forms.textarea wire:model.lazy="description" :label="__('text.Description')" name="description" value=""/>
        <x-forms.input wire:model.lazy="payout" :label="__('text.Payout')" name="payout" value=""/>
        <button onclick="$('#problemSpinner').attr('hidden', false)" wire:click="submit" wire:loading.attr="disabled"
                type="button" class="btn btn-success">
            <span id="problemSpinner" hidden class="spinner-border spinner-border-sm"></span>
            @lang('text.Save')
        </button>
    </form>
</div>
