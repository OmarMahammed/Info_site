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

    public function about()
    {
        $homepageContent = HomepageContent::current();
        return view('pages.about', [
            'aboutContent' => $homepageContent->getAbout(app()->getLocale()),
        ]);
    }

    public function services()
    {
        $homepageContent = HomepageContent::current();
        return view('pages.services', [
            'servicesContent' => $homepageContent->getServices(app()->getLocale()),
        ]);
    }

    public function trust()
    {
        $homepageContent = HomepageContent::current();
        return view('pages.trust', [
            'trustContent' => $homepageContent->getTrust(app()->getLocale()),
        ]);
    }

    public function products()
    {
        $products = Product::latest()->get();

        return view('pages.products', compact('products'));
    }

    public function privacy()
    {
        return view('pages.privacy');
    }
}
