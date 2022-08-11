<?php

namespace App\Providers;

use App\Http\Controllers\Backend\Category\Contracts\CategoryInterface;
use App\Http\Controllers\Backend\Category\Repositories\CategoryRepository;
use App\Http\Controllers\Backend\Discount\Contracts\DiscountInterface;
use App\Http\Controllers\Backend\Discount\Repositories\DiscountRepository;
use App\Http\Controllers\Backend\DiscountRule\Contracts\DiscountRuleInterface;
use App\Http\Controllers\Backend\DiscountRule\Repositories\DiscountRuleRepository;
use App\Http\Controllers\Backend\Order\Contracts\OrderInterface;
use App\Http\Controllers\Backend\Order\Repositories\OrderRepository;
use App\Http\Controllers\Backend\OrderProduct\Contracts\OrderProductInterface;
use App\Http\Controllers\Backend\OrderProduct\Repositories\OrderProductRepository;
use App\Http\Controllers\Backend\Product\Contracts\ProductInterface;
use App\Http\Controllers\Backend\Product\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryInterfaceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(OrderInterface::class, OrderRepository::class);
        $this->app->bind(OrderProductInterface::class, OrderProductRepository::class);
        $this->app->bind(DiscountRuleInterface::class, DiscountRuleRepository::class);
        $this->app->bind(DiscountInterface::class, DiscountRepository::class);
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
}
