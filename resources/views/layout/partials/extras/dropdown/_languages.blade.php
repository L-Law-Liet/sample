{{-- Nav --}}
<ul class="navi navi-hover py-4">
    {{-- Item --}}
    @foreach(config('app.lang_imgs') as $key => $val)
    <li class="navi-item">
        <a href="{{route('lang', $key)}}" class="navi-link">
            <span class="symbol symbol-20 mr-3">
                <img src="{{ asset($val) }}" alt=""/>
            </span>
            <span class="navi-text">{{__(config('app.lang_names')[$key])}}</span>
        </a>
    </li>
    @endforeach
</ul>
