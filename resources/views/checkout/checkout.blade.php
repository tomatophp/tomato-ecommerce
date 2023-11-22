@extends('tomato-ecommerce::layouts.master')

@section('content')
    <div class="flex flex-col items-center border-b bg-white py-4 sm:flex-row sm:px-10 lg:px-20 xl:px-32">
        <div class="text-2xl font-bold text-gray-800">{{__('Checkout')}}</div>
    </div>

    <x-splade-form method="POST" action="{{route('checkout.submit')}}" :default="array_merge(auth('accounts')->user()->toArray(), [
        'shipper_id' => $shippers[0]? $shippers[0]->id : auth('accounts')->user()->meta('shipper_id') ?? null,
        'payment_method' => 'cash',
        'city_id' => auth('accounts')->user()->meta('city_id'),
        'country_id' => auth('accounts')->user()->meta('country_id'),
        'area_id' => auth('accounts')->user()->meta('area_id'),
        'payment_method' => auth('accounts')->user()->meta('payment_method'),
    ])">
    <div class="grid sm:px-10 lg:grid-cols-2 lg:px-20 xl:px-32">
        <div class="px-4 pt-8">
            <p class="text-xl font-medium">{{__('Order Summary')}}</p>
            <p class="text-gray-400">{{__('Check your items. And select a suitable shipping method.')}}</p>
            <div class="mt-8 space-y-3 rounded-lg border bg-white px-2 py-4 sm:px-6">
                @foreach($carts as $cart)
                    <div class="flex flex-col rounded-lg bg-white sm:flex-row">
                        <img class="m-2 h-24 w-28 rounded-md border object-cover object-center" src="{{$cart->product?->getMedia('featured_image')?->first()?->getUrl() ?? url('placeholder.webp')}}" alt="" />
                        <div class="flex w-full flex-col px-4 py-4">
                            <span class="font-semibold">{{$cart->item}}</span>
                            <span class="float-right text-gray-400">
                                @foreach($cart->options as $key=>$option)
                                    {{str($key)->ucfirst()}} : {{$option}} <br>
                                @endforeach
                            </span>
                            <p class="text-lg font-bold">{!! dollar(($cart->price + $cart->vat) - $cart->discount) !!} × {{$cart->qty}} = {!! dollar($cart->total) !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>

            <p class="mt-8 text-lg font-medium">Shipping Methods</p>
            <div class="mt-5 grid gap-6 my-4">
                @foreach($shippers as $shipper)
                    <div class="relative" @click.prevnt="form.shipper_id = @js($shipper->id)">
                        <span v-bind:class="{'border-gray-700':form.shipper_id === @js($shipper->id)}" class="absolute right-4 top-1/2 box-content block h-3 w-3 -translate-y-1/2 rounded-full border-8 border-gray-300 bg-white"></span>
                        <label v-bind:class="{'border-2 border-gray-700 bg-gray-50':form.shipper_id === @js($shipper->id)}" class="flex cursor-pointer select-none rounded-lg border border-gray-300 p-4">
                            <div class="w-14 h-14 bg-center bg-contain rounded-lg border" style="background-image: url('{{$shipper->getMedia('logo')?->first()?->getUrl() ?? url('placeholder.webp')}}')">

                            </div>
                            <div class="ml-5">
                                <span class="mt-2 font-semibold">{{$shipper->name}}</span>
                                <p class="text-slate-500 text-sm leading-6">{{__('Delivery: 2-4 Days')}}</p>
                            </div>
                        </label>
                    </div>
                @endforeach

            </div>
        </div>
        <div class="mt-10 bg-gray-50 px-4 pt-8 lg:mt-0">
            <p class="text-xl font-medium">{{__('Payment Details')}}</p>
            <p class="text-gray-400">{{__('Complete your order by providing your payment details.')}}</p>
            <div class="my-4 flex flex-col gap-4">
                <x-splade-input disabled name="name" type="text"  label="{{__('Name')}}" placeholder="{{__('Your Name')}}" />
                <x-splade-input disabled name="email" type="email"  label="{{__('Email')}}" placeholder="{{__('Your Email')}}" />
                <x-splade-input disabled name="phone" type="tel"  label="{{__('Phone')}}" placeholder="{{__('Your Phone')}}" />
                <x-splade-textarea name="address" type="text"  label="{{__('Address')}}" placeholder="{{__('Your Address')}}" />
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-3">
                    <x-splade-select
                        choices
                        remote-url="{{route('checkout.select') . '?type=country'}}"
                        remote-root="data"
                        name="country_id"
                        label="{{__('County')}}"
                        placeholder="{{__('Your County')}}"
                        option-label="name"
                        option-value="id"
                    />
                    <x-splade-select
                        choices
                        remote-url="`{{route('checkout.select') . '?type=city&country_id='}}${form.country_id}`"
                        remote-root="data"
                        name="city_id"
                        label="{{__('City')}}"
                        placeholder="{{__('Your City')}}"
                        option-label="name"
                        option-value="id"
                    />
                    <x-splade-select
                        choices
                        remote-url="`{{route('checkout.select') . '?type=area&city_id='}}${form.city_id}`"
                        remote-root="data"
                        name="area_id"
                        label="{{__('Area')}}"
                        placeholder="{{__('Your Area')}}"
                        option-label="name"
                        option-value="id"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-white">{{__('Payment Methods')}}</label>
                    <div class="flex justify-start gap-4 my-2">
                        <x-splade-radio name="payment_method" value="cash" label="{{__('Cash')}}" />
                        <x-splade-radio name="payment_method" value="wallet" label="{{__('Wallet')}}" />
                        <x-splade-radio name="payment_method" value="card" label="{{__('Credit Card')}}" />
                    </div>
                </div>
                <x-splade-defer url="{{route('checkout.shipping')}}" method="POST" watch-value="form.area_id" request="{country_id: form.country_id, city_id: form.city_id, area_id: form.area_id, shipper_id: form.shipper_id}">

                <div v-if="form.payment_method === 'wallet'" v-bind:class="{'text-danger-500': @js(auth('accounts')->user()->balance) <= (@js($carts->map(fn($item)=> $item->total)->sum())) , 'text-success-500': (@js(auth('accounts')->user()->balance) >= @js($carts->map(fn($item)=> $item->total)->sum())) }">
                    <span>{{__('You Wallet Balance Is: ')}} @{{ Intl.NumberFormat('en-US', {style: 'currency',currency: @js(setting('local_currency'))}).format(@js(auth('accounts')->user()->balance)) }}</span>
                    @if(auth('accounts')->user()->balance < $carts->map(fn($item)=> $item->total)->sum())
                        <div>
                            {{__('Please Recharge Your Wallet')}}
                        </div>
                    @endif
                </div>

                <!-- Total -->

                <div class="mt-6 border-t border-b py-2">
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">{{__('Subtotal')}}</p>
                        <p class="text-gray-900 font-bold">@{{ Intl.NumberFormat('en-US', {style: 'currency',currency: @js(setting('local_currency'))}).format(@js($carts->map(fn($item)=> $item->total)->sum())) }}</p>
                    </div>
                    <div class="flex items-center justify-between">
                        <p class="text-sm font-medium text-gray-900">{{__('Shipping')}}</p>
                            <p class="font-semibold text-gray-900"><span class="font-bold">@{{ response.price ? Intl.NumberFormat('en-US', {style: 'currency',currency: @js(setting('local_currency'))}).format(response.price) : Intl.NumberFormat('en-US', {style: 'currency',currency: @js(setting('local_currency'))}).format(0) }}</span></p>

                    </div>
                </div>
                <div class="mt-6 flex items-center justify-between">
                    <p class="text-sm font-medium text-gray-900">{{__('Total')}}</p>
                    <p class="text-2xl font-semibold text-gray-900">
                        <span class="font-bold">@{{ response.price ? Intl.NumberFormat('en-US', {style: 'currency',currency: @js(setting('local_currency'))}).format(response.price + @js($carts->map(fn($item)=> $item->total)->sum())) : Intl.NumberFormat(@js(app()->getLocale() === 'ar' ? 'ar-EG' : 'en-US'), {style: 'currency',currency: @js(setting('local_currency'))}).format(@js($carts->map(fn($item)=> $item->total)->sum())) }}</span>
                    </p>
                </div>
                </x-splade-defer>
            </div>
            <x-splade-submit spinner  class="mt-4 mb-8 w-full rounded-md bg-gray-900 px-6 py-3 font-medium text-white">{{__('Place Order')}}</x-splade-submit>
        </div>
    </div>
    </x-splade-form>
@endsection
