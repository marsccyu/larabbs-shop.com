<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->text('description');
            $table->string('image');
            $table->boolean('on_sale')->default(true);
            $table->float('rating')->default(5);
            $table->unsignedInteger('sold_count')->default(0);
            $table->unsignedInteger('review_count')->default(0);
            // 電商項目中與錢相關的有小數點的字段一律使用 decimal 類型，而不是 float 和 double，後面兩種類型在做小數運算時有可能出現精度丟失的問題
            // 定義 decimal 字段時需要兩個參數，一個是數值總的精度（整數位 + 小數位），另一個參數則是小數位。對於我們這個系統來說總精度10、小數位精度2即可滿足需求（約 1 億）。
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
