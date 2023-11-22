@extends('tomato-ecommerce::layouts.profile')

@section('body')
    <div class="px-8 py-4">
        <div class="flex justify-between items-center my-4">
            <h1 class="text-2xl font-bold">{{__('Wallet')}}</h1>
            <x-tomato-admin-button modal :href="route('profile.wallet.create')">
                {{__('Change Balance')}}
            </x-tomato-admin-button>
        </div>
        <div class="flex items-center p-4 bg-white border rounded-lg shadow-xs dark:bg-gray-800 my-4">
            <div class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500">
                <x-heroicon-s-currency-dollar class="w-4 h-4" />
            </div>
            <div>
                <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                    {{__('Account Balance')}}
                </p>
                <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                    {!! dollar(auth('accounts')->user()->balance) !!}
                </p>
            </div>
        </div>

        <x-splade-table :for="$table" striped>
            <x-splade-cell amount>
                <x-tomato-admin-row table value="{!! dollar($item->amount) !!}" />
            </x-splade-cell>
            <x-splade-cell confirmed>
                <x-tomato-admin-row table type="bool" :value="$item->confirmed" />
            </x-splade-cell>

            <x-splade-cell actions>
                <div class="flex justify-start">
                    <x-tomato-admin-button success type="icon" title="{{trans('tomato-admin::global.crud.view')}}" modal :href="route('profile.wallet.show', $item->id)">
                        <x-heroicon-s-eye class="h-6 w-6"/>
                    </x-tomato-admin-button>
                </div>
            </x-splade-cell>
        </x-splade-table>

    </div>
@endsection
