@extends('tomato-ecommerce::layouts.profile')

@section('body')
    <div class="px-8 py-4">
        <div class="flex justify-between items-center my-4">
            <h1 class="text-2xl font-bold">{{__('Show Order ')}} #{{$order->uuid}}</h1>
        </div>
    </div>
    <div class="border rounded-lg p-4 mx-4 mb-4">
        @php $company = \TomatoPHP\TomatoOrders\Models\Branch::find(setting('ordering_web_branch'))?->company @endphp

        <div class="flex justify-between xl:gap-60 lg:gap-48 md:gap-16 sm:gap-8 sm:flex-row flex-col gap-4">
            <div class="w-full">
                <div class=" my-4">
                    <img src="{{setting('site_logo')}}" alt="{{setting('site_name')}}" class="h-12 ">
                </div>
                <div class="flex flex-col">
                    <div>
                        {{__('From:')}}
                    </div>
                    <div class="text-lg font-bold mt-2">
                        {{$company->name}}
                    </div>
                    <div class="text-sm">
                        {{$company->ceo}}
                    </div>
                    <div class="text-sm">
                        {{$company->address}}
                    </div>
                    <div class="text-sm">
                        {{$company->zip}} {{$company->city}}
                    </div>
                    <div class="text-sm">
                        {{$company->country?->name}}
                    </div>
                </div>
                <div class="mt-4">
                    <div>
                        {{__('To:')}}
                    </div>
                    <div class="mt-4">
                        <div class="text-lg font-bold mt-2">
                            {{$order->account?->name}}
                        </div>
                        <div class="text-sm">
                            {{$order->account?->email}}
                        </div>
                        <div class="text-sm">
                            {{$order->account?->phone}}
                        </div>
                        <div class="text-sm">
                            {{$order->address}}
                        </div>
                        <div class="text-sm">
                            {{$order->country?->name}} , {{$order->city?->name}}, {{$order->area?->name}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <div class="flex justify-between gap-4">
                    <div class="flex flex-col justify-center items-center">
                        {{__('Invoice')}}
                    </div>
                    <div>
                        {{$order->uuid}}
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <div class="flex flex-col justify-center items-center">
                        {{__('Issue date')}}
                    </div>
                    <div>
                        {{$order->created_at->toDateString()}}
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <div class="flex flex-col justify-center items-center">
                        {{__('Due date')}}
                    </div>
                    <div>
                        {{$order->created_at->toDateString()}}
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <div class="flex flex-col justify-center items-center">
                        {{__('Status')}}
                    </div>
                    <div>
                        {{str($order->status)->upper()}}
                    </div>
                </div>
                <div class="flex justify-between gap-4">
                    <div class="flex flex-col justify-center items-center">
                        {{__('Source')}}
                    </div>
                    <div class="font-bold text-primary-500">
                        {{str($order->source)->upper()}}
                    </div>
                </div>
            </div>
        </div>
        <div>
            <div class="grid grid-cols-12 gap-4 border-b py-4 my-4 font-bold">
                <div class="col-span-4 ">
                    {{__('Item')}}
                </div>
                <div>
                    {{__('Price')}}
                </div>
                <div>
                    {{__('Discount')}}
                </div>
                <div class="col-span-2">
                    {{__('Tax')}}
                </div>
                <div>
                    {{__('QTY')}}
                </div>
                <div>
                    {{__('Total')}}
                </div>
            </div>
            <div class="flex flex-col gap-4">
                @foreach($order->ordersItems as $item)
                    <div class="grid grid-cols-12 gap-4 border-b py-4">
                        <div class="col-span-4 flex  flex-col justify-start">
                            <div>
                                {{ $item->product?->name }}
                            </div>
                            <div class="text-gray-400">
                                @foreach($item->options as $label=>$options)
                                    <span>{{  str($label)->ucfirst() }}</span> : {{$options}} <br>
                                @endforeach
                            </div>
                        </div>
                        <div>
                            {!! dollar($item->price) !!}
                        </div>
                        <div>
                            {!! dollar($item->discount) !!}
                        </div>
                        <div class="col-span-2">
                            {!! dollar($item->tax) !!}
                        </div>
                        <div>
                            {{$item->qty}}
                        </div>
                        <div>
                            {!! dollar($item->total) !!}
                        </div>
                    </div>
                @endforeach

            </div>
            <div class="flex flex-col gap-4 mt-4">
                <div class="flex justify-between gap-4 py-4 border-b">
                    <div class="font-bold">
                        {{__('Sub Total')}}
                    </div>
                    <div>
                        {!! dollar(($order->total + $order->discount) - ($order->vat + $order->shipping)) !!}
                    </div>
                </div>
                <div class="flex justify-between gap-4 py-4 border-b text-success-500">
                    <div class="font-bold">
                        {{__('Tax')}}
                    </div>
                    <div>
                        {!! dollar($order->vat ) !!}
                    </div>
                </div>
                <div class="flex justify-between gap-4 py-4 border-b text-success-500">
                    <div class="font-bold">
                        {{__('Shipping')}}
                    </div>
                    <div>
                        {!! dollar($order->shipping ) !!}
                    </div>
                </div>
                <div class="flex justify-between gap-4 py-4 border-b text-danger-500">
                    <div class="font-bold">
                        {{__('Discount')}}
                    </div>
                    <div>
                        {!! dollar($order->discount ) !!}
                    </div>
                </div>
                <div class="flex justify-between gap-4 py-4 border-b text-primary-500">
                    <div class="font-bold">
                        {{__('Total')}}
                    </div>
                    <div>
                        {!! dollar($order->total) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
