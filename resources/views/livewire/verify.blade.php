<div class="flex items-center justify-center min-h-screen filament-login-page">
    <div class="p-2 max-w-md space-y-8 w-screen">
        <form  @class([
            'bg-white space-y-8 shadow border border-gray-300 rounded-2xl p-8',
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ])>
            <div class="w-full flex justify-center">
                <x-filament::brand />
            </div>

            <h2 class="font-bold tracking-tight text-center text-2xl">
                    {{ __('sms.verify_header') }}
            </h2>

            {{ $this->form }}

            <div id="progressBarBlock">
                <div class="bar"></div>
            </div>


            <progress value="0" max="120" id="progressBar" {{$this->smsExpirySeconds < 0 || !$this->blockedMinutes ?:'hidden'}}></progress>

            <small class="text-center">
                @if($this->blockedMinutes)
                    {!! __('sms.phone_blocked', ['time' => '<b id="countdown"></b>']) !!}
                @else
                    {!! __('sms.not_expired', ['phone' => $this->phone, 'time' => '<b id="countdown"></b>']) !!}
                @endif
            </small>

            <button wire:click="resendSms" {{ $this->sendAgain ? '' : 'hidden'}} id="sendAgain">{{__('sms.send_again')}}</button>

            <x-filament::button class="w-full" wire:click="submit" :disabled="$this->blockedMinutes">
                {{ __('sms.confirm') }}
            </x-filament::button>

            @livewire('select-lang')
        </form>

        <x-filament::footer />
    </div>
</div>

    <script>
        document.addEventListener('livewire:load', function () {
            var timeleft = '{{$this->resendTime}}'
            var downloadTimer = setInterval(function () {
                if (timeleft <= 0) {
                    clearInterval(downloadTimer);
                    document.getElementById('sendAgain').removeAttribute("hidden");
                    document.getElementById("countdown").innerHTML = "0";

                } else {
                    document.getElementById("countdown").innerHTML = Math.floor(timeleft / 60) + ":" + timeleft % 60;;
                }
                timeleft -= 1;
            }, 1001);


            function progress(timeleftblock, timetotal) {
                var progressBarWidth = timeleftblock * document.querySelector("#progressBarBlock").offsetWidth / timetotal;
                document.querySelector("#progressBarBlock > div").style.width = progressBarWidth + 'px';
                document.querySelector("#progressBarBlock > div").innerHTML = Math.floor(timeleftblock / 60) + ":" + timeleftblock % 60;
                if (timeleftblock > 0) {
                    setTimeout(function () {
                        progress(timeleftblock - 1, timetotal);
                    }, 1000);
                }else{
                    document.querySelector("#progressBarBlock").style.display = 'none';
                }
            };
            progress({{$this->blockedMinutes??0}}, {{config('sms.sms-phone-blocked-minutes')*60}});

            var smsExpirySeconds = '{{$this->smsExpirySeconds}}';
            var smsExp = setInterval(function () {
                if (smsExpirySeconds <= 0) {
                    clearInterval(smsExp);
                }
                document.getElementById("progressBar").value = 120 - smsExpirySeconds;
                smsExpirySeconds -= 1;
            }, 1000);
        })

    </script>

    @push('styles')
        <style>
            progress {
                border: none;
                width: 100%;
                height: 6px;
            }

            #progressBarBlock {
                width: 100%;
                margin: 10px auto;
                height: 15px;
                background-color: #008000;
                display: {{!$this->blockedMinutes ? 'none' : 'block'}};
            }

            #progressBarBlock div {
                height: 100%;
                text-align: right;
                padding: 0 10px;
                width: 0;
                background-color: tomato;
                box-sizing: border-box;
                color: white;
                font-size: 10px;
            }
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
