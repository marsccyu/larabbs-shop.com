<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrdersAddCouponCodeId extends Migration
{

    public function up()
    {
        // 修改 Orders 表結構，添加一個 coupon_code_id 欄位
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('coupon_code_id')->nullable()->after('paid_at');
            // onDelete('set null') 代表如果這個訂單有關聯優惠券並且該優惠券被刪除時將自動把 coupon_code_id 設成 null。
            // 我們不能因為刪除了優惠券就把關聯這個優惠券的訂單都刪除了。
            $table->foreign('coupon_code_id')->references('id')->on('coupon_codes')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['coupon_code_id']);
            $table->dropColumn('coupon_code_id');
        });
    }
}
