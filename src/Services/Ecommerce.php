<?php

namespace TomatoPHP\TomatoEcommerce\Services;

use TomatoPHP\TomatoEcommerce\Models\Cart;
use TomatoPHP\TomatoEcommerce\Services\Traits\StoreCart;
use TomatoPHP\TomatoEcommerce\Services\Traits\UpdateQTY;

class Ecommerce
{
    use StoreCart;
    use UpdateQTY;

    private Cart $cart;

    public function setCart(Cart $cart): static
    {
        $this->cart = $cart;
        return $this;
    }
}
