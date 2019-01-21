<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">訂單流水號：{{ $order->no }}</h3>
        <div class="box-tools">
            <div class="btn-group pull-right" style="margin-right: 10px">
                <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-default"><i class="fa fa-list"></i> 列表</a>
            </div>
        </div>
    </div>
    <div class="box-body">
        <table class="table table-bordered">
            <tbody>
            <tr>
                <td>買家：</td>
                <td>{{ $order->user->name }}</td>
                <td>支付時間：</td>
                <td>
                    @if ($order->paid_at)
                        {{ new \Carbon\Carbon($order->paid_at) }}
                    @else
                        -未支付-
                    @endif
                </td>
            </tr>
            <tr>
                <td>支付方式：</td>
                <td>{{ $order->payment_method }}</td>
                <td>支付渠道單號：</td>
                <td>{{ $order->payment_no }}</td>
            </tr>
            <tr>
                <td>收貨地址</td>
                <td colspan="3">{{ $order->address['address'] }} {{ $order->address['zip'] }} {{ $order->address['contact_name'] }} {{ $order->address['contact_phone'] }}</td>
            </tr>
            <tr>
                <td rowspan="{{ $order->items->count() + 1 }}">商品列表</td>
                <td>商品名稱</td>
                <td>單價</td>
                <td>數量</td>
            </tr>
            @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product->title }} {{ $item->productSku->title }}</td>
                    <td>$ {{ $item->price }}</td>
                    <td>{{ $item->amount }}</td>
                </tr>
            @endforeach
            <tr>
                <td>訂單金額：</td>
                <td>$ {{ $order->total_amount }}</td>
                <!-- 这里也新增了一个发货状态 -->
                <td>發貨狀態：</td>
                <td>{{ \App\Models\Order::$shipStatusMap[$order->ship_status] }}</td>
                @if($order->ship_status === \App\Models\Order::SHIP_STATUS_PENDING)
                    <tr>
                        <td colspan="4">
                            <form action="{{ route('admin.orders.ship', [$order->id]) }}" method="post" class="form-inline">
                                <!-- 别忘了 csrf token 字段 -->
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group {{ $errors->has('express_company') ? 'has-error' : '' }}">
                                    <label for="express_company" class="control-label">物流公司</label>
                                    <input type="text" id="express_company" name="express_company" value="" class="form-control" placeholder="輸入物流公司">
                                    @if($errors->has('express_company'))
                                        @foreach($errors->get('express_company') as $msg)
                                            <span class="help-block">{{ $msg }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('express_no') ? 'has-error' : '' }}">
                                    <label for="express_no" class="control-label">物流單號</label>
                                    <input type="text" id="express_no" name="express_no" value="" class="form-control" placeholder="輸入物流單號">
                                    @if($errors->has('express_no'))
                                        @foreach($errors->get('express_no') as $msg)
                                            <span class="help-block">{{ $msg }}</span>
                                        @endforeach
                                    @endif
                                </div>
                                <button type="submit" class="btn btn-success" id="ship-btn">發貨</button>
                            </form>
                        </td>
                    </tr>
                @else
                    <!-- 否则展示物流公司和物流单号 -->
                    <tr>
                        <td>物流公司：</td>
                        <td>{{ $order->ship_data['express_company'] }}</td>
                        <td>物流單號：</td>
                        <td>{{ $order->ship_data['express_no'] }}</td>
                    </tr>
                @endif
                <!-- 订单发货结束 -->
            </tr>
            </tbody>
        </table>
    </div>
</div>
