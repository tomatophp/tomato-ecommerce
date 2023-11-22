<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use TomatoPHP\TomatoCms\Models\Page;

class TomatoEcommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $page = Page::where('slug', '/')->first();
        return view('tomato-ecommerce::index', compact('page'));
    }
}
