{{-- Extends layout --}}
@extends('layout.default')

{{-- Content --}}
@section('content')

    <div class="card card-custom">
        <div class="card-header flex-wrap border-0 pt-6 pb-0">
            <div class="card-title">
                <h3 class="card-label">@lang('text.Technician')</h3>
            </div>
        </div>

        <div class="card-body">
            <form onsubmit="loading()" action="
            @if($user ?? '')
                {{route('admin.users.update', $user->id) }}
            @elseif(Route::currentRouteName() == 'admin.users.invite.show')
                {{route('admin.users.invite.send')}}
            @else
                {{route('admin.users.store')}}
            @endif
                " method="post">

                @isset($user)
                    @method('PUT')
                @endisset

                @csrf
                    <x-forms.input :label="__('text.Name')" name="name" :value="$user->name ?? ''"/>
                    <x-forms.input :label="__('text.Email')" name="email" :value="$user->email ?? ''"/>
                    @if(Route::currentRouteName() != 'admin.users.invite.show')
                        <x-forms.input :label="__('text.Phone')" name="phone" :value="$user->phone ?? ''"/>
                        <x-forms.input :label="__('text.Location')" name="location" :value="$user->location ?? ''"/>
                        @if(!($user ?? ''))
                            <x-forms.input :label="__('text.Password')" name="password" :value="$user->password ?? ''"/>
                        @endif
                    @endif
                    <div class="my-3">
                        <a href="{{url()->previous()}}" class="btn btn-danger">@lang('text.Back')</a>
                        <input type="submit" value="@lang('text.Save')" class="btn btn-success">
                    </div>
            </form>
        </div>

    </div>

@endsection
