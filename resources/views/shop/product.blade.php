@extends('tomato-ecommerce::layouts.master')

@section('content')
    <div class="bg-white">
        <div class="pt-6">
            @if($product->category)
            @include('tomato-ecommerce::sections.home.breadcrumb', ['links' => [
                [
                    "label" => __('Shop'),
                    "url" => url('/shop')
                ],
                [
                    "label" => $product->category?->name,
                    "url" => url('/shop?categories[]=' . $product->category?->id)
                ],
                [
                    "label" => $product->name,
                    "url" => url('/shop/product/' . $product->slug)
                ]
            ]])
            @else
                @include('tomato-ecommerce::sections.home.breadcrumb', ['links' => [
                [
                    "label" => __('Shop'),
                    "url" => url('/shop')
                ],
                [
                    "label" => $product->name,
                    "url" => url('/shop/product/' . $product->slug)
                ]
            ]])
            @endif


            <div class="grid grid-cols-12 gap-4 mx-4">
                <!-- Image gallery -->
                <div class="mt-4 flex justify-center col-span-12 lg:col-span-5">
                    <x-tomato-admin-slider horizontal type="gallery" class="w-full h-80" :images="$product->getMedia('images')->map(fn($item) => $item->getUrl())->toArray() ?: [$product->getMedia('featured_image')->first()?->getUrl() ?: url('placeholder.webp')]" :items="1" />
                </div>
                @php
                    $loadKeys = [];
                    $loadDefer = [];
                    $ifCheck = "";
                    foreach($product->meta('options') ?? [] as $index=>$options){
                        $loadKeys[$index] = '';
                        $loadDefer[$index] = '';
                        $ifCheck .= "form.{$index}";
                        if(array_keys($product->meta('options'))[count($product->meta('options'))-1] !== $index){
                            $ifCheck .= " && ";
                        }
                    }
                    $loadKeys['product_id'] =$product->id;
                @endphp
                 <div class="mt-2 col-span-12 lg:col-span-7 w-full">
                     <x-splade-form method="POST" action="{{url('cart')}}"  :default="$loadKeys">
                         @if($product->meta('options'))
                             <x-splade-data :default="$loadDefer">
                                 <x-splade-defer
                                     url="{{route('cart.options')}}"
                                     method="post"
                                     request="{ options: data, product_id: {{$product->id}} }"
                                     watch-value="data"
                                 >
                                     <!-- Product info -->
                                     <div class="mx-auto">
                                         <div class="lg:col-span-2  lg:pr-8">
                                             <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{$product->name}}</h1>
                                         </div>

                                         <!-- Description and details -->
                                         @if($product->about)
                                             <div class="my-4">
                                                 <h3 class="sr-only">{{__('Description')}}</h3>

                                                 <div class="space-y-6">
                                                     <p class="text-base text-gray-900">
                                                         {{$product->about}}
                                                     </p>
                                                 </div>
                                             </div>
                                         @endif

                                         <!-- Options -->
                                         <div class="mt-4 lg:row-span-3 lg:mt-0">
                                             <h2 class="sr-only">{{__('Product information')}}</h2>
                                             <p class="text-3xl font-bold tracking-tight text-gray-900">
                                                 @{{ response.price }}<small class="font-normal">{{ setting('local_currency') }}</small>
                                                 <small v-if="response.discount" class="text-danger-500 mx-2">
                                                     <del>
                                                         @{{ response.discount }}<small class="font-normal">{{ setting('local_currency') }}</small>
                                                     </del>
                                                 </small>
                                             </p>

                                             <!-- Reviews -->
                                             <div class="mt-6">
                                                 <h3 class="sr-only">{{__('Reviews')}}</h3>
                                                 <div class="flex items-center">
                                                     <div class="flex items-center">
                                                         @for($i=0; $i<$product->rate; $i++)
                                                             <svg class="text-gray-900 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                 <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                                             </svg>
                                                         @endfor
                                                         @for($i=0; $i<5-$product->rate; $i++)
                                                             <svg class="text-gray-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                                 <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                                             </svg>
                                                         @endfor
                                                     </div>
                                                     <p class="sr-only">{{$product->rate}} {{__('out of 5 stars')}}</p>
                                                     <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                         117 {{__('reviews')}}
                                                     </a>
                                                 </div>
                                             </div>


                                             @foreach($product->meta('options') as $key=>$options)
                                                 @if(\Illuminate\Support\Str::of($key)->contains('color'))
                                                     <div class="my-4">
                                                         <h3 class="text-sm font-medium text-gray-900">{{ \Illuminate\Support\Str::of($key)->title() }}</h3>

                                                         <fieldset class="mt-4">
                                                             <legend class="sr-only">{{ \Illuminate\Support\Str::of($key)->title() }}</legend>
                                                             <div class="flex items-center space-x-3">
                                                                 @foreach($options as $option)
                                                                     <x-tomato-admin-tooltip text="{{ \Illuminate\Support\Str::of($option)->title() }}">
                                                                         <button v-bind:class="{'ring ring-offset-1' : form.{{$key}} === '{{$option}}'}" @click.prevent="form.{{$key}} = '{{$option}}';data.{{$key}} = '{{$option}}'" class="relative -m-0.5 flex cursor-pointer items-center justify-center rounded-full p-0.5 focus:outline-none ring-gray-400">
                                                                             <span id="color-choice-0-label" class="sr-only">{{ \Illuminate\Support\Str::of($option)->title() }}</span>
                                                                             <span aria-hidden="true" style="background-color: {{$option}}" class="h-8 w-8 rounded-full border border-black border-opacity-10"></span>
                                                                         </button>
                                                                     </x-tomato-admin-tooltip>
                                                                 @endforeach

                                                             </div>
                                                         </fieldset>
                                                     </div>
                                                 @else
                                                     <div class="my-4">
                                                         <div class="flex items-center justify-between">
                                                             <h3 class="text-sm font-medium text-gray-900">{{ \Illuminate\Support\Str::of($key)->title() }}</h3>

                                                             @if(\Illuminate\Support\Str::of($key)->contains('size'))
                                                                 <a href="#" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Size guide</a>
                                                             @endif
                                                         </div>

                                                         <fieldset class="mt-4">
                                                             <legend class="sr-only">{{ \Illuminate\Support\Str::of($key)->title() }}</legend>
                                                             <div class="grid grid-cols-4 gap-4 sm:grid-cols-8 lg:grid-cols-4">
                                                                 @foreach($options as $option)
                                                                     <!-- Active: "ring-2 ring-indigo-500" -->
                                                                     <button @click.prevent="form.{{$key}} = '{{$option}}';data.{{$key}} = '{{$option}}'" v-bind:class="{'ring-2 ring-indigo-500' : form.{{$key}} === '{{$option}}'}" class="p-1  group relative flex items-center justify-center rounded-md border text-sm font-medium uppercase hover:bg-gray-50 focus:outline-none sm:flex-1 cursor-pointer bg-white text-gray-900 shadow-sm">
                                                                         <span id="size-choice-1-label" >{{\Illuminate\Support\Str::of($option)->title()}}</span>
                                                                         <span v-bind:class="{'border-indigo-500' : form['{{$key}}'] === '{{$option}}'}" class="pointer-events-none absolute -inset-px rounded-md" aria-hidden="true"></span>
                                                                     </button>
                                                                 @endforeach
                                                             </div>
                                                         </fieldset>
                                                     </div>
                                                 @endif
                                             @endforeach

                                             <div class="flex justify-start gap-4 my-4">
                                                 <x-tomato-admin-submit v-if="{{ $ifCheck }}"  spinner type="submit">
                                                     {{__('Add to cart')}}
                                                 </x-tomato-admin-submit>
                                                 <x-tomato-admin-submit v-else disabled spinner type="submit" >
                                                     {{__('Add to cart')}}
                                                 </x-tomato-admin-submit>

                                                 @if(wishlist($product->id))
                                                     <x-tomato-admin-button danger href="{{route('profile.wishlist.store')}}" method="POST" data="{product_id: '{{$product->id}}'}">
                                                         <div class="flex flex-col items-center justify-center">
                                                             <i class="bx bxs-heart"></i>
                                                         </div>
                                                         <div>
                                                             {{__('Remove from Wishlist')}}
                                                         </div>
                                                     </x-tomato-admin-button>
                                                 @else
                                                     <x-tomato-admin-button secondary href="{{route('profile.wishlist.store')}}" method="POST" data="{product_id: '{{$product->id}}'}">
                                                         <div class="flex flex-col items-center justify-center">
                                                             <i class="bx bx-heart"></i>
                                                         </div>
                                                         <div>
                                                             {{__('Add to Wishlist')}}
                                                         </div>
                                                     </x-tomato-admin-button>
                                                 @endif
                                             </div>
                                         </div>
                                     </div>
                                 </x-splade-defer>
                             </x-splade-data>
                         @else
                             <div class="mx-16">
                                 <div class="lg:col-span-2 lg:pr-8">
                                     <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{$product->name}}</h1>
                                 </div>

                                 <!-- Description and details -->
                                 @if($product->about)
                                     <div class="my-4">
                                         <h3 class="sr-only">{{__('Description')}}</h3>

                                         <div class="space-y-6">
                                             <p class="text-base text-gray-900">
                                                 {{$product->about}}
                                             </p>
                                         </div>
                                     </div>
                                 @endif
                                 <!-- Options -->
                                 <div class="mt-4 lg:row-span-3 lg:mt-0">
                                     <h2 class="sr-only">{{__('Product information')}}</h2>
                                     <p class="text-3xl font-bold tracking-tight text-gray-900">
                                         {{ ($product->price + $product->vat) - $product->discount }}<small class="font-normal">{{ setting('local_currency') }}</small>
                                         @if($product->discount)
                                             <small  class="text-danger-500 mx-2">
                                                 <del>
                                                     {{ $product->price }}<small class="font-normal">{{ setting('local_currency') }}</small>
                                                 </del>
                                             </small>
                                         @endif
                                     </p>

                                     <!-- Reviews -->
                                     <div class="mt-6">
                                         <h3 class="sr-only">{{__('Reviews')}}</h3>
                                         <div class="flex items-center">
                                             <div class="flex items-center">
                                                 @for($i=0; $i<$product->rate; $i++)
                                                     <svg class="text-gray-900 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                         <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                                     </svg>
                                                 @endfor
                                                 @for($i=0; $i<5-$product->rate; $i++)
                                                     <svg class="text-gray-200 h-5 w-5 flex-shrink-0" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                         <path fill-rule="evenodd" d="M10.868 2.884c-.321-.772-1.415-.772-1.736 0l-1.83 4.401-4.753.381c-.833.067-1.171 1.107-.536 1.651l3.62 3.102-1.106 4.637c-.194.813.691 1.456 1.405 1.02L10 15.591l4.069 2.485c.713.436 1.598-.207 1.404-1.02l-1.106-4.637 3.62-3.102c.635-.544.297-1.584-.536-1.65l-4.752-.382-1.831-4.401z" clip-rule="evenodd" />
                                                     </svg>
                                                 @endfor
                                             </div>
                                             <p class="sr-only">{{$product->rate}} {{__('out of 5 stars')}}</p>
                                             <a href="#" class="ml-3 text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                                 117 {{__('reviews')}}
                                             </a>
                                         </div>
                                     </div>

                                     <div class="flex justify-start gap-4 my-4">
                                         <x-tomato-admin-submit success  spinner type="submit">
                                             {{__('Add to cart')}}
                                         </x-tomato-admin-submit>
                                         @if(wishlist($product->id))
                                             <x-tomato-admin-button danger href="{{route('profile.wishlist.store')}}" method="POST" data="{product_id: '{{$product->id}}'}">
                                                 <div class="flex flex-col items-center justify-center">
                                                     <i class="bx bxs-heart"></i>
                                                 </div>
                                                 <div>
                                                     {{__('Remove from Wishlist')}}
                                                 </div>
                                             </x-tomato-admin-button>
                                         @else
                                             <x-tomato-admin-button secondary href="{{route('profile.wishlist.store')}}" method="POST" data="{product_id: '{{$product->id}}'}">
                                                 <div class="flex flex-col items-center justify-center">
                                                     <i class="bx bx-heart"></i>
                                                 </div>
                                                 <div>
                                                     {{__('Add to Wishlist')}}
                                                 </div>
                                             </x-tomato-admin-button>
                                         @endif

                                     </div>
                                 </div>

                             </div>
                         @endif
                     </x-splade-form>
                 </div>

                <div class="py-4 col-span-12 mx-16">

                    @if($product->description)
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{__('Description')}}</h3>

                            <div class="my-4">
                                {!! $product->description !!}
                            </div>
                        </div>
                    @endif

                    @if($product->details)
                        <div class="mt-10">
                            <h2 class="text-lg font-bold text-gray-900">{{__('Details')}}</h2>

                            <div class="my-4">
                                {!! $product->details !!}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
@endsection
