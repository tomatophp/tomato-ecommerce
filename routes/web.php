<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'splade'])->name('home.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\TomatoEcommerceController::class, 'index'])->name('index');
//    Route::get('/contact', [\TomatoPHP\TomatoEcommerce\Http\Controllers\PagesController::class, 'contact'])->name('contact');
});

Route::middleware(['web', 'splade'])->prefix('shop')->name('shop.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ShopController::class, 'index'])->name('index');
    Route::get('/category/{slug}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ShopController::class, 'category'])->name('category');
    Route::get('/product/{slug}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ShopController::class, 'product'])->name('product');
});

//Route::middleware(['web', 'splade'])->prefix('blog')->name('blog.')->group(function() {
//    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\BlogController::class, 'index'])->name('index');
//    Route::get('/category/{slug}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\BlogController::class, 'category'])->name('category');
//    Route::get('/posts/{slug}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\BlogController::class, 'post'])->name('post');
//});




Route::middleware(['web', 'splade', 'auth:accounts'])->name('checkout.')->group(function() {
    Route::get('/checkout', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'index'])->name('index');
    Route::post('/checkout', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'submit'])->name('submit');
    Route::get('/checkout/select', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'select'])->name('select');
    Route::post('/checkout/shipping', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'shipping'])->name('shipping');
    Route::post('/checkout/balance', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'balance'])->name('balance');
    Route::get('/checkout/done/{order}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'done'])->name('done');
});

Route::middleware(['web', 'splade'])->name('cart.')->group(function() {
    Route::get('/cart', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'cart'])->name('cart');
    Route::post('/cart', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'store'])->name('store');
    Route::post('/cart/options', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'options'])->name('options');
    Route::post('/cart/clear', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'clear'])->name('clear');
    Route::post('/cart/{cart}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'update'])->name('update');
    Route::delete('/cart/{cart}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CheckoutController::class, 'destroy'])->name('destroy');
});

Route::middleware(['web', 'splade'])->prefix('auth')->group(function() {
    Route::get('/login', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::post('/login', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'check'])->name('login.check');
    Route::get('/register', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/register', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'store'])->name('register.store');
    Route::get('/reset', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'reset'])->name('reset');
    Route::get('/forget', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'forget'])->name('forget');
    Route::get('/email', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'email'])->name('email');
    Route::get('/otp', [\TomatoPHP\TomatoEcommerce\Http\Controllers\AuthController::class, 'otp'])->name('otp');
});

Route::middleware(['web', 'splade'])->prefix('profile')->name('profile.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileController::class, 'index'])->name('index');
    Route::get('/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileController::class, 'edit'])->name('edit');
    Route::post('/update', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileController::class, 'update'])->name('update');
    Route::post('/password', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileController::class, 'password'])->name('password');
    Route::delete('/close', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileController::class, 'close'])->name('close');
    Route::get('/logout', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileController::class, 'logout'])->name('logout');
});

Route::middleware(['web', 'splade'])->prefix('profile/wishlist')->name('profile.wishlist.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWishlistController::class, 'index'])->name('index');
    Route::post('/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWishlistController::class, 'store'])->name('store');
    Route::delete('/{wishlist}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWishlistController::class, 'destroy'])->name('destroy');
});

Route::middleware(['web', 'splade'])->prefix('profile/address')->name('profile.address.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'index'])->name('index');
    Route::get('/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'create'])->name('create');
    Route::post('/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'store'])->name('store');
    Route::post('/{address}/select', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'select'])->name('select');
    Route::get('/{address}/show', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'show'])->name('show');
    Route::get('/{address}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'edit'])->name('edit');
    Route::post('/{address}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'update'])->name('update');
    Route::delete('/{address}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileAddressController::class, 'destroy'])->name('destroy');
});

Route::middleware(['web', 'splade'])->prefix('profile/orders')->name('profile.orders.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileOrdersController::class, 'index'])->name('index');
    Route::get('/{order}/show', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileOrdersController::class, 'show'])->name('show');
    Route::get('/{order}/print', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileOrdersController::class, 'print'])->name('print');
    Route::post('/{order}/cancel', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileOrdersController::class, 'cancel'])->name('cancel');
});


