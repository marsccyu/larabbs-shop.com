@extends('layouts.app')
@section('title', '收件地址列表')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    收件地址列表
                    <a href="{{ route('user_addresses.create') }}" class="pull-right">新增收件地址</a>
                </div>

                <div class="panel-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>收件人</th>
                            <th>地址</th>
                            <th>郵遞區號</th>
                            <th>電話</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($addresses as $address)
                            <tr>
                                <td>{{ $address->contact_name }}</td>
                                <td>{{ $address->full_address }}</td>
                                <td>{{ $address->zip }}</td>
                                <td>{{ $address->contact_phone }}</td>
                                <td>
                                    <button class="btn btn-primary">修改</button>
                                    <button class="btn btn-danger">刪除</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
