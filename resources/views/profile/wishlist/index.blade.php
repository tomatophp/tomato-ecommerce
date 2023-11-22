@extends('tomato-ecommerce::layouts.profile')

@section('body')
    <div class="px-8 py-4">
        <div class="flex justify-between items-center my-4">
            <h1 class="text-2xl font-bold">{{__('Wishlist')}}</h1>
        </div>

        @if($products->count())
            <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
                @foreach($products as $product)
                    @include('tomato-ecommerce::shop.partials.product-card', ['product' => $product->product])
                @endforeach
            </div>

            <div class="my-4">
                {!! $products->links('tomato-ecommerce::sections.home.pagination') !!}
            </div>
        @else
            <div>
                {{__('You have no products in your wishlist.')}}
            </div>
        @endif
    </div>
@endsection
