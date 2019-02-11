<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SendReviewRequest extends Request
{
    public function rules()
    {
        return [
            'reviews' => ['required', 'array'],
            'reviews.*.id' => [
                'required',
                // $this->route('order')->id : 獲得當前路由對應的訂單對象
                // Rule::exists() 判斷用戶提交的 ID 是否屬於此訂單
                Rule::exists('order_items', 'id')->where('order_id', $this->route('order')->id)
            ],
            'reviews.*.rating' => ['required', 'integer', 'between:1,5'],
            'reviews.*.review' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'reviews.*.rating' => '評分',
            'reviews.*.review' => '評價',
        ];
    }
}
