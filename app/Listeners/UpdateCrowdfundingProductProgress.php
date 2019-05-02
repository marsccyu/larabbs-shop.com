<?php

namespace App\Listeners;

use App\Events\OrderPaid;
use App\Models\Order;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateCrowdfundingProductProgress implements ShouldQueue
{
    public function handle(OrderPaid $event)
    {
        $order = $event->getOrder();
        // 如果订单类型不是众筹商品订单，无需处理
        if ($order->type !== Order::TYPE_CROWDFUNDING) {
            return;
        }
        $crowdfunding = $order->items[0]->product->crowdfunding;

        $data = Order::query()
            // 查出订单类型为众筹订单
            ->where('type', Order::TYPE_CROWDFUNDING)
            // 并且是已支付的
            ->whereNotNull('paid_at')
            ->whereHas('items', function ($query) use ($crowdfunding) {
                // 并且包含了本商品
                $query->where('product_id', $crowdfunding->product_id);
            })
            // 重點看一下first() 方法，first() 方法接受一個數組作為參數，代表此次SQL 要查詢出來的字段，
            // 默認情況下Laravel 會給數組裡面的值的兩邊加上` 這個符號，比如first([ 'name', 'email']) 生成的SQL 會類似：
            // select `name`, `email` from xxx
            // 所以如果我們直接傳入 first(['sum(total_amount) as total_amount', 'count(distinct(user_id)) as user_count'])，最後生成的 SQL 肯定是不正確的。
            // 這裡我們用 DB::raw() 方法來解決這個問題，Laravel 在構建 SQL 的時候如果遇到 DB::raw() 就會把 DB::raw() 的參數原樣拼接到 SQL 裡。
            ->first([
                // 取出订单总金额
                \DB::raw('sum(total_amount) as total_amount'),
                // 取出去重的支持用户数
                \DB::raw('count(distinct(user_id)) as user_count'),
            ]);

        $crowdfunding->update([
            'total_amount' => $data->total_amount,
            'user_count'   => $data->user_count,
        ]);
    }
}
