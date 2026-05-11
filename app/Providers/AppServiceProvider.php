<?php

namespace App\Providers;

use App\Models\HomepageContent;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('components.ui.footer', function ($view) {
            $view->with(
                'footerContent',
                HomepageContent::current()->getFooter(app()->getLocale())
            );
        });

        Filament::serving(function (): void {
            $locale = session('admin_locale', config('app.locale', 'ar'));
            App::setLocale($locale);

            Filament::registerRenderHook(
                'panels::topbar.end',
                fn (): string => view('admin.lang-switch')->render(),
            );

            Filament::registerRenderHook(
                'panels::head.end',
                fn (): string => '<script>document.documentElement.setAttribute("dir","' . ($locale === 'ar' ? 'rtl' : 'ltr') . '");document.documentElement.setAttribute("lang","' . e($locale) . '");</script>',
            );
        });
    }
}
