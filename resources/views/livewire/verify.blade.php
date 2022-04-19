
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
    </style>
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('sms.verify_header') }}
        </h2>
    </div>


    {{ $this->form }}

    <div id="progressBarBlock">
        <div class="bar"></div>
    </div>


    <progress value="0" max="120" id="progressBar" {{$this->smsExpirySeconds < 0 || !$this->blockedMinutes
    ?:'hidden'}}></progress>
    <div>

    </div>

    <small class="text-center">
        @if($this->blockedMinutes)
            {!! __('sms.phone_blocked', ['time' => '<b id="countdown"></b>']) !!}
        @else
            {!! __('sms.not_expired', ['phone' => $this->phone, 'time' => '<b id="countdown"></b>']) !!}
        @endif
    </small>

    <div>
        <button wire:click="resendSms"
                {{ $this->sendAgain ? '' : 'hidden'}} id="sendAgain">{{__('sms.send_again')}}</button>
    </div>


    <x-filament::button class="w-full" wire:click="submit" :disabled="$this->blockedMinutes">
        {{ __('sms.confirm') }}
    </x-filament::button>
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
