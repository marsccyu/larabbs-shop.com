<?php

namespace App\Http\Requests;


class UserAddressRequest extends Request
{
    public function attributes()
    {
        return [
            'city'      => '市',
            'area'          => '區',
            'road'      => '路',
            'address'       => '详细地址',
            'zip'           => '邮编',
            'contact_name'  => '姓名',
            'contact_phone' => '电话',
        ];
    }

    public function rules()
    {
        return [
            'city'      => 'required',
            'area'          => 'required',
            'road'      => 'required',
            'address'       => 'required',
            'zip'           => 'required',
            'contact_name'  => 'required',
            'contact_phone' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'zip.required' => '郵遞區號 不能留白',
            'contact_name.required' => '聯絡人名稱 不能留白',
            'contact_phone.required' => '聯絡人電話 不能留白',
        ];
    }
}
