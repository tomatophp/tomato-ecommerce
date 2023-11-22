<x-splade-modal>
    <x-splade-data :default="['balance' => auth('accounts')->user()->balance]">
        <x-splade-form confirm class="flex flex-col gap-4" action="{{route('profile.wallet.store')}}" method="post" :default="['payment_method' => 'card']">
            <div>
                {{__('Current User Balance:')}} <span class="text-xl font-bold">@{{ parseFloat(data.balance) }}</span>{{setting('local_currency')}}
            </div>
            <div>
                {{__('New Balance:')}} <span class="text-xl font-bold">@{{ parseFloat(form.new_balance ?form.new_balance: 0) }}</span>{{setting('local_currency')}}
            </div>
            <div>
                {{__('Balance After Charge:')}} <span class="text-xl font-bold">@{{ parseFloat(data.balance) + parseFloat(form.new_balance ?form.new_balance: 0) }}</span>{{setting('local_currency')}}
            </div>
            <hr>
            <div>
                <label class="block text-sm font-medium leading-6 text-gray-950 dark:text-white">{{__('Payment Methods')}}</label>
                <div class="flex justify-start gap-4 my-2">
                    <x-splade-radio name="payment_method" value="gift" label="{{__('Gift Card')}}" />
                    <x-splade-radio name="payment_method" value="card" label="{{__('Credit Card')}}" />
                </div>
            </div>
            <x-splade-input v-if="form.payment_method==='card'" label="{{__('Total Amount')}}" name="new_balance" type="number" placeholder="{{__('Total Amount')}}"  />
            <x-splade-input v-if="form.payment_method==='gift'" label="{{__('Gift Card Code')}}" name="gift_code" type="text" placeholder="{{__('Gift Card Code')}}"  />


            <x-tomato-admin-submit class="col-span-2" label="{{__('Add New Balance')}}" :spinner="true" />
        </x-splade-form>
    </x-splade-data>
</x-splade-modal>
