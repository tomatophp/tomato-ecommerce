@extends('tomato-ecommerce::layouts.profile', ['withoutCard' => true])

@section('body')
    @php $user = auth('accounts')->user(); @endphp
    <div class="px-8 py-4">
        <div class="flex justify-between items-center my-4">
            <h1 class="text-2xl font-bold">{{__('Edit Profile')}}</h1>
        </div>
        <div class="flex flex-col gap-6">
            <div class="dark:bg-gray-800 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl" dusk="update-profile-information">
                    @include('tomato-ecommerce::profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="dark:bg-gray-800 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl" dusk="update-password">
                    @include('tomato-ecommerce::profile.partials.update-password-form')
                </div>
            </div>

            <div class="dark:bg-gray-800 p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl" dusk="delete-user">
                    @include('tomato-ecommerce::profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>

@endsection
