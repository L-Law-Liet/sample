{{-- Aside --}}

@php
    $kt_logo_image = 'logo-light.png';
@endphp

@if (config('layout.brand.self.theme') === 'light')
    @php $kt_logo_image = 'logo-dark.png' @endphp
@elseif (config('layout.brand.self.theme') === 'dark')
    @php $kt_logo_image = 'logo-light.png' @endphp
@endif

<div class="aside aside-left {{ App\Classes\Theme\Metronic::printClasses('aside', false) }} d-flex flex-column flex-row-auto" id="kt_aside">


    {{-- Aside menu --}}
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

        @if (config('layout.aside.self.display') === false)
            <div class="header-logo">
                <a href="{{ url('/') }}">
                    <img alt="{{ config('app.name') }}" src="{{ asset('media/logos/'.$kt_logo_image) }}"/>
                </a>
            </div>
        @endif

        <div
            id="kt_aside_menu"
            class="aside-menu my-4 {{ App\Classes\Theme\Metronic::printClasses('aside_menu', false) }}"
            data-menu-vertical="1"
            {{ App\Classes\Theme\Metronic::printAttrs('aside_menu') }}>

            <ul class="menu-nav {{ App\Classes\Theme\Metronic::printClasses('aside_menu_nav', false) }}">
                {{  App\Classes\Theme\Menu::renderVerMenu(config('menu_aside.'. auth()->user()->role->name .  '_items')) }}
            </ul>
        </div>
    </div>
</div>
