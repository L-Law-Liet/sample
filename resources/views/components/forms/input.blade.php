<div class="my-3">
    <label>{{$label}}:</label>
    <input type="{{$type}}" name="{{$name}}" value="{{old($name) ?? $value ?? ''}}"
           class="form-control @error($name) is-invalid @enderror {{$attributes->get('class')}}" {{$attributes}}>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror
</div>
