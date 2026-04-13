<?php

namespace App\Http\Controllers;

use App\Models\HomepageContent;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $locale = app()->getLocale();

        $products = Product::query()
            ->where('is_active', true)
            ->orderBy('id')
            ->take(10)
            ->get();

        $homepageContent = HomepageContent::current();

        return view('pages.home', [
            'locale' => $locale,
            'isRtl' => $locale === 'ar',
            'products' => $products,
            'aboutContent' => $homepageContent->getAbout($locale),
            'servicesContent' => $homepageContent->getServices($locale),
            'trustContent' => $homepageContent->getTrust($locale),
        ]);
    }
}
