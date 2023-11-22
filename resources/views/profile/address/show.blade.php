<x-splade-modal>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        <x-tomato-admin-row :label="__('Account')" :value="$address->account->name"/>
        <x-tomato-admin-row :label="__('Street')" :value="$address->street"/>
        <x-tomato-admin-row :label="__('Area')" :value="$address->area?->name"/>
        <x-tomato-admin-row :label="__('City')" :value="$address->city?->name"/>
        <x-tomato-admin-row :label="__('Country')" :value="$address->country?->name"/>
        <x-tomato-admin-row :label="__('Home number')" :value="$address->home_number"/>
        <x-tomato-admin-row :label="__('Flat number')" :value="$address->flat_number"/>
        <x-tomato-admin-row :label="__('Floor number')" :value="$address->floor_number"/>
        <x-tomato-admin-row :label="__('Mark')" :value="$address->mark"/>
        <x-tomato-admin-row :label="__('Map url')" :value="$address->map_url"/>
        <x-tomato-admin-row :label="__('Note')" :value="$address->note"/>
        <x-tomato-admin-row :label="__('Note')" :value="$address->note"/>
    </div>

    <div class="flex justify-start gap-2 pt-3">
        <x-tomato-admin-button warning :href="route('profile.address.edit', $address->id)" label="{{__('Edit')}}" />
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
</x-splade-modal>
