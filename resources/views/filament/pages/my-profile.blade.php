<x-filament::page>
    <style>
        .personal-image {
            text-align: center;
        }
        .personal-image input[type="file"] {
            display: none;
        }
        .personal-figure {
            display: block;margin-left: auto;margin-right: auto;
            /*position: relative;*/
            width: 120px;
            height: 120px;
        }
        .personal-avatar {
            cursor: pointer;
            width: 100%;
            height: 100%;
            box-sizing: border-box;
            border-radius: 100%;
            border: 2px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.2);
            transition: all ease-in-out .3s;
        }
        .personal-avatar:hover {
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.5);
        }
        .personal-figcaption {
            cursor: pointer;
            position: absolute;
            top: 23%;
            width: inherit;
            height: inherit;
            border-radius: 100%;
            opacity: 0;
            background-color: rgba(0, 0, 0, 0);
            transition: all ease-in-out .3s;
        }
        .personal-figcaption:hover {
            opacity: 1;
            background-color: rgba(0, 0, 0, .5);
        }
        .personal-figcaption > img {
            margin-top: 32.5px;
            width: 50px;
            height: 50px;
        }

        .backgroundImage {
            transition: 3s;
        }
        .backgroundImage:hover{
            background-image: url('{{ $this->user->avatar->url1024 }}');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            transition: 3s;
        }
    </style>

    <x-filament-breezy::grid-section class="mt-8">
        <x-slot name="title">
            {{ __('filament-breezy::default.profile.personal_info.heading') }}
        </x-slot>

        <x-slot name="description">
            {{ __('filament-breezy::default.profile.personal_info.subheading') }}
        </x-slot>

        <form wire:submit.prevent="updateProfile" class="col-span-2 sm:col-span-1 mt-5 md:mt-0" >
            <x-filament::card>
                <div class="personal-image">
                    <label class="label">
                        <input type="file" accept="image/*" name="avatar" onchange="loadFile(event)"/>
                        <figure class="personal-figure">
                            <img src="{{$this->user->avatar->url1024}}" id="uploadPreview" class="personal-avatar" alt="avatar">
                            <figcaption class="personal-figcaption">
                                <img src="https://raw.githubusercontent.com/ThiagoLuizNunes/angular-boilerplate/master/src/assets/imgs/camera-white.png" style="display: block;margin-left: auto;margin-right: auto">
                            </figcaption>
                        </figure>
                    </label>
                </div>

                {{ $this->updateProfileForm }}

                <x-slot name="footer">
                    <div class="text-right">
                        <x-filament::button type="submit">
                            {{ __('filament-breezy::default.profile.personal_info.submit.label') }}
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::card>
        </form>

    </x-filament-breezy::grid-section>

    <hr />

    <x-filament-breezy::grid-section>

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
                            {{ __('filament-breezy::default.profile.password.submit.label') }}
                        </x-filament::button>
                    </div>
                </x-slot>
            </x-filament::card>
        </form>

    </x-filament-breezy::grid-section>

    @if(config('filament-breezy.enable_sanctum'))
        <hr />

        <x-filament-breezy::grid-section class="mt-8">

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

                <hr />

                @livewire(\JeffGreco13\FilamentBreezy\Http\Livewire\BreezySanctumTokens::class)

            </div>
        </x-filament-breezy::grid-section>
    @endif

    <script type="text/javascript">
        var loadFile = function(event) {
            var output = document.getElementById('uploadPreview');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
            document.getElementById(".").style.color = "blue";
        };
    </script>

</x-filament::page>
