@extends('layouts.app')
@section('title', ($address->id ? '修改': '新增') . '收件地址')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h2 class="text-center">
                        {{ $address->id ? '修改': '新增' }}收件地址
                    </h2>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <h4>錯誤：</h4>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($address->id)
                        <form class="form-horizontal" role="form" action="{{ route('user_addresses.update', ['user_address' => $address->id]) }}" method="post">
                        {{ method_field('PUT') }}
                    @else
                        <form class="form-horizontal" role="form" action="{{ route('user_addresses.store') }}" method="post">
                    @endif
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label class="control-label col-sm-2">市區路</label>
                            <div class="col-sm-3">
                                <select class="form-control" name="province">
                                    <option value="">選擇市</option>
                                    <option value="台北市" @if ($address->province == '台北市') selected @endif>台北市</option>
                                    <option value="新北市" @if ($address->province == '新北市') selected @endif>新北市</option>
                                    <option value="台中市" @if ($address->province == '台中市') selected @endif>台中市</option>
                                    <option value="高雄市" @if ($address->province == '高雄市') selected @endif>高雄市</option>
                                    <option value="台南市" @if ($address->province == '台南市') selected @endif>台南市</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="city">
                                    <option value="">選擇區</option>
                                    <option value="中正區" @if ($address->city == '中正區') selected @endif>中正區</option>
                                    <option value="蘆洲區" @if ($address->city == '蘆洲區') selected @endif>蘆洲區</option>
                                    <option value="中一區" @if ($address->city == '中一區') selected @endif>中一區</option>
                                    <option value="南區" @if ($address->city == '南區') selected @endif>南區</option>
                                    <option value="北區" @if ($address->city == '北區') selected @endif>北區</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select class="form-control" name="district">
                                    <option value="">選擇路</option>
                                    <option value="中山路" @if ($address->district == '中山路') selected @endif>中山路</option>
                                    <option value="民族路" @if ($address->district == '民族路') selected @endif>民族路</option>
                                    <option value="中港路" @if ($address->district == '中港路') selected @endif>中港路</option>
                                    <option value="成功北路" @if ($address->district == '成功北路') selected @endif>成功北路</option>
                                    <option value="花田路" @if ($address->district == '花田路') selected @endif>花田路</option>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">詳細地址</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="address" value="{{ old('address', $address->address) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">郵遞區號</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="zip" value="{{ old('zip', $address->zip) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">姓名</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contact_name" value="{{ old('contact_name', $address->contact_name) }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2">電話</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="contact_phone" value="{{ old('contact_phone', $address->contact_phone) }}">
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">送出</button>
                            <button type="button" onclick="history.back();" class="btn btn-warning">取消</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
