<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->take(10)
            ->get();

        return view('pages.home', compact('products'));
    }
}
