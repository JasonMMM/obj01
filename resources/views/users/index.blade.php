@extends('layouts.default')
@section('title', '用户列表')

@section('content')
<div class="col-md-offset-2 col-md-8">
    <h1>所有用户</h1>
    <ul class="users">
        @foreach($userList as $user)
            @include('layouts._user_list')
        @endforeach
    </ul>

    {!! $userList->render() !!}

</div>
@stop