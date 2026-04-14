<?php

namespace App\Providers;

use App\Models\HomepageContent;
use Filament\Facades\Filament;
use Filament\View\PanelsRenderHook;
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
        App::setLocale(session('admin_locale', config('app.locale')));

        View::composer('components.ui.footer', function ($view) {
            $view->with(
                'footerContent',
                HomepageContent::current()->getFooter(app()->getLocale())
            );
        });

        Filament::serving(function (): void {
            App::setLocale(session('admin_locale', 'en'));

            Filament::registerRenderHook(
                PanelsRenderHook::TOPBAR_END,
                fn (): string => view('admin.lang-switch')->render(),
            );
        });
    }
}
