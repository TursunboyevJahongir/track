<x-filament-breezy::auth-card action="">
    <style>
        progress{
            border: none;
            width: 100%;
            height: 6px;
            background: crimson;
        }
    </style>
    <div>
        <h2 class="font-bold tracking-tight text-center text-2xl">
            {{ __('sms.verify_header') }}
        </h2>
    </div>


    {{ $this->form }}

    <progress value="0" max="120" id="progressBar" {{$this->smsExpirySeconds < 0 ? 'hidden' : ''}}></progress>

    <small class="text-center">
        {!! __('sms.not_expired', ['phone' => $this->phone, 'time' => '<b id="countdown"></b>']) !!}
    </small>

    <div>
        <button wire:click="resendSms" {{ $this->sendAgain ? '' : 'hidden'}} id="sendAgain">{{__('sms.send_again')}}</button>
    </div>


    <x-filament::button class="w-full" wire:click="submit">
        {{ __('sms.confirm') }}
    </x-filament::button>

    <script>
        document.addEventListener('livewire:load', function () {
            var timeleft = '{{$this->resendTime}}'
            var downloadTimer = setInterval(function(){
                if(timeleft <= 0){
                    clearInterval(downloadTimer);
                    document.getElementById('sendAgain').removeAttribute("hidden");
                    document.getElementById("countdown").innerHTML = "0";
                } else {
                    document.getElementById("countdown").innerHTML = timeleft;
                }
                timeleft -= 1;
            }, 1000);

            var smsExpirySeconds = {{$this->smsExpirySeconds}};
            var timer = setInterval(function(){
                if(smsExpirySeconds <= 0){
                    clearInterval(downloadTimer);
                }
                document.getElementById("progressBar").value = 120 - smsExpirySeconds;
                smsExpirySeconds -= 1;
            }, 1000);
        })
    </script>




</x-filament-breezy::auth-card>
