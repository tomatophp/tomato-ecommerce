@extends('tomato-ecommerce::layouts.profile')

@section('body')
    <div class="px-8 py-4">
        <div class="flex justify-between items-center my-4">
            <h1 class="text-2xl font-bold">{{__('Orders')}}</h1>
        </div>
        <x-splade-table :for="$table">
            <x-splade-cell account.name>
                <x-tomato-admin-row table type="badge" href="{{route('admin.accounts.show', $item->account?->id)}}" :value="$item->account?->name" />
            </x-splade-cell>
            <x-splade-cell created_at>
                <x-tomato-admin-row table type="text" :value="$item->created_at->diffForHumans()" />
            </x-splade-cell>
            <x-splade-cell phone>
                <x-tomato-admin-row table type="tel" :value="$item->phone" />
            </x-splade-cell>
            <x-splade-cell total>
                {!! dollar($item->total) !!}
            </x-splade-cell>
            <x-splade-cell actions>
                <div class="flex justify-start gap-2">
                    @if($item->status !== setting('ordering_cancelled_status'))
                    <x-tomato-admin-tooltip text="{{__('Cancel')}}">
                        <x-tomato-admin-button danger type="icon" confirm method="POST" :href="route('profile.orders.cancel', $item->id)">
                            <x-heroicon-s-x-circle class="h-6 w-6"/>
                        </x-tomato-admin-button>
                    </x-tomato-admin-tooltip>
                    @endif
{{--                    <x-tomato-admin-tooltip text="{{__('Print')}}">--}}
{{--                        <x-tomato-admin-button warning type="icon" confirm method="POST" :href="route('profile.orders.print', $item->id)">--}}
{{--                            <x-heroicon-s-printer class="h-6 w-6"/>--}}
{{--                        </x-tomato-admin-button>--}}
{{--                    </x-tomato-admin-tooltip>--}}
                    <x-tomato-admin-tooltip text="{{trans('tomato-admin::global.crud.view')}}">
                        <x-tomato-admin-button success modal type="icon" :href="route('profile.orders.show', $item->id)">
                            <x-heroicon-s-eye class="h-6 w-6"/>
                        </x-tomato-admin-button>
                    </x-tomato-admin-tooltip>

                </div>
            </x-splade-cell>
        </x-splade-table>
    </div>
@endsection
