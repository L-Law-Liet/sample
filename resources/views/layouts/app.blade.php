{{-- Extends layout --}}
@extends('layout.default')
@section('styles')

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">


    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>

    @livewireStyles
@endsection
{{-- Content --}}
@section('content')
    <div class="min-h-screen bg-gray-100">

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')

    @livewireScripts
@endsection
