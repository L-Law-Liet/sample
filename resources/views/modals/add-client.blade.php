
<div class="modal fade" id="addClient" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('text.AddClient')</h5>
                <button wire:click="$emit('clientClose')" id="clientClose" type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <livewire:clients.add/>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('client:event', function (){
        $('#clientClose').click();
    });
</script>
