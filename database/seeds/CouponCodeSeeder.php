<?php

use App\Models\CouponCode;
use Illuminate\Database\Seeder;

class CouponCodeSeeder extends Seeder
{
    public function run()
    {
        $couponCode = factory(\App\Models\CouponCode::class, 10)->create();
    }
}
