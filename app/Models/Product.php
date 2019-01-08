<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'on_sale',
        'rating', 'sold_count', 'review_count', 'price'
    ];
    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一個布林值
    ];
    // 與商品 SKU 關聯
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }
}
