<?php

namespace TomatoPHP\TomatoEcommerce\Services\Traits;

use TomatoPHP\TomatoEcommerce\Models\Cart;
use TomatoPHP\TomatoEcommerce\Models\Wishlist;
use TomatoPHP\TomatoProducts\Models\ProductReview;

trait InteractsWithEcommerce
{
    public function reviews(){
        return $this->hasMany(ProductReview::class);
    }

    public function wishlist(){
        return $this->hasMany(Wishlist::class);
    }

    public function carts(){
        return $this->hasMany(Cart::class);
    }
}
