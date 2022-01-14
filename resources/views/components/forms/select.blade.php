<div class="my-3">
    <label>{{$label}}:</label>
    <select name="{{$name}}" class="form-control @error($name) is-invalid @enderror {{$attributes->get('class')}}" {{$attributes}}>
        <option hidden></option>
        @foreach($items as $key => $val)
            <option {{((old($name) ?? $value ?? '') == $key) ? 'selected' : ''}} value="{{$key}}">{{$val}}</option>
        @endforeach
    </select>
    @error($name)
    <span class="invalid-feedback">{{$message}}</span>
    @enderror
</div>
