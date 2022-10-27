<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class CoreProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public $singletons = [
        //models
        'User' => \App\Models\User::class,
        'Product' => \App\Models\Product::class,
        'Size' => \App\Models\Size::class,
        'Sale' => \App\Models\Sale::class,
        'Admin' => \App\Models\Admin::class,
        'Locate' => \App\Models\Locate::class,
        'Order' => \App\Models\Order::class,
        'Category' => \App\Models\Category::class,
        'Rate' => \App\Models\Rate::class,
    ];

    public $bindings = [
        //repositories
        'UserRepository' => \App\Repositories\UserRepository::class,
        'ProductRepository' => \App\Repositories\ProductRepository::class,
        'CategoryRepository' => \App\Repositories\CategoryRepository::class,
        'LocateRepository' => \App\Repositories\LocateRepository::class,
        'RateRepository' => \App\Repositories\RateRepository::class,
        'SizeRepository' => \App\Repositories\SizeRepository::class,
        'OrderRepository' => \App\Repositories\OrderRepository::class,
        'SaleRepository' => \App\Repositories\SaleRepository::class,
        'BaseRepository' => \App\Repositories\BaseRepository::class,
        'CartRepository' => \App\Repositories\CartRepository::class,
    ];
}
