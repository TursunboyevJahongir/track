<x-filament-breezy::auth-card action="register">
    <div class="w-full flex justify-center">
        <x-filament::brand />
    </div>

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('auth.registration.heading') }}
        </h2>
        <p class="mt-2 text-sm text-center">
            {{ __('auth.or') }}
            <a class="text-primary-600" href="{{route("filament.auth.login")}}">
                {{ strtolower(__('filament::login.heading')) }}
            </a>
        </p>
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full" wire:click="register">
        {{ __('auth.sign_up') }}
    </x-filament::button>

    <a href="{{route('auth.google')}}" class="inline-flex items-center justify-center h-9 w-full loginBtn loginBtn--google">
        {{__('auth.login_with_google')}}
      </span></a>
    <a href="{{route('facebook.login')}}" class="inline-flex items-center justify-center h-9 w-full loginBtn loginBtn--facebook">
        {{__('auth.login_with_facebook')}}
      </span></a>

    @livewire('select-lang')
</x-filament-breezy::auth-card>
