@extends('layouts.app')
@section('title', '發現錯誤')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Error.</div>
        <div class="panel-body text-center">
            <h1>{{ $msg }}</h1>
            <a class="btn btn-primary" href="{{ route('root') }}">回首頁</a>
        </div>
    </div>
@endsection
