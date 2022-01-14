<div class="my-3">
    <label>{{$label}}:</label>
    <textarea name="{{$name}}" class="form-control @error($name) is-invalid @enderror"
              rows="5" {{$attributes}}>{{old($name) ?? $value ?? ''}}</textarea>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror
</div>
