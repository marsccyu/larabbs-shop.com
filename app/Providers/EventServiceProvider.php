<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\RegisteredListener;
use App\Listeners\UpdateProductRating;
use Illuminate\Auth\Events\Registered;
use App\Events\OrderReviewed;
use App\Listeners\UpdateCrowdfundingProductProgress;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
        /**
         *  關聯註冊動作(Registered) 至 監聽器(RegisteredListener)
         *  在 framework\src\Illuminate\Foundation\Auth\RegistersUsers.php : 33 中
         *  由 Laravel 自帶的 Auth 模塊觸發監聽器
         */
        Registered::class => [
            RegisteredListener::class,
        ],
        /**
         * 這裡與教程有些不同，原教程會使用到支付模組所以會變成 OrderPaid::class => [] ...
         * 但我沒有使用到支付模組故仍使用 OrderReviewed 事件
         */
        OrderReviewed::class => [
            UpdateProductRating::class,
            UpdateCrowdfundingProductProgress::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

    }

}
