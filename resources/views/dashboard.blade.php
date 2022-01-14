{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')
    <div>
        <div class="row">
            <div class="col-md-3 p-2">
                <a class="btn btn-info" href="{{route('products.create')}}">@lang('text.Add Product for repair')</a>
            </div>
        </div>
        <div class="row">
            @foreach($statuses as $status)
                <div class="p-2 col-md-3">
                    <a href="{{route('products.index', ['productStatusId' => $status->id])}}">
                        <div class="card card-body">
                            <h3>{{$status->products_count}}</h3>
                            <p>{{$status->name}}</p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card card-body py-3">
                    <div class="table-responsive">
                        <canvas class="table" height="400px" id="lineChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-12 py-3">
                <div class="h-100 card card-body">
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
            <div class="col-12 col-lg-6 py-3">
                <div class="h-100 card card-body table-responsive">
                    <canvas class="table" height="400px" id="line2Chart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.3.2/chart.min.js" integrity="sha512-VCHVc5miKoln972iJPvkQrUYYq7XpxXzvqNfiul1H4aZDwGBGC0lq373KNleaB2LpnC2a/iNfE5zoRYmB4TRDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{asset('js/chart.js')}}"></script>
    <script>
        showYearlyChart(<?=$yearlyChart?>);
        showPieChart(<?=$pieChart?>);
        showMonthlyChart(<?=$monthlyChart?>);
    </script>
@endsection
