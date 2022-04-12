<div class="flex items-center justify-center min-h-screen filament-login-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="register" class="bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8">
            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('Verify Number') }}
            </h2>

            {{ $this->form }}

            <x-filament::button type="submit" form="register" class="w-full">
                {{ __('Send') }}
            </x-filament::button>
        </form>
    </div>
</div>
