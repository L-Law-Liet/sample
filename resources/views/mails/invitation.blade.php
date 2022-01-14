<p>
    @lang('text.Hello'), {{$name}}!
</p>
<p>
    <a href="{{route('invite', $encryptedEmail)}}">@lang('text.LinkForRegistrationOnTheSite') {{config('app.url')}}</a>
</p>
<p>@lang('text.Regards'), {{config('app.name')}}.</p>
