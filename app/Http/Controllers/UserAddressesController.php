<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAddress;
use App\Http\Requests\UserAddressRequest;

class UserAddressesController extends Controller
{
    public function create()
    {
        return view('user_addresses.create_and_edit', ['address' => new UserAddress()]);
    }

    public function index(Request $request)
    {
        return view('user_addresses.index', [
            'addresses' => $request->user()->addresses,
        ]);
    }

    public function store(UserAddressRequest $request)
    {
        $request->user()    // 取得登入用戶
            ->addresses()   // 獲取當前用戶與地址的關聯關係（注意：這裡並不是獲取當前用戶的地址列表）
            ->create($request->only([ // 以 only 白名單方式從提交的數據中取得我們需要填入資料庫的部分即可
                    'province',
                    'city',
                    'district',
                    'address',
                    'zip',
                    'contact_name',
                    'contact_phone',
                ])
            );

        return redirect()->route('user_addresses.index');
    }
}
