<?php

namespace App\Providers;

use App\Services\OrderService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
class OrderServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(OrderService::class, function ($app) {
            return new OrderService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Log when an Order is created
        Order::created(function ($order) {
            Log::info("Order created: ", ['id' => $order->id, 'user_id' => $order->user_id, 'total' => $order->total]);
        });

        // Log when an Order is updated
        Order::updated(function ($order) {
            Log::info("Order updated: ", ['id' => $order->id, 'user_id' => $order->user_id, 'total' => $order->total]);
        });

        // Log when an Order is deleted
        Order::deleted(function ($order) {
            Log::info("Order deleted: ", ['id' => $order->id, 'user_id' => $order->user_id, 'total' => $order->total]);
        });
        // Log when an Order is retrieved
        Order::retrieved(function ($order) {
            Log::info("Order retrieved: ", ['id' => $order->id, 'user_id' => $order->user_id, 'total' => $order->total]);
        });

    }
}
