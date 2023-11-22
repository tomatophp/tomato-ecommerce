@extends('tomato-ecommerce::layouts.master')

@section('content')
    <section>
        <x-splade-data default="{showMenu: false}">
            <div class="bg-white">
                <div>
                    @include('tomato-ecommerce::shop.partials.mobile-filter')

                    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        @include('tomato-ecommerce::shop.partials.header')

                        <section aria-labelledby="products-heading" class="pb-24 pt-6">
                            <h2 id="products-heading" class="sr-only">{{__('Products')}}</h2>

                            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                                <x-splade-form method="GET" action="{{url('shop')}}" submit-on-change>
                                    @include('tomato-ecommerce::shop.partials.web-filter')
                                </x-splade-form>

                                <!-- Product grid -->
                                <div class="lg:col-span-3">
                                    <div class="bg-white">
                                        <div class="mx-auto max-w-2xl px-4 sm:px-6 lg:max-w-7xl lg:px-8">
                                            <h2 class="sr-only">{{__('Products')}}</h2>

                                            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
                                                @foreach($products as $product)
                                                    @include('tomato-ecommerce::shop.partials.product-card')
                                                @endforeach
                                            </div>

                                            <div class="my-4">
                                                {!! $products->links('tomato-ecommerce::sections.home.pagination') !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </main>
                </div>
            </div>
        </x-splade-data>
    </section>
@endsection
