{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="w-100 d-flex justify-content-between">
                <div class="card-title">
                    <h3 class="card-label">@lang('text.ProblemType')</h3>
                </div>
                <div>
                    <a class="btn btn-danger" href="{{url()->previous()}}">@lang('text.Back')</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div id="message" style="display: none" class="alert-success font-weight-bold p-3 rounded"></div>
            <livewire:problem-types.add :problemType="$problemType ?? null"/>
        </div>
    </div>

@endsection

@section('styles')
    @livewireStyles
@endsection
@section('scripts')
    @livewireScripts
    <script>
        document.addEventListener('problem:created', function (e){
            let el = document.getElementById('message');
            el.innerHTML = e.detail.message;
            el.style.display = 'block';
        });
    </script>
@endsection
