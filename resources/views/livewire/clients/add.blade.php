<div>
    <form>
        <x-forms.input wire:model.lazy="name" :label="__('text.Name')" name="name" value=""/>
        <x-forms.input wire:model.lazy="email" :label="__('text.Email')" name="email" value=""/>
        <x-forms.input wire:model.lazy="phone" :label="__('text.Phone')" name="phone" value=""/>
        <x-forms.textarea wire:model.lazy="address" :label="__('text.Address')" name="address" value=""/>
        <x-forms.input wire:model.lazy="internal" :label="__('text.Internal')"
                       name="internal" value="" type="checkbox" style="width: 2rem; height: 2rem"/>
        <button onclick="$('#saveSpinner').attr('hidden', false)" wire:click="submit" wire:loading.attr="disabled"
                type="button" class="btn btn-success">
            <span id="saveSpinner" hidden class="spinner-border spinner-border-sm"></span>
            @lang('text.Save')
        </button>
    </form>
</div>
