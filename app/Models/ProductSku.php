<?php

namespace App\Models;

use App\Exceptions\InternalException;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    protected $fillable = ['title', 'description', 'price', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function decreaseStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('檢庫存不能小於 0');
        }

        /**
         * 我們用了$this->newQuery() 方法來獲取數據庫的查詢構造器，ORM 查詢構造器的寫操作只會返回 true 或 false 代表 SQL 是否執行成功，而數據庫查詢構造器的寫操作則會返回影響的行數。
         * 這樣可以保證不會出現執行之後 stock 值為負數的情況，也就避免了超賣的問題。
         * 而且我們用了數據庫查詢構造器，可以通過返回的影響行數來判斷減庫存操作是否成功，如果不成功說明商品庫存不足。
         */

        return $this->newQuery()->where('id', $this->id)->where('stock', '>=', $amount)->decrement('stock', $amount);
    }

    public function addStock($amount)
    {
        if ($amount < 0) {
            throw new InternalException('加庫存不能小於 0');
        }
        $this->increment('stock', $amount);
    }
}
