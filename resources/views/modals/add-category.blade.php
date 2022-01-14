
<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">@lang('text.AddCategory')</h5>
                <button wire:click="$emit('categoryClose')" id="categoryClose" type="button" class="btn btn-danger btn-close" data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>
            <div class="modal-body">
                <livewire:categories.add/>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('category:event', function (){
        $('#categoryClose').click();
    });
</script>
