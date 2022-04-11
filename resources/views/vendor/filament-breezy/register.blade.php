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

    <x-filament::button type="submit" class="w-full">
        {{ __('filament-breezy::default.registration.submit.label') }}
    </x-filament::button>

    <a href="{{route('auth.google')}}" class="inline-flex items-center justify-center font-medium tracking-tight rounded-lg border transition-colors focus:outline-none focus:ring-inset filament-button h-9 px-4 text-white shadow bg-light-600 hover:bg-light-500 w-full">
        <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTgiIGhlaWdodD0iMTgiIHZpZXdCb3g9IjAgMCAxOCAxOCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxwYXRoIGQ9Ik0xNy42NCA5LjIwNWMwLS42MzktLjA1Ny0xLjI1Mi0uMTY0LTEuODQxSDl2My40ODFoNC44NDRhNC4xNCA0LjE0IDAgMCAxLTEuNzk2IDIuNzE2djIuMjU5aDIuOTA4YzEuNzAyLTEuNTY3IDIuNjg0LTMuODc1IDIuNjg0LTYuNjE1eiIgZmlsbD0iIzQyODVGNCIgZmlsbC1ydWxlPSJub256ZXJvIj48L3BhdGg+PHBhdGggZD0iTTkgMThjMi40MyAwIDQuNDY3LS44MDYgNS45NTYtMi4xOGwtMi45MDgtMi4yNTljLS44MDYuNTQtMS44MzcuODYtMy4wNDguODYtMi4zNDQgMC00LjMyOC0xLjU4NC01LjAzNi0zLjcxMUguOTU3djIuMzMyQTguOTk3IDguOTk3IDAgMCAwIDkgMTh6IiBmaWxsPSIjMzRBODUzIiBmaWxsLXJ1bGU9Im5vbnplcm8iPjwvcGF0aD48cGF0aCBkPSJNMy45NjQgMTAuNzFBNS40MSA1LjQxIDAgMCAxIDMuNjgyIDljMC0uNTkzLjEwMi0xLjE3LjI4Mi0xLjcxVjQuOTU4SC45NTdBOC45OTYgOC45OTYgMCAwIDAgMCA5YzAgMS40NTIuMzQ4IDIuODI3Ljk1NyA0LjA0MmwzLjAwNy0yLjMzMnoiIGZpbGw9IiNGQkJDMDUiIGZpbGwtcnVsZT0ibm9uemVybyI+PC9wYXRoPjxwYXRoIGQ9Ik05IDMuNThjMS4zMjEgMCAyLjUwOC40NTQgMy40NCAxLjM0NWwyLjU4Mi0yLjU4QzEzLjQ2My44OTEgMTEuNDI2IDAgOSAwQTguOTk3IDguOTk3IDAgMCAwIC45NTcgNC45NThMMy45NjQgNy4yOUM0LjY3MiA1LjE2MyA2LjY1NiAzLjU4IDkgMy41OHoiIGZpbGw9IiNFQTQzMzUiIGZpbGwtcnVsZT0ibm9uemVybyI+PC9wYXRoPjxwYXRoIGQ9Ik0wIDBoMTh2MThIMHoiPjwvcGF0aD48L2c+PC9zdmc+" height="20" width="20"> <span class="ml-2">
        {{__('auth.login_with_google')}}
      </span></a>
    <a href="{{route('facebook.login')}}" class="inline-flex items-center justify-center font-medium tracking-tight rounded-lg border transition-colors focus:outline-none focus:ring-inset filament-button h-9 px-4 text-white shadow bg-light-600 hover:bg-light-500 w-full" style="background-color: #356bc4">
        <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="ui-svg-inline"><path d="M15.12,5.32H17V2.14A26.11,26.11,0,0,0,14.26,2C11.54,2,9.68,3.66,9.68,6.7V9.32H6.61v3.56H9.68V22h3.68V12.88h3.06l.46-3.56H13.36V7.05C13.36,6,13.64,5.32,15.12,5.32Z"></path></svg> <span class="ml-2">
        {{__('auth.login_with_facebook')}}
      </span></a>
</x-filament-breezy::auth-card>
