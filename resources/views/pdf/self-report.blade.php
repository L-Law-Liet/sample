<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PDF</title>
</head>
<body>

<div>
    <strong>
        @lang('text.Range'): {{$ranges[$range]}}
    </strong>
</div>
<div>
    <strong>
        @lang('text.Audited'): {{$auditedList[$audited]}}
    </strong>
</div>
<div>
    <strong>
        @lang('text.DateStart'): {{($dateStart) ? date('d.m.Y', strtotime($dateStart)) :  __('text.NotSet')}}
    </strong>
</div>
<div>
    <strong>
        @lang('text.DateEnd'): {{($dateEnd) ? date('d.m.Y', strtotime($dateEnd)) :  __('text.NotSet')}}
    </strong>
</div>
<table border="1" style="width: 100%">
    <thead>
    <tr>
        <th>@lang('text.Category')</th>
        <th>@lang('text.ProblemType')</th>
        <th>@lang('text.Payout')</th>
        <th>@lang('text.Status')</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{$product->category->name}}</td>
            <td>{{$product->problem_type->name}}</td>
            <td>{{$product->problem_type->payout}}</td>
            <td>@include('layout.partials.show-status')</td>
        </tr>
    @endforeach
    <tr>
        <strong>
            @lang('text.TotalPayout'): ${{$total}}
        </strong>
    </tr>
    </tbody>
</table>
</body>
</html>
