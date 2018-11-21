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
                                    <a href="{{ route('user_addresses.edit', ['user_address' => $address->id]) }}" class="btn btn-primary">修改</a>
                                    <button class="btn btn-danger btn-del-address" type="button" data-id="{{ $address->id }}">刪除</button>
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
@section('scriptsAfterJs')
    <script>
        $(document).ready(function() {
            // 刪除按鈕 點擊事件
            $('.btn-del-address').click(function() {
                // 獲取按鈕上data-id屬性的值，也就是地址ID
                var id = $(this).data('id');
                // 调用 sweetalert
                swal({
                    title: "確認刪除此筆地址？",
                    icon: "warning",
                    buttons: ['取消', '確定'],
                    dangerMode: true,
                })
                    .then(function(willDelete) { //用戶點擊按鈕後會觸發這個回調函數
                        //用戶點擊確定willDelete值為true，否則為false
                        //用戶點了取消，啥也不做
                        if (!willDelete) {
                            return;
                        }
                        // 调用删除接口，用 id 来拼接出请求的 url
                        // axios 似乎是 vue.js 中的方法... 待之後認識
                        axios.delete('/user_addresses/' + id)
                            .then(function () {
                                // 请求成功之后重新加载页面
                                location.reload();
                            })
                    });
            });
        });
    </script>
@endsection
