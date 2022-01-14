<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ App\Classes\Theme\Metronic::printAttrs('html') }} {{ App\Classes\Theme\Metronic::printClasses('html') }}>
    <head>
        <meta charset="utf-8"/>

        {{-- Title Section --}}
        <title>{{ config('app.name') }}</title>

        {{-- Meta Data --}}
{{--        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>--}}
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        {{-- Favicon --}}
        <link rel="shortcut icon" href="{{ asset('media/logos/favicon.ico') }}" />

        {{-- Fonts --}}
        {{ App\Classes\Theme\Metronic::getGoogleFontsInclude() }}

        {{-- Global Theme Styles (used by all pages) --}}
        @foreach(config('layout.resources.css') as $style)
            <link href="{{ config('layout.self.rtl') ? asset (App\Classes\Theme\Metronic::rtlCssPath($style)) : asset($style) }}" rel="stylesheet" type="text/css"/>
        @endforeach

        {{-- Layout Themes (used by all pages) --}}
        @foreach  (App\Classes\Theme\Metronic::initThemes() as $theme)
            <link href="{{ config('layout.self.rtl') ? asset (App\Classes\Theme\Metronic::rtlCssPath($theme)) : asset($theme) }}" rel="stylesheet" type="text/css"/>
        @endforeach
        <style>
            .clickable {
                cursor: pointer;
            }
            .pagination {
                flex-wrap: wrap;
            }
            .select2-selection.select2-selection--single {
                min-height: calc(1.5em + 1.3rem + 2px);
            }
        </style>
        {{-- Includable CSS --}}
        @yield('styles')
    </head>

    <body {{ App\Classes\Theme\Metronic::printAttrs('body') }} {{ App\Classes\Theme\Metronic::printClasses('body') }}>
    <div id="loader" style="z-index: 500; background: rgba(255, 255, 255, 0.4); display: none"
         class="justify-content-center align-items-center position-fixed min-vh-100 min-vw-100">
        <div style="width: 3rem; height: 3rem;" class="spinner-grow text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    {{-- Global Theme JS Bundle (used by all pages)  --}}
    @foreach(config('layout.resources.js') as $script)
        <script src="{{ asset($script) }}" type="text/javascript"></script>
    @endforeach

        @if (config('layout.page-loader.type') != '')
            @include('layout.partials._page-loader')
        @endif
        @include('layout.base._layout')
        <script>var HOST_URL = "/";</script>

        {{-- Global Config (global config for global JS scripts) --}}
        <script>
            var KTAppSettings = {!! json_encode(config('layout.js'), JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES) !!};
        </script>

        {{-- Includable JS --}}
        @yield('scripts')
    <script src="{{asset('js/main.js')}}">
    </script>
    </body>
</html>

