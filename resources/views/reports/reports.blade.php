{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div>
        <livewire:reports.index
        :range="(int)$range ?? 0"
        :technician="(int)$technician ?? 0"
        :audited="(int)$audited ?? 0"
        :dateStart="$dateStart ?? ''"
        :dateEnd="$dateEnd ?? ''"
        />
    </div>
@endsection
@section('scripts')
    @livewireScripts
@endsection
