<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
{{--    <link href="{{ asset('css/pdf.css') }}" rel="stylesheet" type="text/css" />--}}
</head>
<body>
<div>
    <table border="1" style="width: 100%">
        <tr>
            <th>@lang('text.Location')</th>
            <td>{{$product->location ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.ReportedBy')</th>
            <td>{{$product->reported_by ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Serial')</th>
            <td>{{$product->serial ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Description')</th>
            <td>{{$product->description ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.PartsUsedForRepair')</th>
            <td>{{$product->parts ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Client')</th>
            <td>{{$product->client->name ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Category')</th>
            <td>{{$product->category->name ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Status')</th>
            <td>{{$product->product_status->name ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Technician')</th>
            <td>{{$product->user->name ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.ProblemType')</th>
            <td>{{$product->problem_type->name ?? __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Claimed')</th>
            <td>{{($product->claimed_at) ? date('d.m.Y', strtotime($product->claimed_at)) : __('text.NotSet')}}</td>
        </tr>
        <tr>
            <th>@lang('text.Finished')</th>
            <td>{{ ($product->finished_at) ? date('d.m.Y', strtotime($product->finished_at)) : __('text.NotSet')}}</td>
        </tr>
    </table>
</div>

<div style="text-align: center; padding-top: 5rem !important;">
    <img src="data:image/png;base64, {{ base64_encode(QrCode::format('svg')->size(200)->generate(route('qr', ['key' => encrypt($product->id)]))) }} ">
</div>

@foreach((array) json_decode($product->images) ?? [] as $image)
    <div style="margin-top: 2rem;">
        <img src="{{asset('/storage'.$image)}}" width="100%">
    </div>
@endforeach
</body>
</html>
