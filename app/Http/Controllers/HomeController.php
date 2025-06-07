<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    //
    public function Home()
    {
        $hotProducts = Product::where('is_active', true)->where('hot', true)->paginate(8);
        $products = Product::where('is_active', true)->paginate(8);
        $categories = Category::select('id', 'name')->paginate(8);

        return view('home', compact('products', 'categories', 'hotProducts'));
    }

    public function Contact(){
        return view('contact');
    }

    public function About(){
        return view('about');
    }
}
