<div class="flex items-center justify-center min-h-screen filament-login-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="verify" @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('Verification phone number') }}
            </h2>
            <p class="mt-2 text-sm text-center">
                {{ __('verification_send_to', ['phone' => $phone]) }}
            </p>

            {{ $this->form }}


            <div class="flex items-center justify-center">
                <x-filament::button wire:click="resend" class="mr-2 bg-warning-600 hover:bg-warning-400">
                    {{ __('Resend') }}
                </x-filament::button>
                <x-filament::button type="submit" form="verify">
                    {{ __('Verify') }}
                </x-filament::button>
            </div>
        </form>

        <x-filament::footer />
    </div>
</div>
