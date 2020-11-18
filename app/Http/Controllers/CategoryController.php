<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\Banner;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index() 
    {
    	session_start();
        if (!isset($_SESSION['cart']['tottal_count'])) {
            $_SESSION['cart']['tottal_count'] = 0;
        }
        if (!isset($_SESSION['cart']['tottal_price'])) {
            $_SESSION['cart']['tottal_price'] = 0;
        }
        if (!isset($_SESSION['cart']['products'])) {
            $_SESSION['cart']['products'] = [];
        }

        $params = Category::getParametrs(1);
        $params['banners'] = Banner::all();

        // передаем menu, category, banners
        return view('site.index', $params);
    }

    public function show($id)
    {
        $params = Category::getParametrs($id);
        $params['banners'] = Banner::all();

        return view('site.index', $params);
    }

    public function ajaxShow($id)
    {
        $params = Category::getParametrs($id);
        $params['banners'] = Banner::all();

        return view('include.ajax_prod', $params);
    }
}
