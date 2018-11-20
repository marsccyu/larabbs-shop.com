<?php

namespace App\Http\Controllers;

use Mail;
use Cache;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Exceptions\InvalidRequestException;
use App\Notifications\EmailVerificationNotification;

class EmailVerificationController extends Controller
{
    public function send(Request $request)
    {
        $user = $request->user();
        // 判斷用戶是否驗證完成
        if ($user->email_verified) {
            throw new InvalidRequestException('您已經驗證過郵件了');
        }
        // 调用 notify() 方法用来发送我们定义好的通知类
        $user->notify(new EmailVerificationNotification());

        return view('pages.success', ['msg' => '郵件發送成功']);
    }

    public function verify(Request $request)
    {
        // 取得參數
        $email = $request->input('email');
        $token = $request->input('token');
        // 如果有一个为空说明不是一个合法的验证链接，直接抛出异常。
        if (!$email || !$token) {
            throw new InvalidRequestException('验证链接不正确');
        }
        // 从缓存中读取数据，我们把从 url 中获取的 `token` 与缓存中的值做对比
        // 如果缓存不存在或者返回的值与 url 中的 `token` 不一致就抛出异常。
        if ($token != Cache::get('email_verification_'.$email)) {
            throw new InvalidRequestException('驗證連接不正確或過期');
        }

        // 根據郵件從資料庫中取出對應的用戶
        if (!$user = User::where('email', $email)->first()) {
            throw new InvalidRequestException('用戶不存在');
        }
        // 将指定的 key 从缓存中删除，由于已经完成了验证，这个缓存就没有必要继续保留。
        Cache::forget('email_verification_'.$email);
        // 最关键的，要把对应用户的 `email_verified` 字段改为 `true`。
        $user->update(['email_verified' => true]);

        // 最后告知用户邮箱验证成功。
        return view('pages.success', ['msg' => '郵件驗證成功']);
    }
}
