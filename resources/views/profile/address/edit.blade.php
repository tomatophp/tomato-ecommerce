<x-splade-modal>
    <x-splade-form class="flex flex-col space-y-4" action="{{route('profile.address.update', $address->id)}}" method="post" :default="$address">
        <div class="grid grid-cols-3 gap-4">
            <x-splade-input label="{{__('Home number')}}" type='number' name="home_number" placeholder="Home number" />
            <x-splade-input label="{{__('Flat number')}}" type='number' name="flat_number" placeholder="Flat number" />
            <x-splade-input label="{{__('Floor number')}}" type='number' name="floor_number" placeholder="Floor number" />
        </div>
        <x-splade-input label="{{__('Street')}}" name="street" type="text"  placeholder="Street" />
        <x-tomato-location />
        <x-splade-input label="{{__('Mark')}}" name="mark" type="text"  placeholder="Mark" />
        <x-splade-textarea label="{{__('Map url')}}" name="map_url" placeholder="Map url" autosize />
        <x-splade-input label="{{__('Note')}}" name="note" type="text"  placeholder="Note" />


        <div class="flex justify-start gap-2 pt-3">
            <x-tomato-admin-submit :label="__('Save')" :spinner="true" />
            <x-tomato-admin-button
                danger
                :href="route('profile.address.destroy', $address->id)"
                title="{{trans('tomato-admin::global.crud.edit')}}"
                confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                class="px-2 text-red-500"
                method="delete"
            >
                {{__('Delete')}}
            </x-tomato-admin-button>
            <x-tomato-admin-button secondary :href="route('profile.address.index')" label="{{__('Cancel')}}"/>
        </div>
    </x-splade-form>
</x-splade-modal>
