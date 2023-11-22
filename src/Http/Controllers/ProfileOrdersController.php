<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use TomatoPHP\TomatoOrders\Models\Order;
use TomatoPHP\TomatoOrders\Facades\TomatoOrdering;
use TomatoPHP\TomatoOrders\Tables\OrderTable;
use ProtoneMedia\Splade\Facades\Toast;

class ProfileOrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = Order::query();
        $query->where('account_id', auth('accounts')->id());
        $table = new OrderTable($query);
        return view('tomato-ecommerce::profile.orders.index', compact('table'));
    }

    /**
     * Show the specified resource.
     */
    public function show(Order $order)
    {
        $order->load('ordersItems');
        return view('tomato-ecommerce::profile.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        TomatoOrdering::setOrder($order)->cancel();

        Toast::success(__('Order cancelled successfully'))->autoDismiss(2);
        return redirect()->back();
    }
}
