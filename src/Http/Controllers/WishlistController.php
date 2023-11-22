<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoAdmin\Facade\Tomato;

class WishlistController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = \TomatoPHP\TomatoEcommerce\Models\Wishlist::class;
    }

    /**
     * @param Request $request
     * @return View|JsonResponse
     */
    public function index(Request $request): View|JsonResponse
    {
        return Tomato::index(
            request: $request,
            model: $this->model,
            view: 'tomato-ecommerce::wishlists.index',
            table: \TomatoPHP\TomatoEcommerce\Tables\WishlistTable::class
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function api(Request $request): JsonResponse
    {
        return Tomato::json(
            request: $request,
            model: \TomatoPHP\TomatoEcommerce\Models\Wishlist::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-ecommerce::wishlists.create',
        );
    }

    /**
     * @param Request $request
     * @return RedirectResponse|JsonResponse
     */
    public function store(Request $request): RedirectResponse|JsonResponse
    {
        $response = Tomato::store(
            request: $request,
            model: \TomatoPHP\TomatoEcommerce\Models\Wishlist::class,
            validation: [
                            'account_id' => 'required|exists:accounts,id',
            'product_id' => 'required|exists:products,id'
            ],
            message: __('Wishlist updated successfully'),
            redirect: 'admin.wishlists.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Wishlist $model
     * @return View|JsonResponse
     */
    public function show(\TomatoPHP\TomatoEcommerce\Models\Wishlist $model): View|JsonResponse
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-ecommerce::wishlists.show',
        );
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Wishlist $model
     * @return View
     */
    public function edit(\TomatoPHP\TomatoEcommerce\Models\Wishlist $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-ecommerce::wishlists.edit',
        );
    }

    /**
     * @param Request $request
     * @param \TomatoPHP\TomatoEcommerce\Models\Wishlist $model
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, \TomatoPHP\TomatoEcommerce\Models\Wishlist $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            validation: [
                            'account_id' => 'sometimes|exists:accounts,id',
            'product_id' => 'sometimes|exists:products,id'
            ],
            message: __('Wishlist updated successfully'),
            redirect: 'admin.wishlists.index',
        );

         if($response instanceof JsonResponse){
             return $response;
         }

         return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Wishlist $model
     * @return RedirectResponse|JsonResponse
     */
    public function destroy(\TomatoPHP\TomatoEcommerce\Models\Wishlist $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::destroy(
            model: $model,
            message: __('Wishlist deleted successfully'),
            redirect: 'admin.wishlists.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }
}
