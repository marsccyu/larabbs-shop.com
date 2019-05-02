<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    protected $fillable = [
        'province',
        'city',
        'district',
        'address',
        'zip',
        'contact_name',
        'contact_phone',
        'last_used_at',
    ];
    protected $dates = ['last_used_at'];

    // 序列話 full_saddress 訪問器，才可以在 show.blade.php 的地址清單中顯示出來
    protected $appends = ['full_address'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 建立訪問器 (https://laravel-china.org/docs/laravel/5.6/eloquent-mutators/1406#accessors-and-mutators)
     * 透過 UserAddress->full_address 訪問此函式 會回傳組合好的長串地址
     * @return string
     */
    public function getFullAddressAttribute()
    {
        return "{$this->province}{$this->city}{$this->district}{$this->address}";
    }
}
