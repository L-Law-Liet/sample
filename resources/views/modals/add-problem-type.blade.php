
<div class="modal fade" id="addType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('text.AddProblemType')</h5>
                <button wire:click="$emit('problemTypeClose')" id="problemClose" type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <livewire:problem-types.add/>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('problem:created', function (){
        $('#problemClose').click();
    });
</script>
