<?php

use App\Http\Middleware\SetLocale;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('home', ['locale' => session('locale', config('app.locale', 'ar'))]);
});

Route::get('/admin/set-locale/{locale}', function (string $locale) {
    if (in_array($locale, ['en', 'ar'], true)) {
        session(['admin_locale' => $locale]);
        app()->setLocale($locale);
    }

    return redirect()->back();
})->name('admin.set-locale');

Route::prefix('{locale}')
    ->where(['locale' => 'ar|en'])
    ->middleware(SetLocale::class)
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
        Route::get('/about', [HomeController::class, 'about'])->name('about');
        Route::get('/services', [HomeController::class, 'services'])->name('services');
        Route::get('/trust', [HomeController::class, 'trust'])->name('trust');
        Route::get('/products', [HomeController::class, 'products'])->name('products');
        Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
        Route::get('/vision', [HomeController::class, 'vision'])->name('vision');
        Route::get('/partners', [HomeController::class, 'partners'])->name('partners');
        Route::get('/clients', [HomeController::class, 'clients'])->name('clients');
        Route::get('/features', [HomeController::class, 'features'])->name('features');
    });

