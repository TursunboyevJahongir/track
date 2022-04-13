<x-filament-breezy::auth-card action="authenticate">
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('sms.verify_header') }}
        </h2>
    </div>

    {{ $this->form }}



    <x-filament::button type="submit" class="w-full">
        {{ __('sms.confirm') }}
    </x-filament::button>

    <div class="text-center">
        {{__('sms.not_expired', ['phone' => '+998975130333', 'time' => '2s'])}}
    </div>

</x-filament-breezy::auth-card>
