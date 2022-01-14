<div class="my-3">
    <div>
        <label>{{$label}}:</label>
    </div>
    <select name="{{$name}}" class="form-control select2 @error($name) is-invalid @enderror {{$attributes->get('class')}}" {{$attributes}}>
        <option selected value="0">@lang('text.None')</option>
        @foreach($items as $key => $val)
            <option {{((old($name) ?? $value ?? '') == $key) ? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
        @endforeach
    </select>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror
</div>
