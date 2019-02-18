<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\CouponCode;
use Illuminate\Http\Request;
use App\Exceptions\CouponCodeUnavailableException;

class CouponCodesController extends Controller
{
    public function show($code, Request $request)
    {
        if (!$record = CouponCode::where('code', $code)->first()) {
            throw new CouponCodeUnavailableException('優惠券不存在');
        }

        $record->checkAvailable($request->user());

        return $record;
    }
}
