@extends('tomato-ecommerce::layouts.profile')

@section('body')
    <div class="flex flex-col justify-center items-center text-center py-6 dark:bg-gray-900 dark:text-gray-100">
        <div>
            @php
                $email = auth('accounts')->user()->email;
                $default = url('placeholder.webp');
                $size = 200;
                $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
            @endphp

            <img src="{{$grav_url}}" alt="" class="w-32 h-32 mx-auto rounded-full dark:bg-gray-500 aspect-square">
            <div class="space-y-4 text-center divide-y dark:divide-gray-700">
                <div class="my-2 space-y-1">
                    <h2 class="text-xl font-semibold sm:text-2xl">{{auth('accounts')->user()->name}}</h2>
                    <p class="px-5 text-xs sm:text-base dark:text-gray-400">{{auth('accounts')->user()->email}}</p>
                </div>
            </div>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4 my-8 w-full px-8">
            <!-- Card -->
            <div class="flex items-center p-4 bg-white border rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500">
                    <x-heroicon-s-star class="w-4 h-4" />
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                       {{__('Product Reviews')}}
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ auth('accounts')->user()->reviews->count() }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white border rounded-lg shadow-xs dark:bg-gray-800">
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
            <!-- Card -->
            <div class="flex items-center p-4 bg-white border rounded-lg shadow-xs dark:bg-gray-800">
                <div class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500">
                    <x-heroicon-s-shopping-cart class="w-4 h-4" />
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        {{__('My Wishlist')}}
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ auth('accounts')->user()->wishlist->count() }}
                    </p>
                </div>
            </div>
            <!-- Card -->
            <div class="flex items-center p-4 bg-white border rounded-lg shadow-xs dark:bg-gray-800">

                <div class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500">
                    <x-heroicon-s-rocket-launch class="w-4 h-4" />
                </div>
                <div>
                    <p class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400">
                        {{__('My Orders')}}
                    </p>
                    <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                        {{ auth('accounts')->user()->orders->count() }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
