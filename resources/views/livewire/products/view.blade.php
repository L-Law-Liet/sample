<div>
    <div class="card-body">
        <div>
            {!! QrCode::size(200)->generate(route('qr', ['key' => encrypt($product->id)])); !!}
        </div>
        <x-forms.input :label="__('text.Client')" name="" :value="$product->client->name ?? ''" readonly/>
        <x-forms.input :label="__('text.Category')" name="" :value="$product->category->name ?? ''" readonly/>
        <x-forms.input :label="__('text.ProblemType')" name="" :value="$product->problem_type->name ?? ''" readonly/>
        <x-forms.textarea :label="__('text.Description')" name="" :value="$product->description ?? ''" readonly/>
        <x-forms.input :label="__('text.Location')" name="" :value="$product->location ?? ''" readonly/>
        <x-forms.input :label="__('text.ReportedBy')" name="" :value="$product->reported_by ?? ''" readonly/>
        <div class="row justify-content-center">
            @foreach(json_decode($product->images) ?? [] as $image)
                <div class="col-auto my-3">
                    <img src="{{'/storage'.$image}}" height="150px" width="150px">
                </div>
            @endforeach
        </div>
        <x-forms.select2 onchange="loading()"  wire:model="product_status_id" :label="__('text.Status')" name="product_status_id"
                         :value="old('product_status_id') ?? $product_status_id"
                         :items="$statuses"/>
        <div>
            <h3>Comments</h3>
            @foreach($comments ?? [] as $key => $comm)
                <div class="my-6">
                    <x-forms.textarea
                        wire:model.lazy="comments.{{$key}}.body"
                        label="{{$comm['user']['name']}}" name="comments.{{$key}}.body" value=""
                        :disabled="(auth()->user()->cannot('update', new \App\Models\Comment($comm)))"/>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-outline-secondary">{{$comm['created_at']}}</button>
                        @can('delete', new \App\Models\Comment($comm))
                            <button wire:click="delete({{$comm['id']}})"
                                    class="btn btn-outline-danger"
                                    onclick="$('#deleteCommentSpinner{{$key}}').attr('hidden', false);
                                        loading()">
                                        <span id="deleteCommentSpinner{{$key}}" hidden
                                              class="spinner-border spinner-border-sm"></span>
                                @lang('text.Delete')
                            </button>
                        @endcan
                    </div>
                </div>
            @endforeach
        </div>
        <x-forms.textarea wire:model.lazy="comment" :label="__('text.Comment')" name="comment"
                          value=""/>
        <div>
            <button wire:click="store" onclick="loading()" type="button"
                    class="btn btn-success" wire:loading.attr="disabled">@lang('text.Save')</button>
        </div>
        <div class="my-3">
            @can('claim', $product)
                <div>
                    <button {{($product->user_id) ? 'disabled ' : 'wire:click=claim'}} onclick="loading()"
                            class="btn btn-info">{{($product->user_id) ? __('text.Claimed') : __('text.ClaimTheJob')}}</button>
                </div>
            @endcan
            @if($product->user_id)
                <div class="d-flex flex-md-row flex-column justify-content-between">
                    <div>
                        <h3>@lang('text.Claimed')</h3>
                        <img src="{{$product->user->avatar}}"
                             width="150px" height="150px">
                        <div class="mt-4">
                            <button class="btn btn-outline-info">
                                {{$product->user->name}}
                            </button>
                        </div>
                    </div>
                    @can('makeReport', $product)
                        <div>
                            <a class="btn btn-success" href="{{route('technician.products.report.download', $product->id)}}">@lang('text.SaveAsPDF')</a>
                        </div>
                    @endcan
                </div>
            @endif
        </div>
    </div>
    <script>
        $('.select2').change(function (e) {
        @this.set(e.target.name, e.target.value)
        });
    </script>

</div>
