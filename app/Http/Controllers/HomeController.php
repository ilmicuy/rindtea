<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Category;
use App\Models\HeroSection;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $hero_section = HeroSection::orderByDesc('id')->take(1)->get();
        $abouts = About::take(1)->get();
        $menus = Menu::orderBy('id')->get();
        $products = Product::orderBy('id')->get();
        return view('pages.home', compact('hero_section', 'abouts', 'menus', 'products'));
    }

    public function detail(Request $request)
    {
        $product = $request->id;
        $product = Product::findOrFail($product);
        return view('pages.product-detail', compact('product'));
    }
}
