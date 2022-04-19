<div class="flex items-center justify-center min-h-screen filament-login-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form wire:submit.prevent="register" @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                {{ __('auth.registration_heading') }}
            </h2>
            <p class="mt-2 text-sm text-center">
                {{ __('auth.or') }}
                <a class="text-primary-600" href="{{ route('login') }}">
                    {{ strtolower(__('filament::login.heading')) }}
                </a>
            </p>

            {{ $this->form }}


            <x-filament::button type="submit" form="register" class="w-full">
                {{ __('auth.sign_up') }}
            </x-filament::button>

            <div class="w-full flex justify-center">@lang('auth.or')</div>

            <a href="{{ route('auth.google') }}"
                class="inline-flex items-center justify-center h-9 w-full loginBtn loginBtn--google">
                {{ __('auth.login_with_google') }}
                </span></a>
            <a href="{{ route('facebook.login') }}"
                class="inline-flex items-center justify-center h-9 w-full loginBtn loginBtn--facebook">
                {{ __('auth.login_with_facebook') }}
                </span>
            </a>

            @livewire('select-lang')
        </form>

        <x-filament::footer />
    </div>
</div>

@push('styles')
    <style>
        /* Shared */
        .loginBtn {
            box-sizing: border-box;
            position: relative;
            padding: 0 15px 0 46px;
            border: none;
            text-align: left;
            white-space: nowrap;
            border-radius: 0.2em;
            font-size: 16px;
            color: #FFF;
        }

        .loginBtn:before {
            content: "";
            box-sizing: border-box;
            position: absolute;
            top: 0;
            left: 0;
            width: 34px;
            height: 100%;
        }

        .loginBtn:focus {
            outline: none;
        }

        .loginBtn:active {
            box-shadow: inset 0 0 0 32px rgba(0, 0, 0, 0.1);
        }


        /* Facebook */
        .loginBtn--facebook {
            background-color: #4C69BA;
            background-image: linear-gradient(#4C69BA, #3B55A0);
            /*font-family: "Helvetica neue", Helvetica Neue, Helvetica, Arial, sans-serif;*/
            text-shadow: 0 -1px 0 #354C8C;
        }

        .loginBtn--facebook:before {
            border-right: #364e92 1px solid;
            background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_facebook.png') 6px 6px no-repeat;
        }

        .loginBtn--facebook:hover,
        .loginBtn--facebook:focus {
            background-color: #5B7BD5;
            background-image: linear-gradient(#5B7BD5, #4864B1);
        }


        /* Google */
        .loginBtn--google {
            /*font-family: "Roboto", Roboto, arial, sans-serif;*/
            background: #DD4B39;
        }

        .loginBtn--google:before {
            border-right: #BB3F30 1px solid;
            background: url('https://s3-us-west-2.amazonaws.com/s.cdpn.io/14082/icon_google.png') 6px 6px no-repeat;
        }

        .loginBtn--google:hover,
        .loginBtn--google:focus {
            background: #E74B37;
        }

    </style>
@endpush
