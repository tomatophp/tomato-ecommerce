@extends('tomato-ecommerce::layouts.profile')

@section('body')
    <div class="px-8 py-4">
        <div class="flex justify-between items-center my-4">
            <h1 class="text-2xl font-bold">{{__('Address')}}</h1>
            <x-tomato-admin-button modal :href="route('profile.address.create')">
                {{__('Add New Address')}}
            </x-tomato-admin-button>
        </div>
        @if(auth('accounts')->user()->address)
            <div class="border rounded-lg border-primary-500 p-4 my-4">
            <h1 class="font-bold text-lg">{{__('Your Selected Address Is')}}</h1>
            <div class="flex justify-between gap-4 my-4">
                <div>
                    {{__('Address')}}
                </div>
                <div>
                    {{ auth('accounts')->user()->address }}
                </div>
            </div>
            <div class="flex justify-between gap-4 my-4">
                <div>
                    {{__('Country')}}
                </div>
                <div>
                    {{ \TomatoPHP\TomatoLocations\Models\Country::find(auth('accounts')->user()->meta('country_id'))?->name }}
                </div>
            </div>
            <div class="flex justify-between gap-4 my-4">
                <div>
                    {{__('City')}}
                </div>
                <div>
                    {{ \TomatoPHP\TomatoLocations\Models\City::find(auth('accounts')->user()->meta('city_id'))?->name }}
                </div>
            </div>
            <div class="flex justify-between gap-4 my-4">
                <div>
                    {{__('Area')}}
                </div>
                <div>
                    {{ \TomatoPHP\TomatoLocations\Models\Area::find(auth('accounts')->user()->meta('area_id'))?->name }}
                </div>
            </div>
        </div>
        @endif
        <x-splade-table :for="$table">
            <x-splade-cell actions>
                <div class="flex justify-start gap-2">
                    <x-tomato-admin-tooltip text="{{__('Make Default')}}">
                        <x-tomato-admin-button type="icon" confirm method="POST" :href="route('profile.address.select', $item->id)">
                            <x-heroicon-s-check-circle class="h-6 w-6"/>
                        </x-tomato-admin-button>
                    </x-tomato-admin-tooltip>
                    <x-tomato-admin-tooltip text="{{trans('tomato-admin::global.crud.view')}}">
                        <x-tomato-admin-button success modal type="icon" :href="route('profile.address.show', $item->id)">
                            <x-heroicon-s-eye class="h-6 w-6"/>
                        </x-tomato-admin-button>
                    </x-tomato-admin-tooltip>
                    <x-tomato-admin-tooltip text="{{trans('tomato-admin::global.crud.edit')}}">
                        <x-tomato-admin-button warning modal type="icon" :href="route('profile.address.edit', $item->id)">
                            <x-heroicon-s-pencil class="h-6 w-6"/>
                        </x-tomato-admin-button>
                    </x-tomato-admin-tooltip>
                    <x-tomato-admin-tooltip text="{{trans('tomato-admin::global.crud.delete')}}">
                        <x-tomato-admin-button type="icon"
                                               :href="route('profile.address.destroy', $item->id)"
                                               confirm="{{trans('tomato-admin::global.crud.delete-confirm')}}"
                                               confirm-text="{{trans('tomato-admin::global.crud.delete-confirm-text')}}"
                                               confirm-button="{{trans('tomato-admin::global.crud.delete-confirm-button')}}"
                                               cancel-button="{{trans('tomato-admin::global.crud.delete-confirm-cancel-button')}}"
                                               class="px-2 text-red-500"
                                               method="delete"
                        >
                            <x-heroicon-s-trash class="h-6 w-6"/>
                        </x-tomato-admin-button>
                    </x-tomato-admin-tooltip>

                </div>
            </x-splade-cell>
        </x-splade-table>
    </div>
@endsection
