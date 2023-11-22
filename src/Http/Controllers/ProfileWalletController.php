<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TomatoPHP\TomatoCoupons\Models\GiftCard;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoWallet\Tables\TransactionTable;

class ProfileWalletController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Transaction::query();
        $query->where('payable_type', config('tomato-crm.model'));
        $query->where('payable_id', auth('accounts')->id());
        $table = new TransactionTable($query);
        return view('tomato-ecommerce::profile.wallet.index', compact('table'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tomato-ecommerce::profile.wallet.charge');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        if($request->get('payment_method') === 'gift'){
            $request->validate([
                'gift_code' => 'required|exists:gift_cards,code',
            ]);
        }
        else {
            $request->validate([
                'new_balance' => 'required|numeric|min:1',
            ]);
        }

        $user = auth('accounts')->user();
        if($request->get('payment_method') === 'card'){
            $user->deposit($request->get('new_balance'), ['payment_method' => $request->get('payment_method')]);
        }
        else if($request->get('payment_method') === 'gift'){
            $gift = GiftCard::where('code', $request->get('gift_code'))->first();
            if($gift){
                if($gift->is_expired){
                    Toast::danger(__('Sorry This gift card code is expired!'))->autoDismiss(2);
                    return redirect()->route('profile.wallet.index');
                }
                if(!$gift->is_activated){
                    Toast::danger(__('Sorry This gift card code is not active!'))->autoDismiss(2);
                    return redirect()->route('profile.wallet.index');
                }

                $user->deposit($gift->balance, ['payment_method' => $request->get('payment_method')]);

                $gift->is_expired = true;
                $gift->is_activated = false;
                $gift->save();
            }
            else {
                Toast::danger(__('Sorry This gift card code not found!'))->autoDismiss(2);
                return redirect()->route('profile.wallet.index');
            }
        }

        Toast::success(__('Your wallet has been charged successfully.'))->autoDismiss(2);
        return redirect()->route('profile.wallet.index');

    }

    /**
     * Show the specified resource.
     */
    public function show(Transaction $wallet)
    {
        return view('tomato-ecommerce::profile.wallet.show', compact('wallet'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tomatoecommerce::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
