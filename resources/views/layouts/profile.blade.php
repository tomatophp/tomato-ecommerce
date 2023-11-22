@extends('tomato-ecommerce::layouts.master')

@section('content')
    <div class="grid grid-cols-12">
        <div class="col-span-4 p-4">
            <div class="w-full rounded-lg bg-white border border-gray-200 overflow-hidden">
                <div class="flex flex-col">
                    <x-splade-link :href="route('profile.index')" :class="url()->current() == url('profile') ? 'text-center px-4 py-4 border-b bg-primary-500 text-white font-bold' : 'text-center px-4 py-4 border-b'">
                        {{__('Profile Dashboard')}}
                    </x-splade-link>
                    <x-splade-link :href="route('profile.address.index')" :class="url()->current() == url('profile/address') ? 'text-center px-4 py-4 border-b bg-primary-500 text-white font-bold' : 'text-center px-4 py-4 border-b'">
                        {{__('Address')}}
                    </x-splade-link>
                    <x-splade-link :href="route('profile.orders.index')" :class="url()->current() == url('profile/orders') ? 'text-center px-4 py-4 border-b bg-primary-500 text-white font-bold' : 'text-center px-4 py-4 border-b'">
                        {{__('Orders')}}
                    </x-splade-link>
                    <x-splade-link :href="route('profile.wishlist.index')" :class="url()->current() == url('profile/wishlist') ? 'text-center px-4 py-4 border-b bg-primary-500 text-white font-bold' : 'text-center px-4 py-4 border-b'">
                        {{__('Wishlist')}}
                    </x-splade-link>
                    <x-splade-link :href="route('profile.wallet.index')" :class="url()->current() == url('profile/wallet') ? 'text-center px-4 py-4 border-b bg-primary-500 text-white font-bold' : 'text-center px-4 py-4 border-b'">
                        {{__('Wallet')}}
                    </x-splade-link>
                    <x-splade-link :href="route('profile.edit')" :class="url()->current() == url('profile/edit') ? 'text-center px-4 py-4 border-b bg-primary-500 text-white font-bold' : 'text-center px-4 py-4 border-b'">
                        {{__('Edit Profile')}}
                    </x-splade-link>
                    <x-splade-link :href="route('profile.logout')" class="font-bold text-center px-4 py-4 bg-danger-500 text-white">
                        {{__('Logout')}}
                    </x-splade-link>
                </div>
            </div>
        </div>
        <div class="col-span-8">
            @yield('body')
        </div>
    </div>
@endsection
