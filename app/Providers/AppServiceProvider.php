<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Carbon::setLocale('zh-TW');

        // 當 Laravel 渲染 products.index 和 products.show 模板時，就會使用 CategoryTreeComposer 這個來注入類目樹變量
        // 同時 Laravel 還支持通配符，例如 products.* 即代表當渲染 products 目錄下的模板時都執行這個 ViewComposer
        \View::composer(['products.index', 'products.show'], \App\Http\ViewComposers\CategoryTreeComposer::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
