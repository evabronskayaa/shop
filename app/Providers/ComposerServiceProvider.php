<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layout.part.roots', function($view) {
            $view->with(['items' => Category::all()]);
        });
        View::composer('layout.part.brands', function ($view) {
            $view->with(['items' => Brand::popular()]);
        });
        View::composer('layout.site', function($view) {
            $view->with(['positions' => Cart::getCount()]);
        });
        View::composer('layout.part.pages', function($view) {
            $view->with(['pages' => Page::all()]);
        });
    }
}
