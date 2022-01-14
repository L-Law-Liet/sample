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
        @foreach($ths as $th)
            <th>{{$th}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{$user['name']}}</td>
            @for($i = 1; $i < count($ths) - 1; $i++)
                <td>{{$user['products'][$ths[$i]]['count'] ?? 0}}</td>
            @endfor
            <td>{{$user['products'][\App\Models\ProductStatus::REPAIRED_NAME()]['sum'] ?? 0}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
