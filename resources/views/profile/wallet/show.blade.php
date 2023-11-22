<x-splade-modal>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

        <x-tomato-admin-row :label="__('Wallet')" :value="$wallet->wallet?->name" type="text" />

        <x-tomato-admin-row :label="__('Payable')" :value="$wallet->payable?->name" type="string" />


        <x-tomato-admin-row :label="__('Type')" :value="$wallet->type" type="string" />
        <x-tomato-admin-row :label="__('Amount')" value="{!! dollar($wallet->amount) !!}" type="string" />


        <x-tomato-admin-row :label="__('Confirmed')" :value="$wallet->confirmed" type="bool" />


        <x-tomato-admin-row :label="__('Uuid')" :value="$wallet->uuid" type="string" />

    </div>
    <div class="flex justify-start gap-2 pt-3">

        <x-tomato-admin-button secondary :href="route('profile.wallet.index')" label="{{__('Cancel')}}"/>
    </div>
</x-splade-modal>
