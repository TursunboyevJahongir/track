<x-filament-breezy::auth-card action="authenticate">

    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('filament::login.heading') }}
        </h2>
        @if(config("filament-breezy.enable_registration"))
        <p class="mt-2 text-sm text-center">
            {{ __('auth.or') }}
            <a class="text-primary-600" href="{{route('register')}}">
                {{ strtolower(__('auth.registration.heading')) }}
            </a>
        </p>
        @endif
    </div>

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700" href="{{route('password.request')}}">
            {{ __('auth.forgot_password_link') }}</a>
    </div>

    <a href="{{route('auth.google')}}" class="inline-flex items-center justify-center h-9 w-full loginBtn loginBtn--google">
        {{__('auth.login_with_google')}}
        </span></a>
    <a href="{{route('facebook.login')}}" class="inline-flex items-center justify-center h-9 w-full loginBtn loginBtn--facebook">
        {{__('auth.login_with_facebook')}}
        </span>
    </a>

</x-filament-breezy::auth-card>
