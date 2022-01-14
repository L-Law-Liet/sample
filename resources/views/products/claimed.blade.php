{{-- Extends layout --}}
@extends('layout.default')
{{-- Content --}}
@section('content')
    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('text.ClaimedProductsForRepair')</h3>
            </div>
        </div>
        <div class="card-body">
            <livewire:products.claimed
                :sortBy="$sortBy ?? ''"
            />
        </div>

    </div>
@endsection

{{-- Styles Section --}}
@section('styles')
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .label-light-revised {
            color: darkcyan;
            background-color: lightcyan;
            }
        .label-light-unable {
            color: darkred;
            background-color: lightcoral;
        }
    </style>
@endsection
@section('scripts')
    @livewireScripts
@endsection
