{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="w-100 d-flex justify-content-between">
                <div class="card-title">
                    <h3 class="card-label">@lang('text.ProductForRepair')</h3>
                </div>
                <div>
                    <a class="btn btn-danger" href="{{url()->previous()}}">@lang('text.Back')</a>
                </div>
            </div>
        </div>

        <livewire:products.view :product="$product"/>

    </div>

@endsection

@section('scripts')
    @livewireScripts
@endsection
