<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\UserAddress;
use App\Policies\OrderPolicy;
use App\Policies\UserAddressPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(OrderProduct::class, OrderPolicy::class);
        Gate::policy(UserAddress::class, UserAddressPolicy::class);
    }
}