Route::middleware(['web', 'splade'])->prefix('profile/wallet')->name('profile.wallet.')->group(function() {
    Route::get('/', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWalletController::class, 'index'])->name('index');
    Route::get('/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWalletController::class, 'create'])->name('create');
    Route::post('/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWalletController::class, 'store'])->name('store');
    Route::get('/{wallet}/show', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWalletController::class, 'show'])->name('show');
    Route::get('/{wallet}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWalletController::class, 'edit'])->name('edit');
    Route::post('/{wallet}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ProfileWalletController::class, 'update'])->name('update');
});


Route::middleware(['web','auth', 'splade', 'verified'])->name('admin.')->group(function () {
    Route::get('admin/carts', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'index'])->name('carts.index');
    Route::get('admin/carts/api', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'api'])->name('carts.api');
    Route::get('admin/carts/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'create'])->name('carts.create');
    Route::post('admin/carts', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'store'])->name('carts.store');
    Route::get('admin/carts/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'show'])->name('carts.show');
    Route::get('admin/carts/{model}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'edit'])->name('carts.edit');
    Route::post('admin/carts/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'update'])->name('carts.update');
    Route::delete('admin/carts/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\CartController::class, 'destroy'])->name('carts.destroy');
});
//
//Route::middleware(['auth', 'splade', 'verified'])->name('admin.')->group(function () {
//    Route::get('admin/searches', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'index'])->name('searches.index');
//    Route::get('admin/searches/api', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'api'])->name('searches.api');
//    Route::get('admin/searches/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'create'])->name('searches.create');
//    Route::post('admin/searches', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'store'])->name('searches.store');
//    Route::get('admin/searches/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'show'])->name('searches.show');
//    Route::get('admin/searches/{model}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'edit'])->name('searches.edit');
//    Route::post('admin/searches/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'update'])->name('searches.update');
//    Route::delete('admin/searches/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\SearchController::class, 'destroy'])->name('searches.destroy');
//});
//
//Route::middleware(['auth', 'splade', 'verified'])->name('admin.')->group(function () {
//    Route::get('admin/wishlists', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'index'])->name('wishlists.index');
//    Route::get('admin/wishlists/api', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'api'])->name('wishlists.api');
//    Route::get('admin/wishlists/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'create'])->name('wishlists.create');
//    Route::post('admin/wishlists', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'store'])->name('wishlists.store');
//    Route::get('admin/wishlists/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'show'])->name('wishlists.show');
//    Route::get('admin/wishlists/{model}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'edit'])->name('wishlists.edit');
//    Route::post('admin/wishlists/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'update'])->name('wishlists.update');
//    Route::delete('admin/wishlists/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\WishlistController::class, 'destroy'])->name('wishlists.destroy');
//});
//
//Route::middleware(['auth', 'splade', 'verified'])->name('admin.')->group(function () {
//    Route::get('admin/comparisons', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'index'])->name('comparisons.index');
//    Route::get('admin/comparisons/api', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'api'])->name('comparisons.api');
//    Route::get('admin/comparisons/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'create'])->name('comparisons.create');
//    Route::post('admin/comparisons', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'store'])->name('comparisons.store');
//    Route::get('admin/comparisons/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'show'])->name('comparisons.show');
//    Route::get('admin/comparisons/{model}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'edit'])->name('comparisons.edit');
//    Route::post('admin/comparisons/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'update'])->name('comparisons.update');
//    Route::delete('admin/comparisons/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\ComparisonController::class, 'destroy'])->name('comparisons.destroy');
//});
//
//Route::middleware(['auth', 'splade', 'verified'])->name('admin.')->group(function () {
//    Route::get('admin/downloads', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'index'])->name('downloads.index');
//    Route::get('admin/downloads/api', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'api'])->name('downloads.api');
//    Route::get('admin/downloads/create', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'create'])->name('downloads.create');
//    Route::post('admin/downloads', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'store'])->name('downloads.store');
//    Route::get('admin/downloads/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'show'])->name('downloads.show');
//    Route::get('admin/downloads/{model}/edit', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'edit'])->name('downloads.edit');
//    Route::post('admin/downloads/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'update'])->name('downloads.update');
//    Route::delete('admin/downloads/{model}', [\TomatoPHP\TomatoEcommerce\Http\Controllers\DownloadController::class, 'destroy'])->name('downloads.destroy');
//});
