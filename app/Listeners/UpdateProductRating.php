<?php

namespace App\Listeners;

use DB;
use App\Models\OrderItem;
use App\Events\OrderReviewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

// 添加 implements ShouldQueue 便可以將事件加入隊列非同步進行
class UpdateProductRating implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function handle(OrderReviewed $event)
    {
        // 通过 with 方法提前加载数据，避免 N + 1 性能问题
        $items = $event->getOrder()->items()->with(['product'])->get();
        foreach ($items as $item) {
            $result = OrderItem::query()
                ->where('product_id', $item->product_id)
                ->whereHas('order', function ($query) {
                    $query->whereNotNull('paid_at');
                })
                // first() 方法接受一個數組作為參數，代表此次SQL 要查詢出來的字段，默認情況下Laravel 會給數組裡面的值的兩邊加上` 這個符號，
                // 比如first(['name', 'email'] ) 生成的SQL 會類似： select `name`, `email` from xxx
                // 如果我們直接傳入 first(['count(*) as review_count', 'avg(rating) as rating']) 最後生成的 SQL 肯定是不正確的。
                // 這裡我們用 DB::raw() 方法來解決這個問題，Laravel 在構建 SQL 的時候如果遇到 DB::raw() 就會把 DB::raw() 的參數原樣拼接到 SQL 裡。
                ->first([
                    DB::raw('count(*) as review_count'),
                    DB::raw('avg(rating) as rating')
                ]);
            // 更新商品的评分和评价数
            $item->product->update([
                'rating'       => $result->rating,
                'review_count' => $result->review_count,
            ]);
        }
    }
}
