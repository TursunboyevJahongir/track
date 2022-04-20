<x-filament::page :widget-record="$record" class="filament-resources-edit-record-page">
    <style>
        th,td{
            text-align: center;
            padding: 10px;
        }
    </style>
    <x-filament::form wire:submit.prevent="save">
        {{$this->form}}

        {{$this->titleForm}}


        <table class="w-full text-left rtl:text-right divide-y table-auto filament-tables-table">
            <thead>
            <tr class="bg-gray-50">
                <th>  </th>
                <th> {{__('roles.create')}} </th>
                <th> {{__('roles.read')}} </th>
                <th> {{__('roles.update')}} </th>
                <th> {{__('roles.delete')}} </th>
            </tr>
            </thead>
            <tbody class="divide-y whitespace-nowrap">
            @foreach($permissionWithRole as $model => $permissions)
                <tr>
                    <td wire:click="selectAll('{{$model}}')" style="cursor:pointer;">
                        {{$model}}
                    </td>
                    @foreach($permissions as $id => $permission)
                        <td colspan="{{5 - sizeof($permissions)}}">
                            <input type="checkbox" wire:model="toggle" value="{{$id}}" class="{{$model}}">
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>

        <x-filament::form.actions :actions="$this->getCachedFormActions()"/>
    </x-filament::form>
</x-filament::page>