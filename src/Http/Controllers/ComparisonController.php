<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoAdmin\Facade\Tomato;

class ComparisonController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = \TomatoPHP\TomatoEcommerce\Models\Comparison::class;
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
            view: 'tomato-ecommerce::comparisons.index',
            table: \TomatoPHP\TomatoEcommerce\Tables\ComparisonTable::class
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
            model: \TomatoPHP\TomatoEcommerce\Models\Comparison::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-ecommerce::comparisons.create',
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
            model: \TomatoPHP\TomatoEcommerce\Models\Comparison::class,
            validation: [
                            'account_id' => 'required|exists:accounts,id',
            'product_id' => 'required|exists:products,id',
            'compare_with' => 'nullable'
            ],
            message: __('Comparison updated successfully'),
            redirect: 'admin.comparisons.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Comparison $model
     * @return View|JsonResponse
     */
    public function show(\TomatoPHP\TomatoEcommerce\Models\Comparison $model): View|JsonResponse
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-ecommerce::comparisons.show',
        );
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Comparison $model
     * @return View
     */
    public function edit(\TomatoPHP\TomatoEcommerce\Models\Comparison $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-ecommerce::comparisons.edit',
        );
    }

    /**
     * @param Request $request
     * @param \TomatoPHP\TomatoEcommerce\Models\Comparison $model
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, \TomatoPHP\TomatoEcommerce\Models\Comparison $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            validation: [
                            'account_id' => 'sometimes|exists:accounts,id',
            'product_id' => 'sometimes|exists:products,id',
            'compare_with' => 'nullable'
            ],
            message: __('Comparison updated successfully'),
            redirect: 'admin.comparisons.index',
        );

         if($response instanceof JsonResponse){
             return $response;
         }

         return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Comparison $model
     * @return RedirectResponse|JsonResponse
     */
    public function destroy(\TomatoPHP\TomatoEcommerce\Models\Comparison $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::destroy(
            model: $model,
            message: __('Comparison deleted successfully'),
            redirect: 'admin.comparisons.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }
}
