<div>
    <div class="card-body">
        <label>@lang('text.PleaseSelectTypeOfRepair'):</label>
        <select onchange="loading()" class="custom-select" wire:model="internal" {{($product) ? 'disabled' : ''}}>
            <option hidden>@lang('text.InternalOrExternal')?</option>
            <option value="1">@lang('text.Internal')</option>
            <option value="0">@lang('text.External')</option>
        </select>
        @if($internal != -1)
            <form onsubmit="event.preventDefault();">
                <div class="row">
                    <div class="col-1{{auth()->user()->can('create', \App\Models\Client::class) ? '0' : '2'}}
                        col-md-1{{auth()->user()->can('create', \App\Models\Client::class) ? '1' : '2'}}">
                        <x-forms.select2 onchange="loading()"  wire:model="client_id" :label="__('text.Client')"
                                         name="client_id" :value="old('client_id') ?? $client_id"
                                         :items="$clients"/>
                    </div>
                    @can('create', \App\Models\Client::class)
                        <div class="col-2 col-md-1 d-flex my-3">
                            <button type="button" class="mt-auto btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addClient">
                                +
                            </button>
                        </div>
                    @endcan
                </div>
                <div class="row">
                    <div class="col-1{{auth()->user()->can('create', \App\Models\Category::class) ? '0' : '2'}}
                        col-md-1{{auth()->user()->can('create', \App\Models\Category::class) ? '1' : '2'}}">
                        <x-forms.select2 onchange="loading()"  wire:model="category_id" :label="__('text.ProductCategory')"
                                         name="category_id" :value="old('category_id') ?? $category_id"
                                         :items="$categories"/>
                    </div>
                    @can('create', \App\Models\Category::class)
                        <div class="col-2 col-md-1 d-flex my-3">
                            <button type="button" class="mt-auto btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addCategory">+
                            </button>
                        </div>
                    @endcan
                </div>
                <x-forms.textarea  wire:model.lazy="description" :label="__('text.Description')" name="description"
                                  :value="old('description') ?? $description"/>
                <x-forms.input wire:model.lazy="location" :label="__('text.ProductLocation')" name="location"
                               :value="old('location') ?? $location"/>
                @if($internal == 1)
                    <x-forms.input wire:model.lazy="reported_by" :label="__('text.ReportedBy')"
                                   name="reported_by" :value="old('reported_by') ?? $reported_by"/>
                @endif
                <div class="row">
                    <div class="col-1{{auth()->user()->can('create', \App\Models\ProblemType::class) ? '0' : '2'}}
                        col-md-1{{auth()->user()->can('create', \App\Models\ProblemType::class) ? '1' : '2'}}">
                        <x-forms.select2 onchange="loading()"  wire:model="problem_type_id" :label="__('text.ProblemType')"
                                         name="problem_type_id" :value="old('problem_type_id') ?? $problem_type_id"
                                         :items="$problems"/>
                    </div>
                    @can('create', \App\Models\ProblemType::class)
                        <div class="col-2 col-md-1 d-flex my-3">
                            <button type="button" class="mt-auto btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addType">
                                +
                            </button>
                        </div>
                    @endcan
                </div>
                <div id="dropzone" class="row mx-0 my-4 py-4 font-weight-bold text-center"
                     style="font-size: 1.4rem; color: #aaa;">@lang('text.UploadYourImages')</div>
                <div class="my-3 row">
                    @foreach($images as $k => $image)
                        <div class="col-md-3 col-12">
                            <div class="my-5 card card-body position-relative">
                                <button onclick="deleteFile('{{$k}}'); loading();" wire:click="deleteImage('{{$k}}')" type="button"
                                        class="btn btn-sm btn-danger position-absolute right-0 top-0">x</button>
                                <img width="100%" height="150px" src="{{'/storage'.$image}}">
                            </div>
                        </div>
                    @endforeach
                </div>
                <x-forms.input wire:model.lazy="serial" :label="__('text.Serial')" name="serial"
                               :value="old('serial') ?? $serial"/>
                <x-forms.select2 onchange="loading()"  wire:model="product_status_id" :label="__('text.Status')" name="product_status_id"
                                 :value="old('product_status_id') ?? $product_status_id"
                                 :items="$statuses"/>
                <x-forms.textarea wire:model.lazy="parts" :label="__('text.PartsUsedForFixing')" name="parts"
                                  :value="old('parts') ?? $parts"/>
                @if($product)
                    <div>
                        <h3>@lang('text.Comments')</h3>
                        @foreach($comments ?? [] as $key => $comm)
                            <div class="my-6">
                                <x-forms.textarea
                                    wire:model.lazy="comments.{{$key}}.body"
                                    label="{{$comm['user']['name']}}" name="" value=""
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
                @endif
                <x-forms.textarea wire:model.lazy="comment" :label="__('text.Comment')" name="comment"
                                  :value="old('comment') ?? $comment"/>
                <div class="my-3">
                    <button type="button" class="btn btn-success" wire:loading.attr="disabled"
                            wire:click="{{(is_null($product)) ? 'store' : 'update'}}"
                            onclick="$('#productSpinner').attr('hidden', false)">
                        <span id="productSpinner" hidden class="spinner-border spinner-border-sm"></span>
                        @lang('text.Save')
                    </button>
                </div>
            </form>
            @include('modals.add-client')
            @include('modals.add-category')
            @include('modals.add-problem-type')
        @endif
        <script>
            $('.select2').change(function (e) {
            @this.set(e.target.name, e.target.value)
            });
        </script>
    </div>

</div>
