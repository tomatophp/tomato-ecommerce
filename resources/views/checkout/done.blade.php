@extends('tomato-ecommerce::layouts.master')

@section('content')
   <div class="my-16 mx-16">
       <div class="text-center my-2">
           <i style="font-size: 120px" class="bx bxs-rocket"></i>
       </div>
       <div class="text-center text-3xl font-bold">
           {{__('Thank you for your order')}}
       </div>
       <div class="flex justify-center gap-8 my-4">
           <div>
               <div class="font-bold">{{__('Order Number: ')}}</div>
               <div>{{$order->uuid}}</div>
           </div>
           <div>
               <div class="font-bold">{{__('Order Date')}}</div>
               <div>
                   {{$order->created_at->format('d M Y')}}
               </div>
           </div>
           <div>
               <div class="font-bold">{{__('Order Total')}}</div>
               <div>
                   {!! dollar($order->total) !!}
               </div>
           </div>
       </div>
       <div class="flex justify-center gap-4">
           <x-tomato-admin-button href="{{route('home.index')}}">
               {{__('Back To Home')}}
           </x-tomato-admin-button>
           <x-tomato-admin-button href="{{route('shop.index')}}">
               {{__('Back To Shop')}}
           </x-tomato-admin-button>
       </div>
   </div>
@endsection
