@extends('layouts.app')
@section('content')
{{--  TODO:样式需要美化  --}}
<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <b>{{$user->name}}</b>的资料
                </div>
                <div class="card-body">
                    <img src="{{$user->avatar.'/avatar'}}" class="avatar-thumbnail mt-3 d-block" style="width:100px">
                    <hr>
                    <p>简介:</p>
                    <p>{{$user->intro}}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection