@extends('layouts.default')
@section('title', '首页')

@section('content')
    <div class="jumbotron">
        <h1>Hello World!</h1>
        <p class="lead">
            测试内容
        </p>
        <p>
            Everything Will Be OJBK!
        </p>
        <p>
            <a href="{{ route('signup') }}" role="button" class="btn btn-lg btn-success">现在注册</a>
        </p>
    </div>
@stop