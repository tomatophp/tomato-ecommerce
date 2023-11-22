<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    public function index(){
        return view('tomato-ecommerce::blog.index');
    }

    public function post($slug){
        return view('tomato-ecommerce::blog.post');
    }

    public function category($slug){
        return view('tomato-ecommerce::blog.category');
    }
}
