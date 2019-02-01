<?php

namespace App\Http\Requests;

use App\Models\ProductSku;
use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku_id' => [
                'required',
                /**
                 * 閉包校驗規則，閉包接受 3 個參數，分別是參數名、參數值和錯誤回調
                 * https://laravel-china.org/docs/laravel/5.6/validation/1372#using-closures
                 */
                // 在 AJAX 的請求中使用 validate 方法時，Laravel 並不會生成一個重定向響應，而是會生成一個包含所有驗證錯誤信息的 JSON 響應。
                // 這個 JSON 響應會包含一個 HTTP 狀態碼 422 被發送出去。
                function ($attribute, $value, $fail) {
                    if (!$sku = ProductSku::find($value)) {
                        return $fail('商品不存在');
                    }
                    if (!$sku->product->on_sale) {
                        return $fail('該商品未上架');
                    }
                    if ($sku->stock === 0) {
                        return $fail('商品已售完');
                    }
                    if ($this->input('amount') > 0 && $sku->stock < $this->input('amount')) {
                        return $fail('商品庫存不足');
                    }
                },
            ],
            'amount' => ['required', 'integer', 'min:1'],
        ];
    }

    public function attributes()
    {
        return [
            'amount' => '商品數量'
        ];
    }

    public function messages()
    {
        return [
            'sku_id.required' => '請選擇商品'
        ];
    }
}
