<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'email_verified',
    ];

    // 將數據庫字段值轉換為常見的數據類型，$casts 屬性應是一個數組，且數組的鍵是那些需要被轉換的字段名，
    // 值則是你希望轉換的數據類型。
    protected $casts = [
        'email_verified' => 'boolean',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function addresses()
    {
        return $this->hasMany(UserAddress::class);
    }

    public function favoriteProducts()
    {
        // belongsToMany() 方法用於定義一個多對多的關聯，第一個參數是關聯的模型類名，第二個參數是中間表的表名。
        // withTimestamps() 代表中間表帶有時間戳字段。
        // orderBy('user_favorite_products.created_at', 'desc') 代表默認的排序方式是根據中間表的創建時間倒序
        return $this->belongsToMany(Product::class, 'user_favorite_products')
            ->withTimestamps()
            ->orderBy('user_favorite_products.created_at', 'desc');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function topics()
    {
        return $this->hasMany(Topics::class);
    }

}
