<x-filament::page :widget-record="$record" class="filament-resources-edit-record-page">
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
    <x-filament::form wire:submit.prevent="save">
        <div class="avatar-wrapper">
            @if ($avatar)
                <img class="profile-pic"  src="{{ $avatar->temporaryUrl() }}">
            @else
                <img class="profile-pic"  src="/{{$this->record->avatar->path_512}}">
            @endif

            <div class="upload-button">
                <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
            </div>
            <input class="file-upload" type="file" accept="image/*" wire:model="avatar"/>
        </div>
        {{ $this->form }}

        <x-filament::form.actions :actions="$this->getCachedFormActions()" />
    </x-filament::form>

    @if (count($relationManagers = $this->getRelationManagers()))
        <x-filament::hr />

        <x-filament::resources.relation-managers :active-manager="$activeRelationManager" :managers="$relationManagers" :owner-record="$record" />
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
