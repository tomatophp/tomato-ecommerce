<?php


if(!function_exists('wishlist')){
    function wishlist(int $product_id): bool
    {
        $wishlist = \TomatoPHP\TomatoEcommerce\Models\Wishlist::where('account_id', auth('accounts')->user()->id)
            ->where('product_id', $product_id)->first();

        if($wishlist){
            return true;
        }

        return false;
    }
}
