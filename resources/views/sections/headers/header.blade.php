@php $section = $page->meta($sectionID); @endphp
<header class="bg-white border-b border-gray-200">
    <div
        class="mx-auto flex h-16 max-w-screen-xl items-center gap-8 px-4 sm:px-6 lg:px-8 z-10"
    >
        <x-splade-link class="block text-teal-600" :href="route('home.index')">
            <span class="sr-only">{{__('Home')}}</span>
            @if(setting('site_logo'))
                <img src="{{setting('site_logo')}}" class="h-8" />
            @else
                <x-application-logo class="w-8 h-8"/>
            @endif
        </x-splade-link>

        <div class="flex flex-1 items-center justify-end md:justify-between">
            <nav aria-label="Global" class="hidden md:block">
                <ul class="flex items-center gap-6 text-sm">
                    @foreach(menu($section['menu_id'] ?? 'main') as $item)
                        <li>
                            <x-splade-link :href="$item->url" class="text-gray-500 transition hover:text-gray-500/75">
                                {{$item->name}}
                            </x-splade-link>
                        </li>
                    @endforeach
                </ul>
            </nav>

            <div class="flex items-center gap-4">
                <div class="flex items-center gap-4">
                    <x-splade-form method="GET" action="{{url('shop')}}" class="relative">
                        <label class="sr-only" for="search"> {{__('Search')}} </label>

                        <input
                            class="h-10 w-full rounded-full border-none bg-white pe-10 ps-4 text-sm shadow-sm sm:w-56"
                            id="search"
                            v-model="form.search"
                            type="search"
                            placeholder="{{__('Search website...')}}"
                        />

                        <button
                            type="button"
                            class="absolute end-1 top-1/2 -translate-y-1/2 rounded-full bg-gray-50 p-2 text-gray-600 transition hover:text-gray-700"
                        >
                            <span class="sr-only">{{__('Search')}}</span>
                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                class="h-4 w-4"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                />
                            </svg>
                        </button>
                    </x-splade-form>

                    <x-splade-link
                        slideover
                        :href="route('cart.cart')"
                        class="block shrink-0 rounded-full bg-white p-2.5 text-gray-600 shadow-sm hover:text-gray-700"
                    >
                        <span class="sr-only">{{__('Cart')}}</span>
                        <div class="flex flex-col justify-center items-center">
                            <i class="bx bx-cart text-md"></i>
                        </div>
                    </x-splade-link>

{{--                    @if(auth('accounts')->user())--}}
{{--                        <a--}}
{{--                            href="#"--}}
{{--                            class="block shrink-0 rounded-full bg-white p-2.5 text-gray-600 shadow-sm hover:text-gray-700"--}}
{{--                        >--}}
{{--                            <span class="sr-only">{{__('Notifications')}}</span>--}}
{{--                            <div class="flex flex-col justify-center items-center">--}}
{{--                                <i class="bx bx-bell text-md"></i>--}}
{{--                            </div>--}}
{{--                        </a>--}}
{{--                    @endif--}}
                </div>

                @if(auth('accounts')->user())
                    <span
                        aria-hidden="true"
                        class="block h-6 w-px rounded-full bg-gray-200"
                    ></span>

                    @php
                        $email = auth('accounts')->user()->email;
                        $default = url('placeholder.webp');
                        $size = 40;
                        $grav_url = "https://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;
                    @endphp

                    <x-splade-link href="{{route('profile.index')}}" class="block shrink-0">
                        <span class="sr-only">{{__('Profile')}}</span>
                        <img
                            alt="{{auth('accounts')->user()->name}}"
                            src="{{$grav_url}}"
                            class="h-10 w-10 rounded-full object-cover"
                        />
                    </x-splade-link>
                @else

                    <div class="sm:flex sm:gap-4">
                        <x-splade-link
                            class="block rounded-md bg-teal-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-teal-700"
                            :href="route('login')"
                        >
                            {{__('Login')}}
                        </x-splade-link>

                        <x-splade-link
                            class="hidden rounded-md bg-gray-100 px-5 py-2.5 text-sm font-medium text-teal-600 transition hover:text-teal-600/75 sm:block"
                            :href="route('register')"
                        >
                            {{__('Register')}}
                        </x-splade-link>
                    </div>

                @endif

                <button
                    class="block rounded bg-gray-100 p-2.5 text-gray-600 transition hover:text-gray-600/75 md:hidden"
                >
                    <span class="sr-only">{{__('Toggle menu')}}</span>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16"
                        />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>
