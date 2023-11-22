<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Str;
use Illuminate\View\View;
use TomatoPHP\TomatoEcommerce\Models\Cart;
use TomatoPHP\TomatoEcommerce\Facades\TomatoEcommerce;
use TomatoPHP\TomatoEcommerce\Services\Cart\ProductsServices;
use TomatoPHP\TomatoOrders\Models\Order;
use TomatoPHP\TomatoOrders\Models\ShippingPrice;
use TomatoPHP\TomatoOrders\Models\ShippingVendor;
use TomatoPHP\TomatoOrders\Facades\TomatoOrdering;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoAdmin\Facade\Tomato;
use TomatoPHP\TomatoLocations\Models\Area;
use TomatoPHP\TomatoLocations\Models\City;
use TomatoPHP\TomatoLocations\Models\Country;
use TomatoPHP\TomatoProducts\Models\Product;

class CheckoutController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = \TomatoPHP\TomatoEcommerce\Models\Cart::class;
    }

    public function index(){
        if(auth('accounts')->user()){
            $carts = Cart::where('account_id', auth('accounts')->user()->id)->get();
        }
        else {
            $carts = Cart::where('session_id', session()->getId())->get();
        }

        $shippers = ShippingVendor::where('is_activated', 1)->get();


        if($carts->count()){
            return view('tomato-ecommerce::checkout.checkout', compact('carts', 'shippers'));
        }
        else {
            Toast::danger(__('Cart is empty'))->autoDismiss(2);
            return redirect()->route('shop.index');
        }
    }

    public function options(Request $request){
        $request->validate([
            "product_id" => "required|exists:products,id",
            "options" => "nullable|array",
        ]);

        $price = ProductsServices::getProductPrice($request->get('product_id'), $request->get('options'));
        return response()->json([
            "price" => $price->collect(),
            "discount" => $price->collectDiscount()
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function cart(Request $request): \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        if(auth('accounts')->user()){
            $request->merge([
                'account_id' => auth('accounts')->user()->id
            ]);
        }
        else {
            $request->merge([
                'session_id' => session()->getId()
            ]);
        }

        $carts = Cart::where('session_id', $request->get('session_id'))
            ->where('account_id', $request->get('account_id'))
            ->get();

        return view('tomato-ecommerce::checkout.cart', compact('carts'));
    }


    /**
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $cart = TomatoEcommerce::store($request);

        if(is_string($cart)){
            Toast::success($cart)->autoDismiss(2);
            return redirect()->back();
        }
        else {
            Toast::success(__('Cart added successfully'))->autoDismiss(2);
            return redirect()->back();
        }
    }

    /**
     * @param Request $request
     * @param \TomatoPHP\TomatoEcommerce\Models\Cart $cart
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, \TomatoPHP\TomatoEcommerce\Models\Cart $cart): RedirectResponse|JsonResponse
    {
        TomatoEcommerce::setCart($cart)->updateQTY($request);

        Toast::success(__('Cart updated successfully'))->autoDismiss(2);
        return redirect()->back();
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Cart $cart
     * @return RedirectResponse
     */
    public function destroy(\TomatoPHP\TomatoEcommerce\Models\Cart $cart): RedirectResponse
    {
        Cart::where('session_id', session()->getId())->where('id', $cart->id)->delete();
        Toast::success(__('Cart deleted successfully'))->autoDismiss(2);
        return redirect()->back();
    }

    public function clear(){
        Cart::where('session_id', session()->getId())->delete();
        Toast::success(__('Cart cleared successfully'))->autoDismiss(2);
        return redirect()->back();
    }

    public function select(Request $request){
        $request->validate([
            "type" => "required|string"
        ]);

        if($request->get('type') === 'country'){
            $countries = Country::all();
            return response()->json([
                "data" => $countries
            ]);
        }
        if($request->get('type') === 'city'){
            $city = City::where('country_id', $request->get('country_id'))->get();
            return response()->json([
                "data" => $city
            ]);
        }
        if($request->get('type') === 'area'){
            $area = Area::where('city_id', $request->get('city_id'))->get();
            return response()->json([
                "data" => $area
            ]);
        }
    }

    public function shipping(Request $request){
        return response()->json([
            "price" => TomatoOrdering::getShippingPrice($request),
        ]);
    }

    public function submit(Request $request){
        $order = TomatoOrdering::storeWebOrder($request);
        if(!is_string($order)){
            Toast::success(__('Order submitted successfully'))->autoDismiss(2);
            return redirect()->route('checkout.done', $order->id);
        }
        else {
            Toast::danger(__('Insufficient balance'))->autoDismiss(2);
            return redirect()->back();
        }
    }

    public function done(Order $order){
        if($order->account_id === auth('accounts')->user()->id){
            $order->load('ordersItems');
            return view('tomato-ecommerce::checkout.done', compact('order'));
        }
        else {
            Toast::danger(__('Order not found'))->autoDismiss(2);
            return redirect()->route('shop.index');
        }
    }
}
