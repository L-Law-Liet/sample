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
        <livewire:products.add :product="$product ?? null"/>
    </div>
@endsection

@section('styles')
    <style>
        #dropzone {
            border-radius: 5px;
            border: 2px dashed rgb(0, 135, 247);
            display: flex;
            justify-content: center;
            /*min-height: 2rem;*/
            /*width: 100%;*/
        }
        .dz-preview {
            text-align: center;
            margin: 1rem;
        }
        .dz-details, .dz-error-message, .dz-success-mark, .dz-error-mark, .dz-progress {
            display: none;
        }
    </style>
@endsection
@section('scripts')

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
            crossorigin="anonymous"></script>
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    <script src="{{asset('js/dz.js')}}"></script>
    <script>
        document.addEventListener('loaded', function () {
            loadDropzone();
        });
        @if($product ?? '')
            document.addEventListener('DOMContentLoaded', function () {
            loadDropzone();
            });
        @endif
    </script>
    @livewireScripts
@endsection
