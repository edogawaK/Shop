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

    public $singletons=[
        //models
        'user'=>\App\Models\User::class,
        'product'=>\App\Models\Product::class,
        'size'=>\App\Models\Size::class,
        'sale'=>\App\Models\Sale::class,
        'admin'=>\App\Models\Admin::class,
        'locate'=>\App\Models\Locate::class,
        'order'=>\App\Models\Order::class,
        'category'=>\App\Models\Category::class,
        'rate'=>\App\Models\Rate::class,

        //repositories
        'user'=>\App\Models\User::class,
        'product'=>\App\Models\Product::class,
        'size'=>\App\Models\Size::class,
        'sale'=>\App\Models\Sale::class,
        'admin'=>\App\Models\Admin::class,
        'locate'=>\App\Models\Locate::class,
        'order'=>\App\Models\Order::class,
        'category'=>\App\Models\Category::class,
        'rate'=>\App\Models\Rate::class,
    ];

    public $bindings=[
        //
    ];
}
