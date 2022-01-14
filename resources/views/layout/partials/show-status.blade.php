<span class="label label-xl font-weight-bold label-inline p-9
                        @switch($product->product_status_id)
@case(\App\Models\ProductStatus::FOR_REPAIR)
    label-light-primary
@break
@case(\App\Models\ProductStatus::REVISED)
    label-light-revised
@break
@case(\App\Models\ProductStatus::IN_PROGRESS)
    label-light-info
@break
@case(\App\Models\ProductStatus::FOR_AUDIT)
    label-light-warning
@break
@case(\App\Models\ProductStatus::AUDIT_FAIL)
    label-light-danger
@break
@case(\App\Models\ProductStatus::REPAIRED)
    label-light-success
@break
@case(\App\Models\ProductStatus::UNABLE_TO_REPAIR)
    label-light-unable
@break
@default
    label-light-dark
@endswitch
    ">{{$product->product_status->name ?? ''}}</span>
