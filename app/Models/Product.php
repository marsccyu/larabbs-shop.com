<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    const TYPE_NORMAL = 'normal';
    const TYPE_CROWDFUNDING = 'crowdfunding';
    public static $typeMap = [
        self::TYPE_NORMAL  => '普通商品',
        self::TYPE_CROWDFUNDING => '眾籌商品',
    ];

    protected $fillable = [
        'title', 'description', 'image', 'on_sale',
        'rating', 'sold_count', 'review_count', 'price', 'type'
    ];
    protected $casts = [
        'on_sale' => 'boolean', // on_sale 是一個布林值
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Laravel 訪問器 ( https://laravelacademy.org/post/8213.html )
    public function getImageUrlAttribute()
    {
        // 如果 image 字段本身就已经是完整的 url 就直接返回
        if (Str::startsWith($this->attributes['image'], ['http://', 'https://'])) {
            return $this->attributes['image'];
        }

        return \Storage::disk('admin')->url($this->attributes['image']);
    }

    // 與商品 SKU 關聯
    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function crowdfunding()
    {
        return $this->hasOne(CrowdfundingProduct::class);
    }

}
