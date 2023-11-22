<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use TomatoPHP\TomatoAdmin\Facade\Tomato;

class DownloadController extends Controller
{
    public string $model;

    public function __construct()
    {
        $this->model = \TomatoPHP\TomatoEcommerce\Models\Download::class;
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
            view: 'tomato-ecommerce::downloads.index',
            table: \TomatoPHP\TomatoEcommerce\Tables\DownloadTable::class
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
            model: \TomatoPHP\TomatoEcommerce\Models\Download::class,
        );
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return Tomato::create(
            view: 'tomato-ecommerce::downloads.create',
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
            model: \TomatoPHP\TomatoEcommerce\Models\Download::class,
            validation: [
                            'account_id' => 'required|exists:accounts,id',
            'product_id' => 'required|exists:products,id'
            ],
            message: __('Download updated successfully'),
            redirect: 'admin.downloads.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Download $model
     * @return View|JsonResponse
     */
    public function show(\TomatoPHP\TomatoEcommerce\Models\Download $model): View|JsonResponse
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-ecommerce::downloads.show',
        );
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Download $model
     * @return View
     */
    public function edit(\TomatoPHP\TomatoEcommerce\Models\Download $model): View
    {
        return Tomato::get(
            model: $model,
            view: 'tomato-ecommerce::downloads.edit',
        );
    }

    /**
     * @param Request $request
     * @param \TomatoPHP\TomatoEcommerce\Models\Download $model
     * @return RedirectResponse|JsonResponse
     */
    public function update(Request $request, \TomatoPHP\TomatoEcommerce\Models\Download $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::update(
            request: $request,
            model: $model,
            validation: [
                            'account_id' => 'sometimes|exists:accounts,id',
            'product_id' => 'sometimes|exists:products,id'
            ],
            message: __('Download updated successfully'),
            redirect: 'admin.downloads.index',
        );

         if($response instanceof JsonResponse){
             return $response;
         }

         return $response->redirect;
    }

    /**
     * @param \TomatoPHP\TomatoEcommerce\Models\Download $model
     * @return RedirectResponse|JsonResponse
     */
    public function destroy(\TomatoPHP\TomatoEcommerce\Models\Download $model): RedirectResponse|JsonResponse
    {
        $response = Tomato::destroy(
            model: $model,
            message: __('Download deleted successfully'),
            redirect: 'admin.downloads.index',
        );

        if($response instanceof JsonResponse){
            return $response;
        }

        return $response->redirect;
    }
}
