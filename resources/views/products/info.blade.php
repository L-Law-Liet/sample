<x-guest-layout>

    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>
        <div class="mt-4">
            <x-jet-label value="{{ __('text.ID') }}" />
            <x-jet-input class="block mt-1 w-full" type="text" value="{{$product->id}}" readonly />
        </div>
        <div class="mt-4">
            <x-jet-label value="{{ __('text.TypeOfProblem') }}" />
            <x-jet-input class="block mt-1 w-full" type="text" value="{{$product->problem_type->name ?? ''}}" readonly />
        </div>
        <div class="mt-4">
            <x-jet-label value="{{ __('text.Status') }}" />
            <x-jet-input class="block mt-1 w-full" type="text" value="{{$product->product_status->name ?? ''}}" readonly />
        </div>
        @auth
            <div class="mt-4">
                <x-jet-label value="{{ __('text.Location') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" value="{{$product->location ?? ''}}" readonly />
            </div>
            <div class="mt-4">
                <x-jet-label value="{{ __('text.ReportedBy') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" value="{{$product->reported_by ?? ''}}" readonly />
            </div>
            <div class="mt-4">
                <x-jet-label value="{{ __('text.Serial') }}" />
                <x-jet-input class="block mt-1 w-full" type="text" value="{{$product->serial ?? ''}}" readonly />
            </div>
            <div class="mt-4">
                <x-jet-label value="{{ __('text.PartsUsedForRepair') }}" />
                <textarea class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200
                 focus:ring-opacity-50 rounded-md shadow-sm block mt-1 w-full" rows="7">{{$product->parts ?? ''}}</textarea>
            </div>
        @endauth
    </x-jet-authentication-card>
</x-guest-layout>
