<x-filament::page>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .avatar-wrapper {
            position: relative;
            height: 200px;
            width: 200px;
            margin: 50px auto;
            border-radius: 50%;
            overflow: hidden;
            box-shadow: 1px 1px 15px -5px black;
            transition: all 0.3s ease;
        }
        .avatar-wrapper:hover {
            transform: scale(1.05);
            cursor: pointer;
        }
        .avatar-wrapper:hover .profile-pic {
            opacity: 0.5;
        }
        .avatar-wrapper .profile-pic {
            height: 100%;
            width: 100%;
            transition: all 0.3s ease;
        }
        .avatar-wrapper .profile-pic:after {
            content: "";
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            font-size: 190px;
            background: #ecf0f1;
            color: #34495e;
            text-align: center;
        }
        .avatar-wrapper .upload-button {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
        }
        .avatar-wrapper .upload-button .fa-arrow-circle-up {
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
            opacity: 0;
            font-size: 50px;
            transition: all 0.3s ease;
            color: #34495e;
        }
        .avatar-wrapper .upload-button:hover .fa-arrow-circle-up {
            opacity: 0.9;
        }
    </style>

    <x-grid-section class="mt-8">
        <x-slot name="title">
            {{ __('Personal info') }}
        </x-slot>

        <x-slot name="description">
            {{ __('information') }}
        </x-slot>

        <form wire:submit.prevent="updateProfile" class="col-span-2 sm:col-span-1 mt-5 md:mt-0" >
            <x-filament::card>

                <div class="avatar-wrapper">
                    <img class="profile-pic" src="{{ $this->user->avatar->path_1024}}" />
                    <div class="upload-button">
                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                    </div>
                    <input class="file-upload" type="file" accept="image/*" wire:model="avatar"/>
                </div>

                {{ $this->updateProfileForm }}

                <x-slot name="footer">
                    <div class="text-right">
                        <x-filament::button type="submit">
                            {{ __('submit') }}
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::card>
        </form>

    </x-grid-section>


    <x-grid-section>

        <x-slot name="title">
            {{ __('filament-breezy::default.profile.password.heading') }}
        </x-slot>

        <x-slot name="description">
            {{ __('filament-breezy::default.profile.password.subheading') }}
        </x-slot>

        <form wire:submit.prevent="updatePassword" class="col-span-2 sm:col-span-1 mt-5 md:mt-0">
            <x-filament::card>

                {{ $this->updatePasswordForm }}

                <x-slot name="footer">
                    <div class="text-right">
                        <x-filament::button type="submit">
                            {{ __('Submit') }}
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::card>
        </form>

    </x-grid-section>

    @if(config('filament-breezy.enable_sanctum'))
        <hr />

        <x-grid-section class="mt-8">

            <x-slot name="title">
                {{ __('filament-breezy::default.profile.sanctum.title') }}
            </x-slot>

            <x-slot name="description">
                {{ __('filament-breezy::default.profile.sanctum.description') }}
            </x-slot>

            <div class="space-y-3">

                <form wire:submit.prevent="createApiToken" class="col-span-2 sm:col-span-1 mt-5 md:mt-0">

                    <x-filament::card>
                        @if($plain_text_token)
                            <input type="text" disabled @class(['w-full py-1 px-3 rounded-lg bg-gray-100 border-gray-200',' dark:bg-gray-900 dark:border-gray-700'=>config('filament.dark_mode')]) name="plain_text_token" value="{{$plain_text_token}}" />
                        @endif

                        {{$this->createApiTokenForm}}

                        <div class="text-right">
                            <x-filament::button type="submit">
                                {{ __('filament-breezy::default.profile.sanctum.create.submit.label') }}
                            </x-filament::button>
                        </div>
                    </x-filament::card>
                </form>


            </div>
        </x-grid-section>
    @endif

    <script>
        document.addEventListener('livewire:load', function () {
            var readURL = function(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        document.getElementsByClassName('profile-pic')[0].setAttribute('src', e.target.result);
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
            document.getElementsByClassName('file-upload')[0].onchange = function (){
                readURL(this);
            }
            document.getElementsByClassName('upload-button')[0].onclick = function (){
                document.getElementsByClassName('file-upload')[0].click();
            }
        })
    </script>

</x-filament::page>
