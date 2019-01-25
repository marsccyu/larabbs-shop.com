<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    // 用常量的方式定義支持的優惠券類型
    const TYPE_FIXED = 'fixed';
    const TYPE_PERCENT = 'percent';

    public static $typeMap = [
        self::TYPE_FIXED   => '固定金額',
        self::TYPE_PERCENT => '比例',
    ];

    protected $appends = ['description'];

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'total',
        'used',
        'min_amount',
        'not_before',
        'not_after',
        'enabled',
    ];
    protected $casts = [
        'enabled' => 'boolean',
    ];
    // 指定這兩個欄位為日期型態
    protected $dates = ['not_before', 'not_after'];

    public static function findAvailableCode($length = 6)
    {
        do {
            // 生成一个指定长度的随机字符串，并转成大写
            $code = strtoupper(Str::random($length));
            // 如果生成的码已存在就继续循环
        } while (self::query()->where('code', $code)->exists());

        return $code;
    }

    public function getDescriptionAttribute()
    {
        $str = '';

        if ($this->min_amount > 0) {
            $str = '滿 '.str_replace('.00', '', $this->min_amount);
        }
        if ($this->type === self::TYPE_PERCENT) {
            return $str.' 優惠 '.str_replace('.00', '', $this->value).'%';
        }

        return $str.' 减 '.str_replace('.00', '', $this->value);
    }
}
