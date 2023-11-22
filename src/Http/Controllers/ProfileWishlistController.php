<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TomatoPHP\TomatoEcommerce\Models\Wishlist;
use ProtoneMedia\Splade\Facades\Toast;

class ProfileWishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Wishlist::query()->with('product')->where('account_id', auth('accounts')->user()->id)->paginate(10);
        return view('tomato-ecommerce::profile.wishlist.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tomatoecommerce::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            "product_id" => "required|integer|exists:products,id"
        ]);

        $wishlist = \TomatoPHP\TomatoEcommerce\Models\Wishlist::where('account_id', auth('accounts')->user()->id)
            ->where('product_id', $request->get('product_id'))->first();

        if($wishlist){
            $wishlist->delete();

            Toast::success(__('Product removed from wishlist.'))->autoDismiss(2);
            return redirect()->back();
        }

        $wishlist = new \TomatoPHP\TomatoEcommerce\Models\Wishlist;
        $wishlist->account_id = auth('accounts')->user()->id;
        $wishlist->product_id = $request->get('product_id');
        $wishlist->save();

        Toast::success(__('Product added to wishlist.'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('tomatoecommerce::show');
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
