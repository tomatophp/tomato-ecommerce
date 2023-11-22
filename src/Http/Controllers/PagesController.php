<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PagesController extends Controller
{
    public function contact(){
        return view('tomato-ecommerce::pages.contact');
    }

    public function page($slug){
        return view('tomato-ecommerce::pages.page');
    }
}
