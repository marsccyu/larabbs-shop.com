<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CouponCode::class, function (Faker $faker) {
    // 首先隨機取得類型
    $type  = $faker->randomElement(array_keys(App\Models\CouponCode::$typeMap));

    $couponFixed = App\Models\CouponCode::TYPE_FIXED;

    // 根據取得類型產生對應折扣內容
    $value = $type === $couponFixed ? random_int(1, 200) : random_int(1, 50);

    // 如果是固定金额，则最低订单金额必须要比优惠金额高 0.01 元
    if ($type === $couponFixed) {
        $minAmount = $value + 0.01;
    } else {
        // 如果是百分比折扣，有 50% 概率不需要最低订单金额
        if (random_int(0, 100) < 50) {
            $minAmount = 0;
        } else {
            $minAmount = random_int(100, 1000);
        }
    }

    return [
        'name'       => join(' ', $faker->words), // 随机生成名称
        'code'       => App\Models\CouponCode::findAvailableCode(), // 调用优惠码生成方法
        'type'       => $type,
        'value'      => $value,
        'total'      => 1000,
        'used'       => 0,
        'min_amount' => $minAmount,
        'not_before' => null,
        'not_after'  => null,
        'enabled'    => true,
    ];
});
