<div>
    <div class="table-responsive">
        <table class="table table-bordered table-hover dataTable" id="kt_datatable">
            <thead>
            <tr>
                @foreach($ths as $key => $th)
                    <th onclick="loading()" wire:click="sort('{{$key}}')" class="clickable {{$th['class']}}">{{$th['name']}}</th>
                @endforeach
                <th>@lang('text.Actions')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($products ?? [] as $product)
                <tr>
                    <td onclick="document.location='{{route('products.show', $product->id)}}'">{{$product->id}}</td>
                    <td onclick="document.location='{{route('products.show', $product->id)}}'">{{$product->category->name}}</td>
                    <td onclick="document.location='{{route('products.show', $product->id)}}'">{{$product->problem_type->name}}</td>
                    <td onclick="document.location='{{route('products.show', $product->id)}}'">{{$product->client->name}}</td>
                    <td onclick="document.location='{{route('products.show', $product->id)}}'">@include('layout.partials.show-status')</td>
                    <td onclick="document.location='{{route('products.show', $product->id)}}'">{{$product->created}}</td>
                    <td nowrap>
                        @can('disclaim', $product)
                            <button onclick="loading()" wire:click="disclaim({{$product->id}})"
                                    class="btn btn-danger">@lang('text.Disclaim')</button>
                        @endcan
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="row">
        <div class="col-md-9">
            {{$products->links()}}
        </div>
        <div class="col-md-3 d-flex justify-content-center align-items-center">
            @lang('text.RowsPerPage')
            <select onchange="loading()" wire:model="perPage" class="custom-select mx-2">
                @foreach($pages as $page)
                    <option value="{{$page}}">{{$page}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<script>
    $('.select2').change(function (e) {
    @this.set(e.target.name, e.target.value)
    });
</script>
