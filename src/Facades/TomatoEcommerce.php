<?php

namespace TomatoPHP\TomatoEcommerce\Facades;

use Illuminate\Support\Facades\Facade;
use TomatoPHP\TomatoEcommerce\Models\Cart;

/**
 * @method static \TomatoPHP\TomatoEcommerce\Services\Ecommerce setCart(\TomatoPHP\TomatoEcommerce\Models\Cart $cart)
 * @method static Cart store(\Illuminate\Http\Request $request)
 */
class TomatoEcommerce extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'tomato-ecommerce';
    }
}
